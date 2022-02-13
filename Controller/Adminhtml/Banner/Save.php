<?php


namespace Arshad\Slider\Controller\Adminhtml\Banner;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Arshad\Slider\Controller\Adminhtml\Banner;
use Arshad\Slider\Helper\Image;
use Arshad\Slider\Model\BannerFactory;
use RuntimeException;


class Save extends Banner{

    /**
     * JS helper
     *
     * @var Js
     */
    public $jsHelper;

    /**
     * Image Helper
     *
     * @var Image
     */
    protected $imageHelper;

    /**
     * Save constructor.
     *
     * @param Image $imageHelper
     * @param BannerFactory $bannerFactory
     * @param Registry $registry
     * @param Js $jsHelper
     * @param Context $context
     */
    public function __construct(
        Image $imageHelper,
        BannerFactory $bannerFactory,
        Registry $registry,
        Js $jsHelper,
        Context $context
    ) {
        $this->imageHelper = $imageHelper;
        $this->jsHelper = $jsHelper;

        parent::__construct($bannerFactory, $registry, $context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($this->getRequest()->getPost('banner')) {
            $data = $this->getRequest()->getPost('banner');
            $banner = $this->initBanner($data['banner_id'] ?? null);
            $this->imageHelper->uploadImage($data, 'image', Image::TEMPLATE_MEDIA_TYPE_BANNER, $banner->getImage());
            /*$this->imageHelper->uploadImage($data, 'image_desktop', Image::TEMPLATE_MEDIA_TYPE_BANNER_DESKTOP, $banner->getImageDesktop());
            $this->imageHelper->uploadImage($data, 'image_tablet', Image::TEMPLATE_MEDIA_TYPE_BANNER_TABLET, $banner->getImageTablet());
            $this->imageHelper->uploadImage($data, 'image_mobile', Image::TEMPLATE_MEDIA_TYPE_BANNER_MOBILE, $banner->getImageMobile());*/

            $data['sliders_ids'] = (isset($data['sliders_ids']) && $data['sliders_ids'])
                ? explode(',', $data['sliders_ids']) : [];

            $banner->addData($data);

            $this->_eventManager->dispatch(
                'arshadslider_banner_prepare_save',
                [
                    'banner' => $banner,
                    'request' => $this->getRequest()
                ]
            );
            try {
                $banner->save();
                $this->messageManager->addSuccess(__('The Banner has been saved.'));
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        'arshadslider/*/edit',
                        [
                            'banner_id' => $banner->getId(),
                            '_current' => true
                        ]
                    );

                    return $resultRedirect;
                }
                $resultRedirect->setPath('arshadslider/*/');

                return $resultRedirect;
            } catch (RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Banner.'));
            }

            $this->_getSession()->setData('arshad_slider_banner_data', $data);
            $resultRedirect->setPath(
                'arshadslider/*/edit',
                [
                    'banner_id' => $banner->getId(),
                    '_current' => true
                ]
            );

            return $resultRedirect;
        }

        $resultRedirect->setPath('arshadslider/*/');

        return $resultRedirect;
    }

}
