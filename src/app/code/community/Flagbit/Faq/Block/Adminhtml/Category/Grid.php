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
class Flagbit_Faq_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Constructor of Grid
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('faq_grid');
        $this->setUseAjax(false);
        $this->setDefaultSort('creation_time');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Preparation of the data that is displayed by the grid.
     *
     * @return Flagbit_Faq_Block_Admin_Grid Self
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('flagbit_faq/category_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Preparation of the requested columns of the grid
     *
     * @return Flagbit_Faq_Block_Admin_Grid Self
     */
    protected function _prepareColumns()
    {
        $this->addColumn('category_id', array (
                'header' => Mage::helper('flagbit_faq')->__('Category #'), 
                'width' => '80px', 
                'type' => 'text', 
                'index' => 'category_id' ));
        
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id',
                    array (
                            'header' => Mage::helper('cms')->__('Store view'), 
                            'index' => 'store_id', 
                            'type' => 'store', 
                            'store_all' => true, 
                            'store_view' => true, 
                            'sortable' => false, 
                            'filter_condition_callback' => array (
                                    $this, 
                                    '_filterStoreCondition' ) ));
        }
        
        $this->addColumn(
            'category_name',
            array(
                'header' => Mage::helper('flagbit_faq')->__('Category Name'), 
                'index' => 'category_name',
            )
        );
        
        $this->addColumn('is_active', 
                array (
                        'header' => Mage::helper('cms')->__('Active'), 
                        'index' => 'is_active', 
                        'type' => 'options', 
                        'width' => '70px', 
                        'options' => array (
                                0 => Mage::helper('cms')->__('No'), 
                                1 => Mage::helper('cms')->__('Yes') ) ));
        
        $this->addColumn(
            'action', 
            array (
                    'header' => Mage::helper('flagbit_faq')->__('Action'), 
                    'width' => '50px',
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array (
                        array (
                            'caption' => Mage::helper('flagbit_faq')->__('Edit'), 
                            'url' => array (
                                'base' => '*/*/edit'
                            ), 
                            'field' => 'category_id'
                        ),
                    ),
                    'filter' => false, 
                    'sortable' => false, 
                    'index' => 'stores', 
                    'is_system' => true,
            )
        );
        
        return parent::_prepareColumns();
    }
    
    /**
     * Helper function to do after load modifications
     *
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * Helper function to add store filter condition
     *
     * @param Mage_Core_Model_Mysql4_Collection_Abstract $collection Data collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Column information to be filtered
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        
        $this->getCollection()->addStoreFilter($value);
    }
    
    /**
     * Helper function to reveive on row click url
     *
     * @param Flagbit_Faq_Model_Faq $row Current rows dataset
     * @return string URL for current row's onclick event
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array (
                'category_id' => $row->getCategoryId() ));
    }

    /**
     * Helper function to receive grid functionality urls for current grid
     *
     * @return string Requested URL
     */
    public function getGridUrl()
    {
        return $this->getUrl(
            '*/*/',
            array (
                '_current' => true,
            )
        );
    }
}
