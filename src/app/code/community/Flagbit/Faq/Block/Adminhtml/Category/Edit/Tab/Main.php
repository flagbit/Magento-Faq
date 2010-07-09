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
class Flagbit_Faq_Block_Adminhtml_Category_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Preparation of current form
     *
     * @return Flagbit_Faq_Block_Adminhtml_Category_Edit_Tab_Main
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('faq_category');
        
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('faq_');
        
        $fieldset = $form->addFieldset('base_fieldset', array (
                'legend' => Mage::helper('flagbit_faq')->__('General information'), 
                'class' => 'fieldset-wide' ));
        
        if ($model->getCategoryId()) {
            $fieldset->addField('category_id', 'hidden', array (
                    'name' => 'category_id'
            ));
        }
        
        $fieldset->addField('category_name', 'text', array (
            'name' => 'category_name', 
            'label' => Mage::helper('flagbit_faq')->__('Category Name'), 
            'title' => Mage::helper('flagbit_faq')->__('Category Name'), 
            'required' => true,
        ));
        
        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', 
                    array (
                            'name' => 'stores[]', 
                            'label' => Mage::helper('cms')->__('Store view'), 
                            'title' => Mage::helper('cms')->__('Store view'), 
                            'required' => true, 
                            'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true) ));
        }
        else {
            $fieldset->addField('store_id', 'hidden', array (
                    'name' => 'stores[]', 
                    'value' => Mage::app()->getStore(true)->getId() ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }
        
        $fieldset->addField('is_active', 'select', 
                array (
                        'label' => Mage::helper('cms')->__('Status'), 
                        'title' => Mage::helper('flagbit_faq')->__('Category Status'), 
                        'name' => 'is_active', 
                        'required' => true, 
                        'options' => array (
                                '1' => Mage::helper('cms')->__('Enabled'), 
                                '0' => Mage::helper('cms')->__('Disabled') ) ));
        
        $form->setValues($model->getData());
        $this->setForm($form);
        
        return parent::_prepareForm();
    }
}
