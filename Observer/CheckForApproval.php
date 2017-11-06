<?php
/**
 * Copyright © sourabhcoder. All rights reserved.
 */
namespace Sourabh\CustomerApprove\Observer;

class CheckForApproval implements \Magento\Framework\Event\ObserverInterface
{
    /**
     *
     * @var type
     */
    protected $addForApproval;
    /**
     *
     * @var type
     */
    protected $messageManagerInterface;
    /**
     *
     * @var type
     */
    protected $httpResponse;
    /**
     *
     * @var type
     */
    protected $customerSession;
    /**
     *
     * @param \Sourabh\CustomerApprove\Model\AddForApprovalFactory $addForApproval
     * @param \Magento\Framework\Message\ManagerInterface $messageManagerInterface
     * @param \Magento\Framework\App\Response\Http $httpResponse
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
            \Sourabh\CustomerApprove\Model\AddForApprovalFactory $addForApproval,
            \Magento\Framework\Message\ManagerInterface $messageManagerInterface,
            \Magento\Framework\App\Response\Http $httpResponse,
            \Magento\Customer\Model\Session $customerSession
            ) {
           $this->addForApproval          = $addForApproval;
           $this->messageManagerInterface = $messageManagerInterface;
           $this->httpResponse            = $httpResponse;
           $this->customerSession         = $customerSession;
    }


  public function execute(\Magento\Framework\Event\Observer $observer)
  {
     $addForApproval = $this->addForApproval->create()->load($observer->getEvent()->getCustomer()->getId(),'customer_id');
     if (empty($addForApproval)) // if empty means the customer was approved, that is if the record is not found in the table
     {
         return $this;
     }
     else
     {
         if ($addForApproval->getIsApproved() == 0)
         {
             if($this->customerSession->isLoggedIn()) {
                 $this->customerSession->logout();
             }
             $this->messageManagerInterface->addWarningMessage("Account awaiting approval from admin.");
         }
     }
     return $this;
  }
}
