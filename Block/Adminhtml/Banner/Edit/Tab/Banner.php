<?php


namespace Arshad\Slider\Block\Adminhtml\Banner\Edit\Tab;


use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Config\Model\Config\Source\Enabledisable;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Arshad\Slider\Block\Adminhtml\Banner\Edit\Tab\Render\Image as BannerImage;
use Arshad\Slider\Block\Adminhtml\Banner\Edit\Tab\Render\Slider;
use Arshad\Slider\Helper\Image as HelperImage;

class Banner extends Generic implements TabInterface {


    /**
     * Status options
     *
     * @var Enabledisable
     */
    protected $statusOptions;

    /**
     * @var HelperImage
     */
    protected $imageHelper;


    /**
     * @param Enabledisable $statusOptions
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param HelperImage $imageHelper
     * @param FieldFactory $fieldFactory
     * @param array $data
     */
    public function __construct(
        Enabledisable $statusOptions,
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        HelperImage $imageHelper,
        array $data = []
    ) {
        $this->statusOptions = $statusOptions;
        $this->imageHelper = $imageHelper;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('General');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return Generic
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        /** @var \Arshad\Slider\Model\Banner $banner */
        $banner = $this->_coreRegistry->registry('arshadslider_banner');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('banner_');
        $form->setFieldNameSuffix('banner');
        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('Banner Information'),
            'class' => 'fieldset-wide'
        ]);

        if ($banner->getId()) {
            $fieldset->addField(
                'banner_id',
                'hidden',
                ['name' => 'banner_id']
            );
        }

        $fieldset->addField('status', 'select', [
            'name' => 'status',
            'label' => __('Status'),
            'title' => __('Status'),
            'values' => $this->statusOptions->toOptionArray(),
        ]);

        $fieldset->addField('image', BannerImage::class, [
            'name' => 'image',
            'label' => __('Image'),
            'title' => __('Image'),
            'path' => $this->imageHelper->getBaseMediaPath(HelperImage::TEMPLATE_MEDIA_TYPE_BANNER)
        ]);


        /*$fieldset->addField('image_desktop', BannerImageDesktop::class, [
            'name' => 'image_desktop',
            'label' => __('Desktop Image'),
            'title' => __('Desktop Image'),
            'path' => $this->imageHelper->getBaseMediaPath(HelperImage::TEMPLATE_MEDIA_TYPE_BANNER_DESKTOP)
        ]);

        $fieldset->addField('image_tablet', BannerImageTablet::class, [
            'name' => 'image_tablet',
            'label' => __('Tablet Image'),
            'title' => __('Tablet Image'),
            'path' => $this->imageHelper->getBaseMediaPath(HelperImage::TEMPLATE_MEDIA_TYPE_BANNER_TABLET)
        ]);

        $fieldset->addField('image_mobile', BannerImageMobile::class, [
            'name' => 'image_mobile',
            'label' => __('Mobile Image'),
            'title' => __('Mobile Image'),
            'path' => $this->imageHelper->getBaseMediaPath(HelperImage::TEMPLATE_MEDIA_TYPE_BANNER_MOBILE)
        ]);*/

        $fieldset->addField('title', 'text', [
            'name' => 'title',
            'label' => __('Banner title'),
            'title' => __('Banner title'),
        ]);

        $fieldset->addField('alt_text', 'text', [
            'name' => 'alt_text',
            'label' => __('Alt text'),
            'title' => __('Alt text'),
        ]);

        $fieldset->addField('url', 'text', [
            'name' => 'url',
            'label' => __('Url'),
            'title' => __('Url'),
            'class' => 'validate-url validate-no-html-tags'
        ]);

        $fieldset->addField('sliders_ids', Slider::class, [
            'name' => 'sliders_ids',
            'label' => __('Sliders'),
            'title' => __('Sliders'),
        ]);
        if (!$banner->getSlidersIds()) {
            $banner->setSlidersIds($banner->getSliderIds());
        }

        $bannerData = $this->_session->getData('arshadslider_banner_data', true);
        if ($bannerData) {
            $banner->addData($bannerData);
        } /*else {
            if (!$banner->getId()) {
                $banner->addData($banner->getDefaultValues());
            }
        }*/

        $form->addValues($banner->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
