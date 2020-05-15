<?php
class Flagbit_Faq_Block_Adminhtml_Renderer_Categories extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        /** @var Flagbit_Faq_Model_Category $row */
        $array = array();
        foreach ($row->getCategoryId() as $category_id){
            $array[] = Mage::getModel('flagbit_faq/category')->load($category_id)->getCategoryName();
        }
        return implode(',',$array);
    }
}