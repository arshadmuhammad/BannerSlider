<?php


namespace Arshad\Slider\Helper;


use Arshad\Slider\Model\SliderFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Arshad\Slider\Model\ResourceModel\Banner\Collection;
use Arshad\Slider\Model\BannerFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper {

    /**
     * @var BannerFactory
     */
    public $bannerFactory;

    /**
     * @type ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var SliderFactory
     */
    private $sliderFactory;

    /**
     * @type StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var HttpContext
     */
    protected $httpContext;

    public function __construct(
        BannerFactory $bannerFactory,
        ObjectManagerInterface $objectManager,
        SliderFactory $sliderFactory,
        StoreManagerInterface $storeManager,
        HttpContext $httpContext,
        DateTime $date,
        Context $context
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->objectManager = $objectManager;
        $this->sliderFactory = $sliderFactory;
        $this->storeManager = $storeManager;
        $this->httpContext = $httpContext;
        $this->date = $date;
        parent::__construct($context);
    }

    public function versionCompare($ver, $operator = '>=')
    {
        $productMetadata = $this->objectManager->get(ProductMetadataInterface::class);
        $version = $productMetadata->getVersion(); //will return the magento version

        return version_compare($version, $ver, $operator);
    }

    public function serialize($data)
    {
        if ($this->versionCompare('2.2.0')) {
            return self::jsonEncode($data);
        }

        return $this->getSerializeClass()->serialize($data);
    }

    protected function getSerializeClass()
    {
        return $this->objectManager->get('Zend_Serializer_Adapter_PhpSerialize');
    }

    public static function jsonEncode($valueToEncode)
    {
        try {
            $encodeValue = self::getJsonHelper()->jsonEncode($valueToEncode);
        } catch (Exception $e) {
            $encodeValue = '{}';
        }

        return $encodeValue;
    }

    /**
     * @return JsonHelper|mixed
     */
    public static function getJsonHelper()
    {
        return ObjectManager::getInstance()->get(JsonHelper::class);
    }

    /**
     * @param null $id
     *
     * @return Collection
     */
    public function getBannerCollection($id = null)
    {
        $collection = $this->bannerFactory->create()->getCollection();

        $collection->join(
            ['banner_slider' => $collection->getTable('arshad_banner_slider')],
            'main_table.banner_id=banner_slider.banner_id AND banner_slider.slider_id=' . $id,
            ['position']
        );

        $collection->addOrder('position', 'ASC');

        return $collection;
    }

    public function getBannerOptions(\Arshad\Slider\Model\Slider $slider) {

        $sliderOptions = ['animateOut' => $slider->getEffect(), 'nav' => $slider->getNav(), 'dots' => $slider->getDots()];

        return self::jsonEncode($sliderOptions);
    }

    public function getActiveSliders()
    {
        /** @var \Arshad\Slider\Model\ResourceModel\Slider\Collection $collection */
        $collection = $this->sliderFactory->create()
            ->getCollection()
            ->addFieldToFilter('customer_group_ids', [
                'finset' => $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP)
            ])
            ->addFieldToFilter('status', 1);

        $collection->getSelect()
            ->where('FIND_IN_SET(0, store_ids) OR FIND_IN_SET(?, store_ids)', $this->storeManager->getStore()->getId())
            ->where('from_date is null OR from_date <= ?', $this->date->date())
            ->where('to_date is null OR to_date >= ?', $this->date->date());

        return $collection;
    }

    public function isEnabled() {
        return $this->scopeConfig->getValue('arshadslider/general/enabled');
    }

}
