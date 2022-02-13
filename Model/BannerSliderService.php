<?php


namespace Arshad\Slider\Model;


use Arshad\Slider\Api\BannerSliderServiceInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Arshad\Slider\Helper\Data;
use Arshad\Slider\Model\ResourceModel\Slider;
use Arshad\Slider\Model\SliderFactory;

class BannerSliderService implements BannerSliderServiceInterface {

    /**
     * @var Slider
     */
    private $sliderResource;

    /**
     * @var Slider\Collection
     */
    private $sliderCollection;

    /**
     * @var SliderFactory
     */
    private $sliderFactory;

    /**
     * @var Data
     */
    private $sliderHelper;

    private $sliderDataMap = [
        'autoWidth' => 'auto_width',
        'autoHeight' => 'auto_height',
        'lazyLoad' => 'lazy_load',
        'autoplayTimeout' => 'autoplay_timeout',
    ];

    public function __construct(
        Slider $sliderResource,
        Slider\Collection $sliderCollection,
        SliderFactory $sliderFactory,
        Data $sliderHelper,
        UrlInterface $urlBuilder
    ) {
        $this->sliderResource = $sliderResource;
        $this->sliderCollection = $sliderCollection;
        $this->sliderFactory = $sliderFactory;
        $this->sliderHelper = $sliderHelper;
    }

    public function getSliders()
    {
        $sliders = $this->sliderHelper->getActiveSliders()->getItems();

        foreach ($sliders as $slider) {
            //$this->_mapSliderData($slider);
            $this->_addBanners($slider);
        }

        return $sliders;
    }

    private function _mapSliderData($slider)
    {
        foreach ($this->sliderDataMap as $key => $value) {
            $slider->setData($value, $slider->getData($key));
        }
    }

    private function _addBanners($slider)
    {
        $banners = $this->sliderHelper
            ->getBannerCollection($slider->getId())
            ->addFieldToFilter('status', 1);

        $slider->setBanners($banners->getItems());

        return $slider;
    }

    public function getSlider($sliderId)
    {
        $slider = $this->sliderFactory->create();

        $this->sliderResource->load($slider, $sliderId);

        if (!$slider->getId()) {
            throw new NoSuchEntityException(__('No slider with ID = %1', $sliderId));
        }

        $this->_mapSliderData($slider);
        $this->_addBanners($slider);

        return $slider;
    }
}
