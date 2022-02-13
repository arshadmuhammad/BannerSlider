<?php


namespace Arshad\Slider\Model;


use Arshad\Slider\Api\Data\SliderInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Slider extends AbstractModel implements IdentityInterface, SliderInterface {

    /**
     * @var string
     */
    const CACHE_TAG = 'arshad_slider_slider';

    /**
     * @var string
     */
    protected $_cacheTag = 'arshad_slider_slider';

    /**
     * @var string
     */
    protected $_eventPrefix = 'arshad_slider_slider';


    protected function _construct() {
        $this->_init(ResourceModel\Slider::class);
    }

    /**
     * @return string[]
     */
    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return int
     */
    public function getSliderId() : int{
        return $this->getData('slider_id');
    }

    /**
     * @param $sliderId
     * @return Slider
     */
    public function setSliderId($sliderId) {
        return $this->setData('slider_id', $sliderId);
    }

    /**
     * @return string
     */
    public function getName() : string {
        return  $this->getData('name');
    }

    /**
     * @param $name
     * @return Slider
     */
    public function setName($name) {
        return $this->setData('name', $name);
    }

    /**
     * @return bool
     */
    public function getStatus() : bool {
        return $this->getData('status');
    }

    /**
     * @param $status
     * @return Slider
     */
    public function setStatus($status) {
        return $this->setData('status', $status);
    }

    /**
     * @return bool
     */
    public function getNav() : bool {
        return $this->getData('nav');
    }

    /**
     * @param $nav
     * @return Slider
     */
    public function setNav($nav) {
        return $this->setData('nav', $nav);
    }

    /**
     * @return bool
     */
    public function getDots() : bool {
        return $this->getData('dots');
    }

    /**
     * @param $dot
     * @return Slider
     */
    public function setDots($dot) {
        return $this->setData('dots', $dot);
    }

    /**
     * @return string|null
     */
    public function getDisplayLocation() : string {
        return $this->getData('display_location');
    }

    /**
     * @param $displayLocation
     * @return Slider
     */
    public function setDisplayLocation($displayLocation) {
        return $this->setData('display_location', $displayLocation);
    }

    /**
     * @return string
     */
    public function getCreatedAt() : string {
        return $this->getData('created_at');
    }

    /**
     * @param $createdAt
     * @return Slider
     */
    public function setCreatedAt($createdAt) {
        return $this->setData('created_at', $createdAt);
    }


    /**
     * @return string
     */
    public function getUpdatedAt() : string {
        return $this->getData('updated_at');
    }

    /**
     * @param $updatedAt
     * @return Slider
     */
    public function setUpdatedAt($updatedAt) {
        return $this->setData('updated_at', $updatedAt);
    }

    /**
     * @return string
     */
    public function getStoreIds(): string {
        return $this->getData('store_ids');
    }

    /**
     * @param $storeIds
     * @return Slider
     */
    public function setStoreIds($storeIds)
    {
        return $this->setData('store_ids', $storeIds);
    }

    /**
     * @return string
     */
    public function getCustomerGroupIds() : string
    {
        return $this->getData('customer_group_ids');
    }

    /**
     * @param $customerGroupIds
     * @return Slider
     */
    public function setCustomerGroupIds($customerGroupIds)
    {
        return $this->setData('customer_group_ids', $customerGroupIds);
    }

    /**
     * @return string|null
     */
    public function getFromDate(): ?string
    {
        return $this->getData('from_date');
    }

    /**
     * @param $fromDate
     * @return Slider
     */
    public function setFromDate($fromDate)
    {
        return $this->setData('from_date', $fromDate);
    }

    /**
     * @return string|null
     */
    public function getToDate(): ?string
    {
        return $this->getData('to_date');
    }

    /**
     * @param $toDate
     * @return Slider
     */
    public function setToDate($toDate) {
        return $this->setData('to_date', $toDate);
    }

    /**
     * @return array|mixed
     */
    public function getBannersPosition()
    {
        if (!$this->getId()) {
            return [];
        }

        $array = $this->getData('banners_position');
        if ($array === null) {
            $array = $this->getResource()->getBannersPosition($this);
            $this->setData('banners_position', $array);
        }

        return $array;
    }


    /**
     * @return string
     */
    public function getEffect() : string {
        return $this->getData('effect');
    }

    /**
     * @param $effect
     * @return Slider
     */
    public function setEffect($effect) {
        return $this->setData('effect', $effect);
    }

    /**
     * @return \Arshad\Slider\Api\Data\BannerInterface[]
     */
    public function getBanners() {
        return $this->getData('banners');
    }

}
