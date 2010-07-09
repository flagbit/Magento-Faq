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
class Flagbit_Faq_IndexController extends Mage_Core_Controller_Front_Action
{
	/**
	 * Displays the FAQ list.
	 */
	public function indexAction()
	{
		$this->loadLayout()->renderLayout();
	}
	
	/**
	 * Displays the current FAQ's detail view
	 */
	public function showAction()
	{
		$this->loadLayout()->renderLayout();
	}
}
