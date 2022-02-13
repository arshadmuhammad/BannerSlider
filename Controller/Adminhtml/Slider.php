<?php


namespace Arshad\Slider\Controller\Adminhtml;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Arshad\Slider\Model\SliderFactory;

abstract class Slider extends Action {

    /**
     * @var SliderFactory
     */
    protected $sliderFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var RedirectFactory
     */

    /**
     * Slider constructor.
     * @param SliderFactory $sliderFactory
     * @param Registry $coreRegistry
     * @param Context $context
     */
    public function __construct(
        SliderFactory $sliderFactory,
        Registry $coreRegistry,
        Context $context
    ) {
        $this->sliderFactory = $sliderFactory;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /**
     * Init Banner
     *
     * @return \Arshad\Slider\Model\Banner
     * @throws LocalizedException
     */
    protected function initSlider()
    {
        $sliderId = (int)$this->getRequest()->getParam('slider_id');
        $slider = $this->sliderFactory->create();
        if ($sliderId) {
            $slider->load($sliderId);
            if (!$slider->getId()) {
                throw new LocalizedException(__('The wrong slider is specified.'));
            }
        }
        $this->coreRegistry->register('arshadslider_slider', $slider);

        return $slider;
    }

}
