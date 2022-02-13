<?php


namespace Arshad\Slider\Ui\Component\Listing\Column;

use Exception;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\DataObject;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Arshad\Slider\Model\Config\Source\Image;


class Content extends Column
{
    /**
     * @var FilterProvider
     */
    public $filterProvider;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Image
     */
    protected $imageModel;

    /**
     * Content constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param FilterProvider $filterProvider
     * @param UrlInterface $urlBuilder
     * @param Image $imageModel
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        FilterProvider $filterProvider,
        UrlInterface $urlBuilder,
        Image $imageModel,
        array $components = [],
        array $data = []
    ) {
        $this->filterProvider = $filterProvider;
        $this->urlBuilder = $urlBuilder;
        $this->imageModel = $imageModel;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     *
     * @return array
     * @throws Exception
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $path = $this->imageModel->getBaseUrl();
            foreach ($dataSource['data']['items'] as & $item) {
                //                 http://ubuntu-16-docker.test/media/arshad/slider/banner/image/d/e/demo3_2.jpg
                $banner = new DataObject($item);
                $item[$fieldName . '_src'] = $path . $item['image'];

                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'arshadslider/banner/edit',
                    ['banner_id' => $banner->getBannerId(), 'store' => $this->context->getRequestParam('store')]
                );
            }
        }

        return $dataSource;
    }
}

