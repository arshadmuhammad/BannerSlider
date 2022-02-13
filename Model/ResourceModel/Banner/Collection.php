<?php


namespace Arshad\Slider\Model\ResourceModel\Banner;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'banner_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'arshad_banner_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'banner_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Arshad\Slider\Model\Banner::class, \Arshad\Slider\Model\ResourceModel\Banner::class);
    }

}
