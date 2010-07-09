<?php
/**
 * FAQ for Magento
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @copyright  Copyright (c) 2009 Flagbit GmbH & Co. KG <magento@flagbit.de>
 */

/**
 * FAQ for Magento
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @author     Flagbit GmbH & Co. KG <magento@flagbit.de>
 */
class Flagbit_Faq_Model_Mysql4_Category_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_previewFlag;
    
    /**
     * Constructor
     *
     */
    protected function _construct()
    {
        $this->_init('flagbit_faq/category');
    }
    
    /**
     * Add Filter by store
     *
     * @param int|Mage_Core_Model_Store $store Store to be filtered
     * @return Flagbit_Faq_Model_Mysql4_Category_Collection
     */
    public function addStoreFilter($store)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }
        
        $this->getSelect()->join(
            array('store_table' => $this->getTable('flagbit_faq/category_store')),
            'main_table.category_id = store_table.category_id',
            array ()
        )->where('store_table.store_id in (?)', array (
            0, 
            $store
        ))->group('main_table.category_id');
        
        return $this;
    }

    
    /**
     * After load processing - adds store information to the datasets
     *
     */
    protected function _afterLoad()
    {
        if ($this->_previewFlag) {
            $items = $this->getColumnValues('faq_id');
            if (count($items)) {
                $select = $this->getConnection()->select()->from(
                    $this->getTable('flagbit_faq/category_store')
                )->where(
                    $this->getTable('flagbit_faq/category_store') . '.category_id IN (?)',
                    $items
                );
                if ($result = $this->getConnection()->fetchPairs($select)) {
                    foreach ($this as $item) {
                        if (!isset($result[$item->getData('category_id')])) {
                            continue;
                        }
                        if ($result[$item->getData('category_id')] == 0) {
                            $stores = Mage::app()->getStores(false, true);
                            $storeId = current($stores)->getId();
                            $storeCode = key($stores);
                        }
                        else {
                            $storeId = $result[$item->getData('category_id')];
                            $storeCode = Mage::app()->getStore($storeId)->getCode();
                        }
                        $item->setData('_first_store_id', $storeId);
                        $item->setData('store_code', $storeCode);
                    }
                }
            }
        }
        
        parent::_afterLoad();
    }
    
    protected function _toOptionArray($valueField = 'category_id', $labelField = 'category_name', $additional = array())
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
    
    protected function _toOptionHash($valueField = 'category_id', $labelField='category_name')
    {
        return parent::_toOptionHash($valueField, $labelField);
    }

    public function addIsActiveFilter()
    {
        $this->addFilter('is_active', 1);
        return $this;
    }
}
