<?php

namespace Arshad\Slider\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Arshad\Slider\Model\ResourceModel\Slider\CollectionFactory;


class SlidersWidget implements ArrayInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * SlidersWidget constructor.
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->toArray() as $value => $label) {
            $options[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $options;
    }

    /**
     * @return array
     */
    protected function toArray()
    {
        $options = [];
        $rules = $this->collectionFactory->create()
            ->addActiveFilter()
            ->addFieldToFilter('location', ['finset' => Location::USING_SNIPPET_CODE]);

        foreach ($rules as $rule) {
            $options[$rule->getId()] = $rule->getName();
        }

        return $options;
    }
}
