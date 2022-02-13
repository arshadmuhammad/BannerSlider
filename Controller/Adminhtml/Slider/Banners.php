<?php

namespace Arshad\Slider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Layout;
use Magento\Framework\View\Result\LayoutFactory;
use Arshad\Slider\Block\Adminhtml\Slider\Edit\Tab\Banner;
use Arshad\Slider\Controller\Adminhtml\Slider;
use Arshad\Slider\Model\SliderFactory;

class Banners extends Slider
{
    /**
     * Result layout factory
     *
     * @var LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * Banners constructor.
     *
     * @param LayoutFactory $resultLayoutFactory
     * @param SliderFactory $bannerFactory
     * @param Registry $registry
     * @param Context $context
     */
    public function __construct(
        LayoutFactory $resultLayoutFactory,
        SliderFactory $bannerFactory,
        Registry $registry,
        Context $context
    ) {
        $this->resultLayoutFactory = $resultLayoutFactory;

        parent::__construct($bannerFactory, $registry, $context);
    }

    /**
     * @return Layout
     */
    public function execute()
    {
        $this->initSlider();
        $resultLayout = $this->resultLayoutFactory->create();
        /** @var Banner $bannersBlock */
        $bannersBlock = $resultLayout->getLayout()->getBlock('arshad.slider.edit.tab.banner');
        //echo get_class($bannersBlock);exit;
        if ($bannersBlock) {
            $bannersBlock->setSliderBanners($this->getRequest()->getPost('slider_banners', null));
        }

        return $resultLayout;
    }
}
