<?php

namespace Ced\BundlePosition\Model\ResourceModel\Selection;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(\Ced\BundlePosition\Model\Selection::class, \Ced\BundlePosition\Model\ResourceModel\Selection::class);
    }
}
