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

	/**
	 * Logs a hit to a particular question and increases said question's 
	 * popularity. This allows you to show popular questions on the FAQ index 
	 * page.
	 *
	 * The idea is that when question titles are clicked on to show the answer 
	 * we send an AJAX request to this URL, increasing the question's popularity
	 * (therefore this is only for accordian-style questions).
	 *
	 * [!!] Note: this call must be made over AJAX.
	 *
	 * @param  int  Question ID to modify
	 * @return void
	 */
	public function hitAction()
	{
		$id  = $this->getRequest()->getParam('id');
		$faq = Mage::getModel('flagbit_faq/faq')->load( (int) $id);

		// If this isn't an AJAX call disregard: this URL should not be 
		// crawlable. Also ensure we have a question ID.
		if ( ! $this->getRequest()->isXmlHttpRequest() || $id == '' || ! $faq->getId())
		{
			$this->getResponse()->setHeader('HTTP/1.1', '404 Not Found');
			$this->getResponse()->setHeader('Status', '404 File Not Found');

			// Try and render the CMS 404 page; if we can't show the default no 
			// route.
			$pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_NO_ROUTE_PAGE);
			if ( ! Mage::Helper('cms/page')->renderPage($this, $pageId))
			{
				$this->_forward('defaultNoRoute');
			}

			return;
		}

		$table = Mage::getSingleton('core/resource')->getTableName('faq');
		$db    = Mage::getSingleton('core/resource')->getConnection('core/write');
		$db->query("UPDATE `$table` SET `popularity` = `popularity` + 1 WHERE `faq_id` = :id", array(":id" => (int) $id));
	}
}
