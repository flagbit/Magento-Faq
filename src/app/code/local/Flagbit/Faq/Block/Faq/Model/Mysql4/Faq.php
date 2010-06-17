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
class Flagbit_Faq_Model_Mysql4_Faq extends Mage_Core_Model_Mysql4_Abstract {


	/**
	 * Constructor
	 * 
	 */
	protected function _construct() {

		$this->_init('faq/faq', 'faq_id');
	}


	/**
	 * Retrieve select object for load object data
	 *
	 * @param string $field
	 * @param mixed $value
	 * @return Zend_Db_Select
	 */
	protected function _getLoadSelect($field, $value, $object) {

		$select = parent :: _getLoadSelect($field, $value, $object);
		
		if ($object->getStoreId()) {
			$select->join(
				array('nns' => $this->getTable('faq/faq_store')),
				$this->getMainTable() . '.item_id = `nns`.faq_id'
			)->where('is_active=1 AND `nns`.store_id in (0, ?) ',
			$object->getStoreId())->order('creation_time DESC')->limit(1);
		}
		return $select;
	}

	
	/**
	 * Some processing prior to saving to database - processes the given images
	 * and the store configuration
	 *
	 * @param Mage_Core_Model_Abstract $object Current faq item
	 */
	protected function _beforeSave(Mage_Core_Model_Abstract $object) {

		if (!$object->getId()) {
			$object->setCreationTime(Mage :: getSingleton('core/date')->gmtDate());
		}
		
		$object->setPublicationTime(
			Mage::app()->getLocale()->date($object->getPublicationTime(),
			Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
			null, false)->toString(Varien_Date::DATETIME_INTERNAL_FORMAT)
		);
		
		$object->setUpdateTime(Mage :: getSingleton('core/date')->gmtDate());
	}


	/**
	 * Assign page to store views
	 *
	 * @param Mage_Core_Model_Abstract $object
	 */
	protected function _afterSave(Mage_Core_Model_Abstract $object) {

		$condition = $this->_getWriteAdapter()->quoteInto('faq_id = ?', $object->getId());
		$this->_getWriteAdapter()->delete($this->getTable('faq/faq_store'), $condition);
		
		foreach ((array) $object->getData('stores') as $store) {
			$storeArray = array ();
			$storeArray['faq_id'] = $object->getId();
			$storeArray['store_id'] = $store;
			$this->_getWriteAdapter()->insert(
				$this->getTable('faq/faq_store'), $storeArray
			);
		}
		
		return parent :: _afterSave($object);
	}


	/**
	 * Do some processing after loading (stores and images)
	 * 
	 * @param Mage_Core_Model_Abstract $object Current faq item
	 */
	protected function _afterLoad(Mage_Core_Model_Abstract $object) {

		$select = $this->_getReadAdapter()->select()->from(
			$this->getTable('faq/faq_store')
		)->where('faq_id = ?', $object->getId());
		
		if ($data = $this->_getReadAdapter()->fetchAll($select)) {
			$storesArray = array ();
			foreach ($data as $row) {
				$storesArray[] = $row['store_id'];
			}
			$object->setData('store_id', $storesArray);
		}
		
		$images = trim($object->getData('image'));
		if ($images && !empty($images)) {
			$object->setData('image', explode(',', $images));
		}
		else {
			$object->setData('image', null);
		}
		
		return parent :: _afterLoad($object);
	}
}