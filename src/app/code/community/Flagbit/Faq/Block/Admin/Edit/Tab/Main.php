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
class Flagbit_Faq_Block_Admin_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form {

	/**
	 * Preparation of current form
	 *
	 * @return Flagbit_Faq_Block_Admin_Edit_Tab_Main Self
	 */
	protected function _prepareForm() {

		$model = Mage :: registry('faq');
		
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('faq_');
		
		$fieldset = $form->addFieldset('base_fieldset', array (
				'legend' => Mage :: helper('faq')->__('General information'), 
				'class' => 'fieldset-wide' ));
		
		if ($model->getFaqId()) {
			$fieldset->addField('faq_id', 'hidden', array (
					'name' => 'faq_id' ));
		}
		
		$fieldset->addField('question', 'text', array (
				'name' => 'question', 
				'label' => Mage :: helper('faq')->__('FAQ item question'), 
				'title' => Mage :: helper('faq')->__('FAQ item question'), 
				'required' => true ));
		
		/**
		 * Check is single store mode
		 */
		if (!Mage :: app()->isSingleStoreMode()) {
			$fieldset->addField('store_id', 'multiselect', 
					array (
							'name' => 'stores[]', 
							'label' => Mage :: helper('faq')->__('Store view'), 
							'title' => Mage :: helper('faq')->__('Store view'), 
							'required' => true, 
							'values' => Mage :: getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true) ));
		}
		else {
			$fieldset->addField('store_id', 'hidden', array (
					'name' => 'stores[]', 
					'value' => Mage :: app()->getStore(true)->getId() ));
			$model->setStoreId(Mage :: app()->getStore(true)->getId());
		}
		
		$fieldset->addField('is_active', 'select', 
				array (
						'label' => Mage :: helper('faq')->__('Status'), 
						'title' => Mage :: helper('faq')->__('Page status'), 
						'name' => 'is_active', 
						'required' => true, 
						'options' => array (
								'1' => Mage :: helper('faq')->__('Enabled'), 
								'0' => Mage :: helper('faq')->__('Disabled') ) ));
		
		
		$fieldset->addField('answer', 'editor', 
				array (
						'name' => 'answer', 
						'label' => Mage :: helper('faq')->__('Content'), 
						'title' => Mage :: helper('faq')->__('Content'), 
						'style' => 'height:36em;', 
						'wysiwyg' => true, 
						'required' => true ));
		
		$fieldset->addField('answer_html', 'select', 
				array (
						'label' => Mage :: helper('faq')->__('HTML answer'), 
						'title' => Mage :: helper('faq')->__('HTML answer'), 
						'name' => 'answer_html', 
						'required' => true, 
						'options' => array (
								'1' => Mage :: helper('faq')->__('Enabled'), 
								'0' => Mage :: helper('faq')->__('Disabled') ) ));
		
		$form->setValues($model->getData());
		$this->setForm($form);
		
		return parent :: _prepareForm();
	}
}
