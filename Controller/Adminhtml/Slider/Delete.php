<?php

namespace Arshad\Slider\Controller\Adminhtml\Slider;

use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Arshad\Slider\Controller\Adminhtml\Slider;


class Delete extends Slider
{
    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $this->sliderFactory->create()
                ->load($this->getRequest()->getParam('slider_id'))
                ->delete();
            $this->messageManager->addSuccess(__('The slider has been deleted.'));
        } catch (Exception $e) {
            // display error message
            $this->messageManager->addErrorMessage($e->getMessage());
            // go back to edit form
            $resultRedirect->setPath(
                'arshadslider/*/edit',
                ['slider_id' => $this->getRequest()->getParam('slider_id')]
            );

            return $resultRedirect;
        }

        $resultRedirect->setPath('arshadslider/*/');

        return $resultRedirect;
    }
}
