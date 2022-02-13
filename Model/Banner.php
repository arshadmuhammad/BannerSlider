<?php


namespace Arshad\Slider\Model;


use Arshad\Slider\Api\Data\BannerInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Arshad\Slider\Model\Config\Source\Image as configImage;

class Banner extends AbstractModel implements IdentityInterface, BannerInterface {

    /**
     * @var configImage
     */
    protected $imageModel;

    /**
     * @var string
     */
    const CACHE_TAG = 'arshad_slider_banner';

    /**
     * @var string
     */
    protected $_cacheTag = 'arshad_slider_banner';

    /**
     * @var string
     */
    protected $_eventPrefix = 'arshad_slider_banner';

    public function __construct(
        \Magento\Framework\Model\Context $context,
        configImage $configImage,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->imageModel = $configImage;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }


    protected function _construct() {
        $this->_init(ResourceModel\Banner::class);
    }


    /**
     * @return int
     */
    public function getBannerId(): int {
        return $this->getData('banner_id');
    }

    /**
     * @param $bannerId
     * @return Banner
     */
    public function setBannerId($bannerId) {
        return $this->setData('slider_id', $bannerId);
    }

    /**
     * @return string
     */
    public function getTitle() : string {
        return $this->getData('title');
    }

    /**
     * @param $title
     * @return Banner
     */
    public function setTitle($title) {
        return $this->setData('title', $title);
    }

    /**
     * @return bool
     */
    public function getStatus() : bool {
        return $this->getData('status');
    }

    /**
     * @param $status
     * @return Banner
     */
    public function setStatus($status) {
        return $this->setData('status', $status);
    }

    /**
     * @return string
     */
    public function getAltText() : string {
        return $this->getData('alt_text');
    }

    /**
     * @param $altText
     * @return Banner
     */
    public function setAltText($altText) {
        return $this->setData('alt_text', $altText);
    }

    /**
     * @return string
     */
    public function getUrl() : string {
        return $this->getData('url');
    }

    /**
     * @param $url
     * @return Banner
     */
    public function setUrl($url) {
        return $this->setData('url', $url);
    }

    /**
     * @return string|null
     */
    public function getImage() : string {
        return $this->getData('image');
    }

    /**
     * @param $image
     * @return Banner
     */
    public function setImage($image) {
        return $this->setData('image', $image);
    }

//    /**
//     * @return string|null
//     */
//    public function getImageDesktop() : string {
//        return $this->getData('image_desktop');
//    }
//
//    /**
//     * @param $imageDesktop
//     * @return Banner
//     */
//    public function setImageDesktop($imageDesktop) {
//        return $this->setData('image_desktop', $imageDesktop);
//    }
//
//    /**
//     * @return string
//     */
//    public function getImageTablet() : string {
//        return $this->getData('image_tablet');
//    }
//
//    /**
//     * @param $imageTablet
//     * @return Banner
//     */
//    public function setImageTablet($imageTablet) {
//        return $this->setData('image_tablet', $imageTablet);
//    }
//
//    /**
//     * @return string
//     */
//    public function getImageMobile(): string {
//        return $this->getData('image_mobile');
//    }
//
//    /**
//     * @param $imageMobile
//     * @return Banner
//     */
//    public function setImageMobile($imageMobile) {
//        return $this->setData('image_mobile', $imageMobile);
//    }

    /**
     * @return string
     */
    public function getCreatedAt() : string {
        return $this->getData('created_at');
    }

    /**
     * @param $createdAt
     * @return Banner
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
     * @return Banner
     */
    public function setUpdatedAt($updatedAt) {
        return $this->setData('updated_at', $updatedAt);
    }

    /**
     * @return string[]
     */
    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getSliderIds()
    {
        if (!$this->hasData('slider_ids')) {
            $ids = $this->getResource()->getSliderIds($this);

            $this->setData('slider_ids', $ids);
        }

        return (array)$this->getData('slider_ids');
    }

    public function getImageUrl()
    {
        return $this->imageModel->getBaseUrl() . $this->getImage();
    }
}
