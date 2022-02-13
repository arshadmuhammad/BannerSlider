<?php


namespace Arshad\Slider\Controller\Adminhtml;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Arshad\Slider\Model\BannerFactory;

abstract class Banner extends Action {

    /**
     * @var BannerFactory
     */
    protected $bannerFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var RedirectFactory
     */

    /**
     * constructor
     *
     * @param BannerFactory $bannerFactory
     * @param Registry $coreRegistry
     * @param Context $context
     */
    public function __construct(
        BannerFactory $bannerFactory,
        Registry $coreRegistry,
        Context $context
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /**
     * Init Banner
     *
     * @return \Arshad\Slider\Model\Banner
     */
    protected function initBanner($banner_id = null)
    {
        if($banner_id != null){
            $bannerId = $banner_id;
        }else {
            $bannerId = (int)$this->getRequest()->getParam('banner_id');
        }
        /** @var \Arshad\Slider\Model\Banner $banner */
        $banner = $this->bannerFactory->create();
        if ($bannerId) {
            $banner->load($bannerId);
            if (!$banner->getId()) {
                throw new LocalizedException(__('The wrong banner is specified.'));
            }
        }
        if($banner_id == null){
            $banner->setImage('');
        }
        $this->coreRegistry->register('arshadslider_banner', $banner);

        return $banner;
    }

}
