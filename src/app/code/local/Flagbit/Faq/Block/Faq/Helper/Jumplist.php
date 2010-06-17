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
class Flagbit_Faq_Helper_Jumplist extends Mage_Core_Helper_Abstract implements Countable, Iterator
{
	protected $items = array();
	
	/**
	 * The "garbage can" for items not fitting in the default range
	 *
	 * @var string
	 */
	const KEY_OTHER = 'other';
	
	public function __construct()
	{
		// TODO make init range configurable
		// create items from A (65) to Z (90)
		for($ord = 65; $ord <= 90; $ord++)
		{
			$chr = chr($ord);
			$this->items[$chr] = new Flagbit_Faq_Helper_JumplistItem($chr);
		}
		
		// TODO make configurable if KEY_OTHER is appended or prepended
		$this->items[self::KEY_OTHER] = new Flagbit_Faq_Helper_JumplistItem(self::KEY_OTHER);
	}
	
	public function setFaqItems(Flagbit_Faq_Model_Mysql4_Faq_Collection $items)
	{
		foreach($items as $item)
		{
			$key = strtoupper(substr($item->getQuestion(), 0, 1));
			if(!array_key_exists($key, $this->items))
			{
				$key = self::KEY_OTHER;
			}
			$this->items[$key]->addFaqItem($item);
		}
	}
	
	/**
	 * @see ArrayIterator::current()
	 */
	public function current() {
		return current($this->items);
	}
	
	/**
	 * @see ArrayIterator::key()
	 */
	public function key() {
		return key($this->items);
	}
	
	/**
	 * @see ArrayIterator::next()
	 */
	public function next() {
		return next($this->items);
	}
	
	/**
	 * @see ArrayIterator::rewind()
	 */
	public function rewind() {
		return reset($this->items);
	}
	
	/**
	 * @see ArrayIterator::valid()
	 */
	public function valid() {
		return array_key_exists($this->key(), $this->items);
	}
	/**
	 * @see Countable::count()
	 */
	public function count() {
		return count($this->items);
	}


}
