<?php


namespace Arshad\Slider\Api\Data;


interface SliderInterface {
    /**
     * @return int
     */
    public function getSliderId();

    /**
     * @param $sliderId
     * @return $this
     */
    public function setSliderId($sliderId);


    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     * @return $this
     */
    public function setName($name);


    /**
     * @return bool
     */
    public function getStatus();

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status);


    /**
     * @return string
     */
    public function getStoreIds();

    /**
     * @param $storeIds
     * @return $this
     */
    public function setStoreIds($storeIds);

    /**
     * @return string
     */
    public function getCustomerGroupIds();

    /**
     * @param $customerGroupIds
     * @return $this
     */
    public function setCustomerGroupIds($customerGroupIds);

    /**
     * @return bool
     */
    public function getNav();

    /**
     * @param $nav
     * @return $this
     */
    public function setNav($nav);

    /**
     * @return bool
     */
    public function getDots();

    /**
     * @param $navDot
     * @return $this
     */
    public function setDots($dot);

    /**
     * @return string
     */
    public function getEffect();

    /**
     * @param $effect
     * @return $this
     */
    public function setEffect($effect);

    /**
     * @return string
     */
    public function getDisplayLocation();

    /**
     * @param $displayLocation
     * @return $this
     */
    public function setDisplayLocation($displayLocation);


    /**
     * @return string|null
     */
    public function getFromDate();

    /**
     * @param $fromDate
     * @return $this
     */
    public function setFromDate($fromDate);

    /**
     * @return string|null
     */
    public function getToDate();

    /**
     * @param $toDate
     * @return $this
     */
    public function setToDate($toDate);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);


    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * @return \Arshad\Slider\Api\Data\BannerInterface[]
     */
    public function getBanners();

}
