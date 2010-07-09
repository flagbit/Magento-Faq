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
class Flagbit_Faq_Block_Adminhtml_Category_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Constructs current object
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('faq_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('flagbit_faq')->__('Category Information'));
    }
    
    /**
     * Prepares the page layout
     * 
     * Adds the tabs to the left tab menu.
     * 
     * @return Flagbit_Faq_Block_Adminhtml_Category_Edit_Tabs
     */
    protected function _prepareLayout()
    {
        $return = parent::_prepareLayout();

        $this->addTab(
            'main_section', 
            array(
                'label' => Mage::helper('flagbit_faq')->__('General information'),
                'title' => Mage::helper('flagbit_faq')->__('General information'),
                'content' => $this->getLayout()->createBlock('flagbit_faq/adminhtml_category_edit_tab_main')->toHtml(),
                'active' => true,
            )
        );
        
        return $return;
    }
}
