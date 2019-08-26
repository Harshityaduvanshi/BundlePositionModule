<?php

namespace Ced\BundlePosition\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Selection extends AbstractDb
{
    public function _construct()
    {
        $this->_init("catalog_product_bundle_selection", "selection_id");
    }
}