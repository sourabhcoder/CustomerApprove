<?php
/**
 * Copyright © sourabhcoder. All rights reserved.
 */
namespace Sourabh\CustomerApprove\Observer;

class AddForApproval implements \Magento\Framework\Event\ObserverInterface
{
    protected $addForApproval;

    public function __construct(\Sourabh\CustomerApprove\Model\AddForApprovalFactory $addForApproval) {
           $this->addForApproval = $addForApproval;
    }


  public function execute(\Magento\Framework\Event\Observer $observer)
  {
     $addForApproval = $this->addForApproval->create();
     $customerId = $observer->getEvent()->getCustomer()->getId();
     $addForApproval->setCustomerId($customerId);
     $addForApproval->setIsApproved(0);
     $addForApproval->save();
     return $this;
  }
}
