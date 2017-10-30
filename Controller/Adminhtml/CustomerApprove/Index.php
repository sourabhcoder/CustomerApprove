<?php


namespace Sourabh\CustomerApprove\Controller\Adminhtml\CustomerApprove;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    
    protected $addForApproval;
    
    protected $httpResponse;
    public function __construct(
        Context $context,
        \Sourabh\CustomerApprove\Model\AddForApprovalFactory $addForApproval,
        \Magento\Framework\App\Response\Http $httpResponse
    )
    {
        parent::__construct($context);
        $this->addForApproval = $addForApproval;
        $this->httpResponse   = $httpResponse;
       
    }

    /**
     * Index action
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $customerId = $this->_request->getParam('customerid');
        $changeTo   = $this->_request->getParam('changeto');
        
        $addForApprovalData = $this->addForApproval->create()->load($customerId,'customer_id');
        if(empty($addForApprovalData->getData())) // if the record does not exists in the database
        {
            $addForApprovalData = $this->addForApproval->create();
            $addForApprovalData->setCustomerId($customerId);
            $addForApprovalData->setIsApproved($changeTo);
            $addForApprovalData->save();
        }
        else
        {
            $addForApprovalData->setCustomerId($customerId);
            $addForApprovalData->setIsApproved($changeTo);
            $addForApprovalData->save();
        }
        $this->messageManager->addSuccessMessage('Record Updated Succesfully');
        $url = $this->getUrl("customer/index/edit/id/$customerId");
        $this->httpResponse->setRedirect($url);
    }
}
