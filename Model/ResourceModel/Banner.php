<?php


namespace Arshad\Slider\Model\ResourceModel;


use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb {

    /**
     * @var string
     */
    protected string $bannerSliderTable;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $connectionName = null)
    {
        parent::__construct($context, $connectionName);
        $this->bannerSliderTable = $this->getTable('arshad_banner_slider');
    }

    protected function _construct() {
        $this->_init('arshad_banner','banner_id');
    }


    protected function _afterSave(AbstractModel $object): Banner
    {
        $this->saveSliderRelation($object);

        return parent::_afterSave($object);
    }

    protected function saveSliderRelation(\Arshad\Slider\Model\Banner $banner)
    {
        $id = $banner->getId();
        $sliders = $banner->getSlidersIds();
        if ($sliders === null) {
            return $this;
        }
        $oldSliders = $banner->getSliderIds();

        $insert = array_diff($sliders, $oldSliders);
        $delete = array_diff($oldSliders, $sliders);
        $adapter = $this->getConnection();

        if (!empty($delete)) {
            $condition = ['slider_id IN(?)' => $delete, 'banner_id=?' => $id];
            $adapter->delete($this->bannerSliderTable, $condition);
        }
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $tagId) {
                $data[] = [
                    'banner_id' => (int)$id,
                    'slider_id' => (int)$tagId,
                    'position' => 1
                ];
            }
            $adapter->insertMultiple($this->bannerSliderTable, $data);
        }

        return $this;
    }

    public function getSliderIds(\Arshad\Slider\Model\Banner $banner)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()
            ->from($this->bannerSliderTable, 'slider_id')
            ->where('banner_id = ?', (int)$banner->getId());

        return $adapter->fetchCol($select);
    }
}
