<?php


namespace Arshad\Slider\Model\ResourceModel;


use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Arshad\Slider\Helper\Data as bannerHelper;

class Slider extends AbstractDb {

    /**
     * Date model
     *
     * @var DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected string $sliderBannerTable;

    /**
     * Event Manager
     *
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @var bannerHelper
     */
    protected $bannerHelper;

    public function __construct(
        DateTime $date,
        ManagerInterface $eventManager,
        Context $context,
        bannerHelper $helperData,
        $connectionName = null
    )
    {
        $this->date = $date;
        $this->eventManager = $eventManager;
        $this->bannerHelper = $helperData;

        parent::__construct($context, $connectionName);
        $this->sliderBannerTable = $this->getTable('arshad_banner_slider');
    }

    protected function _construct() {
        $this->_init('arshad_slider','slider_id');
    }

    /**
     * Retrieves Slider Name from DB by passed id.
     *
     * @param $id
     *
     * @return string
     * @throws LocalizedException
     */
    public function getSliderNameById($id)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()
            ->from($this->getMainTable(), 'name')
            ->where('slider_id = :slider_id');
        $binds = ['slider_id' => (int)$id];

        return $adapter->fetchOne($select, $binds);
    }


    protected function _beforeSave(AbstractModel $object)
    {
        //set default Update At and Create At time post
        $object->setUpdatedAt($this->date->date());
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->date->date());
        }

        $location = $object->getData('display_location');
        if (is_array($location)) {
            $object->setDisplayLocation(implode(',', $location));
        }

        $storeIds = $object->getData('store_ids');
        if (is_array($storeIds)) {
            $object->setStoreIds(implode(',', $storeIds));
        }

        $groupIds = $object->getData('customer_group_ids');
        if (is_array($groupIds)) {
            $object->setCustomerGroupIds(implode(',', $groupIds));
        }

        return parent::_beforeSave($object);
    }


    protected function _afterSave(AbstractModel $object)
    {
        $this->saveBannerRelation($object);

        return parent::_afterSave($object);
    }

    /**
     * @param AbstractModel $object
     * @return $this|Slider
     */
    protected function _afterLoad(AbstractModel $object)
    {
        parent::_afterLoad($object);

        if ($object->getResponsiveItems() !== null) {
            $object->setResponsiveItems($this->bannerHelper->unserialize($object->getResponsiveItems()));
        } else {
            $object->setResponsiveItems(null);
        }

        return $this;
    }

    /**
     * @param \Arshad\Slider\Model\Slider $slider
     * @return array
     */
    public function getBannersPosition(\Arshad\Slider\Model\Slider $slider)
    {
        $select = $this->getConnection()->select()->from(
            $this->sliderBannerTable,
            ['banner_id', 'position']
        )
            ->where(
                'slider_id = :slider_id'
            );
        $bind = ['slider_id' => (int)$slider->getId()];

        return $this->getConnection()->fetchPairs($select, $bind);
    }


    protected function saveBannerRelation(\Arshad\Slider\Model\Slider $slider)
    {
        $slider->setIsChangedBannerList(false);
        $id = $slider->getId();
        $banners = $slider->getBannersData();
        if ($banners === null) {
            return $this;
        }
        $oldBanners = $slider->getBannersPosition();
        $insert = array_diff_key($banners, $oldBanners);
        $delete = array_diff_key($oldBanners, $banners);
        $update = array_intersect_key($banners, $oldBanners);
        $_update = [];
        foreach ($update as $key => $settings) {
            if (isset($oldBanners[$key]) && $oldBanners[$key] != $settings['position']) {
                $_update[$key] = $settings;
            }
        }
        $update = $_update;
        $adapter = $this->getConnection();
        if (!empty($delete)) {
            $condition = ['banner_id IN(?)' => array_keys($delete), 'slider_id=?' => $id];
            $adapter->delete($this->sliderBannerTable, $condition);
        }
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $bannerId => $position) {
                $data[] = [
                    'slider_id' => (int)$id,
                    'banner_id' => (int)$bannerId,
                    'position' => (int)$position['position']
                ];
            }
            $adapter->insertMultiple($this->sliderBannerTable, $data);
        }
        if (!empty($update)) {
            foreach ($update as $bannerId => $position) {
                $where = ['slider_id = ?' => (int)$id, 'banner_id = ?' => (int)$bannerId];
                $bind = ['position' => (int)$position['position']];
                $adapter->update($this->sliderBannerTable, $bind, $where);
            }
        }
        if (!empty($insert) || !empty($delete)) {
            $bannerIds = array_unique(array_merge(array_keys($insert), array_keys($delete)));
            $this->eventManager->dispatch(
                'mageplaza_bannerslider_slider_after_save_banners',
                ['slider' => $slider, 'banner_ids' => $bannerIds]
            );
        }
        if (!empty($insert) || !empty($update) || !empty($delete)) {
            $slider->setIsChangedBannerList(true);
            $bannerIds = array_keys($insert + $delete + $update);
            $slider->setAffectedBannerIds($bannerIds);
        }

        return $this;
    }



}
