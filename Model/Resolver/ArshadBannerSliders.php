<?php


namespace Arshad\Slider\Model\Resolver;


use Arshad\Slider\Helper\Data;
use Arshad\Slider\Model\ResourceModel\Slider\Collection;
use Arshad\Slider\Model\SliderFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;


class ArshadBannerSliders implements ResolverInterface {


    /**
     * @var \Arshad\Slider\Model\ResourceModel\Slider
     */
    private $sliderResource;

    /**
     * @var Collection
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

    private $bannersData = [];

    public function __construct(
        \Arshad\Slider\Model\ResourceModel\Slider $sliderResource,
        Collection $sliderCollection,
        SliderFactory $sliderFactory,
        Data $sliderHelper
    ) {
        $this->sliderResource = $sliderResource;
        $this->sliderCollection = $sliderCollection;
        $this->sliderFactory = $sliderFactory;
        $this->sliderHelper = $sliderHelper;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $slider = $this->getSlider($args['sliderId']);

        $data = [
            "slider_id" => $slider->getId(),
            "name" => $slider->getName(),
            "status" => $slider->getStatus(),
            "store_ids" => $slider->getStoreIds(),
            "customer_group_ids" => $slider->getCustomerGroupIds(),
            "nav" => $slider->getNav(),
            "dots" => $slider->getDots(),
            "effect" => $slider->getEffect(),
            "display_location" => $slider->getDisplayLocation(),
            "from_date" => $slider->getFromDate(),
            "to_date" => $slider->getToDate(),
            "created_at" => $slider->getCreatedAt(),
            "updated_at" => $slider->getUpdatedAt(),
            "banners" => $this->bannersData

        ];

        return $data;

    }

    public function getSlider($sliderId) {
        $slider = $this->sliderFactory->create();

        $this->sliderResource->load($slider, $sliderId);

        if (!$slider->getId()) {

        }

        $this->_addBanners($slider);

        return $slider;
    }


    private function _addBanners($slider)
    {
        $banners = $this->sliderHelper
            ->getBannerCollection($slider->getId())
            ->addFieldToFilter('status', 1);



        foreach ($banners as $banner){
            $this->bannersData[] = [
                "banner_id"=> $banner->getBannerId(),
                "title"=> $banner->getTitle(),
                "alt_text"=> $banner->getAltText(),
                "url"=> $banner->getUrl(),
                "image"=> $banner->getImage(),
                "status"=> $banner->getStatus(),
                "created_at"=> $banner->getCreatedAt(),
                "updated_at"=> $banner->getUpdatedAt()
            ];
        }

        return $slider;
    }
}
