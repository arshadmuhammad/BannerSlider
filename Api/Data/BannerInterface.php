<?php

declare(strict_types=1);


namespace Arshad\Slider\Api\Data;


interface BannerInterface {
    /**
     * @return int
     */
    public function getBannerId();

    /**
     * @param $bannerId
     * @return $this
     */
    public function setBannerId($bannerId);


    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title);


    /**
     * @return string
     */
    public function getAltText();

    /**
     * @param $altText
     * @return $this
     */
    public function setAltText($altText);


    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * @return string|null
     */
    public function getImage();

    /**
     * @param $image
     * @return $this
     */
    public function setImage($image);

//    /**
//     * @return string
//     */
//    public function getImageDesktop();
//
//    /**
//     * @param $imageDesktop
//     * @return $this
//     */
//    public function setImageDesktop($imageDesktop);
//
//
//    /**
//     * @return string
//     */
//    public function getImageTablet();
//
//    /**
//     * @param $imageTablet
//     * @return $this
//     */
//    public function setImageTablet($imageTablet);
//
//    /**
//     * @return string
//     */
//    public function getImageMobile();
//
//    /**
//     * @param $imageMobile
//     * @return $this
//     */
//    public function setImageMobile($imageMobile);

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

}
