<?php

class Flagbit_Faq_Block_Widget_Grid_Column_Renderer_Media
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $html = '<img src="'.Mage::getBaseUrl('media').$row->getIcon().'" style="height: 50px;max-width: 50px" />';
        return $html;
    }

}