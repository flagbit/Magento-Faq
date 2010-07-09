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
class Flagbit_Faq_Block_Adminhtml_Item extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Constructor for FAQ Adminhtml Block
     */
    public function __construct()
    {
        $this->_blockGroup = 'flagbit_faq';
        $this->_controller = 'adminhtml_item';
        $this->_headerText = Mage::helper('flagbit_faq')->__('Manage FAQ Items');
        $this->_addButtonLabel = Mage::helper('flagbit_faq')->__('Add New FAQ Item');
        
        parent::__construct();
    }

    /**
     * Returns the CSS class for the header
     * 
     * Usually 'icon-head' and a more precise class is returned. We return
     * only an empty string to avoid spacing on the left of the header as we
     * don't have an icon.
     * 
     * @return string
     */
    public function getHeaderCssClass()
    {
        return '';
    }
}
