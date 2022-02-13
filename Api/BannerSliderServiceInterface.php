<?php


namespace Arshad\Slider\Api;

use Arshad\Slider\Api\Data\SliderInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @api
 */
interface BannerSliderServiceInterface {
    /**
     * @return SliderInterface[]
     */
    public function getSliders();

    /**
     * @param string $sliderId
     * @return SliderInterface
     * @throws NoSuchEntityException
     */
    public function getSlider($sliderId);
}
