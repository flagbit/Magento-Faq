<?php
/**
 * FAQ for Magento
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @copyright  Copyright (c) 2010 Flagbit GmbH & Co. KG <magento@flagbit.de>
 */

/**
 * Category Model for FAQ Items
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @author     Flagbit GmbH & Co. KG <magento@flagbit.de>
 */
class Flagbit_Faq_Model_Category extends Mage_Core_Model_Abstract
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('flagbit_faq/category');
    }
    
    public function getName()
    {
        return $this->getCategoryName();
    }
    
    public function getItemCollection()
    {
        $collection = $this->getData('item_collection');
        if (is_null($collection)) {
            $collection = Mage::getSingleton('flagbit_faq/faq')->getCollection()
                ->addCategoryFilter($this);
            $this->setData('item_collection', $collection);
        }
        return $collection;
    }
}
