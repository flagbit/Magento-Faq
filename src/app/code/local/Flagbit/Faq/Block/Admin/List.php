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

class Flagbit_Faq_Block_Admin_List extends Mage_Adminhtml_Block_Widget_Grid_Container {

	/**
	 * Constructor for FAQ Admin Block
	 *
	 */
	public function __construct() {

		$this->_controller = 'admin_list';
		$this->_blockGroup = 'faq';
		$this->_headerText = Mage :: helper('faq')->__('FAQ');
		$this->_addButtonLabel = Mage :: helper('sales')->__('Add new FAQ item');
		
		parent :: __construct();
	
	}

	
	/**
	 * Standard grid function for new elements
	 *
	 * @return string URL to add element page
	 */
	public function getCreateUrl() {

		return $this->getUrl('adminhtml/faq/new');
	}
}
