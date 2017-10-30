<?php

namespace Sourabh\CustomerApprove\Model\ResourceModel\AddForApproval;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Sourabh\CustomerApprove\Model\AddForApproval', 'Sourabh\CustomerApprove\Model\ResourceModel\AddForApproval');
    }
}
?>