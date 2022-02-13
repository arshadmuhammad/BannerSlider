<?php


namespace Arshad\Slider\Model\ResourceModel\Slider;


use Magento\Framework\DB\Select;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'slider_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'arshad_slider_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'slider_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Arshad\Slider\Model\Slider::class, \Arshad\Slider\Model\ResourceModel\Slider::class);
    }

    /**
     * add if filter
     *
     * @param $sliderIds
     *
     * @return $this
     */
    public function addIdFilter($sliderIds)
    {
        $condition = '';

        if (is_array($sliderIds)) {
            if (!empty($sliderIds)) {
                $condition = ['in' => $sliderIds];
            }
        } elseif (is_numeric($sliderIds)) {
            $condition = $sliderIds;
        } elseif (is_string($sliderIds)) {
            $ids = explode(',', $sliderIds);
            if (empty($ids)) {
                $condition = $sliderIds;
            } else {
                $condition = ['in' => $ids];
            }
        }

        if ($condition !== '') {
            $this->addFieldToFilter('slider_id', $condition);
        }

        return $this;
    }

    public function addActiveFilter($customerGroup = null, $storeId = null)
    {
        $this->addFieldToFilter('status', true);

        if (isset($customerGroup)) {
            $this->getSelect()
                ->where('FIND_IN_SET(0, customer_group_ids) OR FIND_IN_SET(?, customer_group_ids)', $customerGroup);
        }

        if (isset($storeId)) {
            $this->getSelect()
                ->where('FIND_IN_SET(0, store_ids) OR FIND_IN_SET(?, store_ids)', $storeId);
        }

        return $this;
    }

}
