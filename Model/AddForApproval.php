<?php

namespace Sourabh\CustomerApprove\Model;

class AddForApproval extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Sourabh\CustomerApprove\Model\ResourceModel\AddForApproval');
    }
}
?>