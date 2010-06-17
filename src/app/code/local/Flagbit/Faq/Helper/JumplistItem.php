<?php
/**
 * FAQ for Magento
 *
 * @category   Flagbit
 * @package    Flagbit_FAQ
 * @copyright  Copyright (c) 2009 Flagbit GmbH & Co. KG <magento@flagbit.de>
 */

/**
 * FAQ for Magento
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @author     Flagbit GmbH & Co. KG <magento@flagbit.de>
 */
class Flagbit_Faq_Helper_JumplistItem extends Mage_Core_Helper_Abstract implements Countable, Iterator 
{
	/**
	 * @var string
	 */
	protected $label;
	
	/**
	 * @var array
	 */
	protected $faqItems = array();
	
	/**
	 * The constructor
	 *
	 * @param string $label
	 * @param array $faqItems
	 */
	public function __construct($label = null, $faqItems = null)
	{
		$this->setLabel($label);
		if(!is_null($faqItems))
		{
			$this->setFaqItems($faqItems);
		}
	}
	
	/**
	 * @return array
	 */
	public function getFaqItems()
	{
		return $this->faqItems;
	}
	
	/**
	 * @param array $faqItems
	 */
	public function setFaqItems(array $faqItems)
	{
		$this->faqItems = $faqItems;
	}
	
	public function addFaqItem($item)
	{
		$this->faqItems[] = $item;
	}
	
	/**
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}
	
	/**
	 * @param string $label
	 */
	public function setLabel($label)
	{
		$this->label = (string) $label;
	}
	
	/**
	 * Count elements of the jumplist
	 * 
	 * @return int
	 */
	public function count()
	{
		return count($this->faqItems);
	}
	
	/**
	 * Returns the current element
	 *
	 * @return mixed
	 */
	public function current()
	{
		return current($this->faqItems);
	}
	
	/**
	 * Returns the key of the current element
	 *
	 * @return scalar
	 */
	public function key()
	{
		return key($this->faqItems);
	}
	
	/**
	 * Move forward to the next element
	 *
	 * @return void
	 */
	public function next()
	{
		next($this->faqItems);
	}
	
	/**
	 * Rewind the Iterator to the first element
	 *
	 * @void
	 */
	public function rewind()
	{
		reset($this->faqItems);
	}
	
	/**
	 * Checks if current position is valid
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return array_key_exists($this->key(), $this->faqItems);
	}
}
