<?php


namespace Arshad\Slider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Arshad\Slider\Controller\Adminhtml\Banner;
use Arshad\Slider\Model\BannerFactory;


class Edit extends Banner
{
    const ADMIN_RESOURCE = 'Arshad_Slider::banner';

    /**
     * Page factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Edit constructor.
     *
     * @param PageFactory $resultPageFactory
     * @param BannerFactory $bannerFactory
     * @param Registry $registry
     * @param Context $context
     */
    public function __construct(
        PageFactory $resultPageFactory,
        BannerFactory $bannerFactory,
        Registry $registry,
        Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($bannerFactory, $registry, $context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|ResponseInterface|Redirect|ResultInterface|Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('banner_id');
        /** @var \Arshad\Slider\Model\Banner $banner */
        $banner = $this->initBanner();

        if ($id) {
            $banner->load($id);
            if (!$banner->getId()) {
                $this->messageManager->addError(__('This Banner no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath(
                    'mpbannerslider/*/edit',
                    [
                        'banner_id' => $id,
                        '_current' => true
                    ]
                );

                return $resultRedirect;
            }
        }

        $data = $this->_session->getData('arshadslider_banner_data', true);
        if (!empty($data)) {
            $banner->setData($data);
        }

        /** @var \Magento\Backend\Model\View\Result\Page|Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Arshad_Slider::banner');
        $resultPage->getConfig()->getTitle()
            ->set(__('Banners'))
            ->prepend($banner->getId() ? $banner->getName() : __('New Banner'));

        return $resultPage;
    }
}

