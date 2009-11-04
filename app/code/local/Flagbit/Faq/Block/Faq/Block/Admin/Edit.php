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
class Flagbit_Faq_Block_Admin_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

	/**
	 * Constructor for the FAQ edit form
	 *
	 */
	public function __construct() {

		$this->_objectId = 'faq_id';
		$this->_controller = 'admin';
		$this->_blockGroup = 'faq';
		
		parent :: __construct();
		
		$this->_updateButton('save', 'label', Mage :: helper('faq')->__('Save FAQ item'));
		$this->_updateButton('delete', 'label', Mage :: helper('faq')->__('Delete FAQ item'));
		
		$this->_addButton('saveandcontinue', array (
				'label' => Mage :: helper('adminhtml')->__('Save and continue edit'), 
				'onclick' => 'saveAndContinueEdit()', 
				'class' => 'save' ), -100);
		
		$this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'page_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'page_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
	}

	
	/**
	 * Helper function to edit the header of the current form
	 *
	 * @return string Returns an "edit" or "new" text depending on the type of modifications.
	 */
	public function getHeaderText() {

		if (Mage :: registry('faq')->getFaqId()) {
			return Mage :: helper('faq')->__("Edit FAQ item '%s'", $this->htmlEscape(Mage :: registry('faq')->getQuestion()));
		}
		else {
			return Mage :: helper('faq')->__('New FAQ item');
		}
	}
	
	public function getFormActionUrl() {
        return $this->getUrl('*/faq/save');
    }
}