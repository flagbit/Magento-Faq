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
class Flagbit_Faq_Adminhtml_Faq_CategoryController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Initialization of current view - add's breadcrumps and the current menu status
     * 
     * @return Flagbit_Faq_AdminController
     */
    protected function _initAction()
    {
        $this->_usedModuleName = 'flagbit_faq';
        
        $this->loadLayout()
            ->_setActiveMenu('cms/faq')
            ->_addBreadcrumb($this->__('CMS'), $this->__('CMS'))
            ->_addBreadcrumb($this->__('FAQ'), $this->__('FAQ'));
        
        $this->_title('FAQ');
        $this->_title('Manage Categories');
        
        return $this;
    }

    /**
     * Displays the FAQ overview grid.
     * 
     */
    public function indexAction()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('flagbit_faq/adminhtml_category'))
            ->renderLayout();
    }
    
    /**
     * Displays the new FAQ item form
     */
    public function newAction()
    {
        $this->_forward('edit');
    }
    
    /**
     * Displays the new FAQ item form or the edit FAQ item form.
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('category_id');
        $category = Mage::getModel('flagbit_faq/category');
        
        // if current id given -> try to load and edit current FAQ category
        if ($id) {
            $category->load($id);
            if (!$category->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('flagbit_faq')->__('This FAQ category no longer exists')
                );
                $this->_redirect('*/*/');
                return;
            }
        }
        
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $category->setData($data);
        }

        Mage::register('faq_category', $category);
        
        $this->_initAction()
                ->_addBreadcrumb(
                    $id
                        ? Mage::helper('flagbit_faq')->__('Edit FAQ Category')
                        : Mage::helper('flagbit_faq')->__('New FAQ Category'),
                    $id
                        ? Mage::helper('flagbit_faq')->__('Edit FAQ Category')
                        : Mage::helper('flagbit_faq')->__('New FAQ Category')
                )
                ->_addContent(
                        $this->getLayout()
                                ->createBlock('flagbit_faq/adminhtml_category_edit')
                                ->setData('action', $this->getUrl('*/*/save'))
                )
                ->_addLeft($this->getLayout()->createBlock('flagbit_faq/adminhtml_category_edit_tabs'));
        
        if ($category->getId()) {
            $this->_title($category->getName());
        }
        else {
            $this->_title('New Category');
        }
        
        $this->renderLayout();
    }

    /**
     * Action that does the actual saving process and redirects back to overview
     */
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            
            // init model and set data
            $category = Mage::getModel('flagbit_faq/category');
            $category->setData($data);
            
            // try to save it
            try {

                if(isset($_FILES['icon']['name']) && (file_exists($_FILES['icon']['tmp_name']))) {
                        $uploader = new Varien_File_Uploader('icon');
                        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png','svg'));
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);

                        // Set media as the upload dir
                        $media_path  = Mage::getBaseDir('media');

                        $filename = Mage::helper('flagbit_faq')->createSlug($data['category_name']) . implode('-',$data['stores']) . '.' . pathinfo($_FILES['icon']['name'],PATHINFO_EXTENSION);

                        // Upload the image
                        $r = $uploader->save($media_path . DS . Flagbit_Faq_Helper_Data::MEDIA_PATH, $filename);
                        $filename = $r['file'];

                        $category->setIcon( Flagbit_Faq_Helper_Data::MEDIA_PATH . $filename);
                } else {
                    if(isset($postData['icon']['delete']) && $postData['icon']['delete'] == 1) {
                        $category->setIcon(NULL);
                    }
                    else{
                        $data['icon'] = $data['icon']['value'];
                        $category->setIcon($data['icon']);
                    }
                }

                // save the data
                $category->save();
                
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('flagbit_faq')->__('FAQ Category was successfully saved')
                );
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array (
                            'category_id' => $category->getId() ));
                    return;
                }
            }
            catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addException($e, $e->getMessage());
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                $this->_redirect('*/*/edit', array (
                        'category_id' => $this->getRequest()->getParam('category_id') ));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Action that does the actual saving process and redirects back to overview
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('category_id')) {
            try {
                // init model and delete
                $category = Mage::getModel('flagbit_faq/category');
                $category->load($id);
                $category->delete();
                
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('flagbit_faq')->__('FAQ Category was successfully deleted'));
                
                // go to grid
                $this->_redirect('*/*/');
                return;
            
            }
            catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                
                // go back to edit form
                $this->_redirect('*/*/edit', array (
                        'category_id' => $id ));
                return;
            }
        }
        
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('flagbit_faq')->__('Unable to find a FAQ Category to delete'));
        
        // go to grid
        $this->_redirect('*/*/');
    }
    
    /**
     * Simple access control
     *
     * @return boolean True if user is allowed to edit FAQ
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/cms/faq');
    }
}
