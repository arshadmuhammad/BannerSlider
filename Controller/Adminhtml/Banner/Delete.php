<?php


namespace Arshad\Slider\Controller\Adminhtml\Banner;

use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Arshad\Slider\Controller\Adminhtml\Banner;

class Delete extends Banner {

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $this->bannerFactory->create()
                ->load($this->getRequest()->getParam('banner_id'))
                ->delete();
            $this->messageManager->addSuccess(__('The Banner has been deleted.'));
        } catch (Exception $e) {
            // display error message
            $this->messageManager->addErrorMessage($e->getMessage());
            // go back to edit form
            $resultRedirect->setPath(
                'arshadslider/*/edit',
                ['banner_id' => $this->getRequest()->getParam('banner_id')]
            );

            return $resultRedirect;
        }

        $resultRedirect->setPath('arshadslider/*/');

        return $resultRedirect;
    }

}
