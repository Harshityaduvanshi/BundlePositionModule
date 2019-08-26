<?php

namespace Ced\BundlePosition\Model;

use Magento\Framework\Model\AbstractModel;

class Selection extends AbstractModel
{
    public function _construct()
    {
        $this->_init(ResourceModel\Selection::class);
    }
}
