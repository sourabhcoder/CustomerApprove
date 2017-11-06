<?php
/**
 * Copyright © sourabhcoder. All rights reserved.
 */
namespace Sourabh\CustomerApprove\Block\Adminhtml\Customer\Edit;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 * @package Magento\Customer\Block\Adminhtml\Edit
 */
class ApproveButton extends \Magento\Customer\Block\Adminhtml\Edit\GenericButton implements ButtonProviderInterface
{
    /**
     * @var AccountManagementInterface
     */
    protected $customerAccountManagement;
    /**
     *
     * @var \Sourabh\CustomerApprove\Model\AddForApprovalFactory
     */
    protected $addForApproval;
    /**
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param AccountManagementInterface $customerAccountManagement
     * @param \Sourabh\CustomerApprove\Model\AddForApprovalFactory $addForApproval
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        AccountManagementInterface $customerAccountManagement,
        \Sourabh\CustomerApprove\Model\AddForApprovalFactory $addForApproval
    ) {
        parent::__construct($context, $registry);
        $this->customerAccountManagement = $customerAccountManagement;
        $this->addForApproval          = $addForApproval;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $customerId = $this->getCustomerId();
        $checkForApproval = $this->addForApproval->create()->load($customerId,'customer_id');
        $displayTextBtn = 'Disapprove Customer'; // if record does not exists in the database then the customer is an approved customer
        $changeTo = 0; // by default if the record does not exists in the record then it is approved by default, so by default in disapprove is in the value
        if (empty($checkForApproval->getData())) // if empty means the customer was approved, that is if the record is not found in the table
        {
            $displayTextBtn = 'Disapprove Customer';
            $changeTo = 0;
        }
        else
        {
            if ($checkForApproval->getIsApproved() == 0)
            {
                $displayTextBtn = 'Approve Customer';
                $changeTo = 1;
            }
        }
        $canModify = !$customerId || !$this->customerAccountManagement->isReadonly($this->getCustomerId());
        $data = [];
        $url = "customerapprove/customerapprove/index/customerid/$customerId/changeto/$changeTo";
        $url = $this->getUrl($url);
        if ($canModify) {
            $data = [
                'label' => __($displayTextBtn),
                'class' => 'save',
                'data_attribute' => [
                    'url' => "$url"
                ],
                'on_click' => "window.location.href='".$url."'",
                'sort_order' => 80,
            ];
        }
        return $data;
    }
}
