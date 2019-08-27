<?php

namespace Ced\BundlePosition\Ui\DataProvider;

use Ced\BundlePosition\Model\ResourceModel\Selection\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class BundlePosition extends AbstractDataProvider
{
    protected $collection;
    /**
     * @var \Magento\Ui\DataProvider\AddFieldToCollectionInterface[]
     */
    protected $addFieldStrategies;
    /**
     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
     */
    protected $addFilterStrategies;

    /**
     * Construct
     *
     * @param string $name Component name
     * @param string $primaryFieldName Primary field Name
     * @param string $requestFieldName Request field name
     * @param CollectionFactory $collectionFactory The collection factory
     * @param \Magento\Ui\DataProvider\AddFieldToCollectionInterface[] $addFieldStrategies Add field Strategy
     * @param \Magento\Ui\DataProvider\AddFilterToCollectionInterface[] $addFilterStrategies Add filter Strategy
     * @param array $meta Component Meta
     * @param array $data Component extra data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
        $this->collection->getSelect()->joinLeft(
            ["product_varchar" => $this->collection->getTable("catalog_product_entity_varchar")],
            'product_varchar.entity_id = main_table.product_id AND product_varchar.attribute_id = 73',
            []
        )->columns(['product_name' => 'product_varchar.value']);
    }
    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $items = $this->getCollection()->toArray();
        return $items;
    }
    public function addField($field, $alias = null)
    {
        if (isset($this->addFieldStrategies[$field])) {
            $this->addFieldStrategies[$field]->addField($this->getCollection(), $field, $alias);
            return;
        }
        parent::addField($field, $alias);
    }
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        if (isset($this->addFilterStrategies[$filter->getField()])) {
            $this->addFilterStrategies[$filter->getField()]
                ->addFilter(
                    $this->getCollection(),
                    $filter->getField(),
                    [$filter->getConditionType() => $filter->getValue()]
                );
            return;
        }
        parent::addFilter($filter);
    }
}
