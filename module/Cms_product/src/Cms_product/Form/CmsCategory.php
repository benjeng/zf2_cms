<?php

namespace Cms_product\Form;
 
use Zend\Form\Form;
use Zend\Form\Element;
use Cms_core\Form\coreForm;

class CMSCategory extends coreForm
{
    private $_groups;//array
    
    public function __construct($_templates = array(), $_extraFields = array())
    {
        // we want to ignore the name passed
        parent::__construct('article');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'title',
            'type'  => 'text',
            'group' => 'basic@@@Basic',
            'attributes' => array(
                'placeholder' => 'category name',
                'required' => 'required',
                'class' => 'text',
                'description' => 'Category Title',
                'id' => 'name',
            ),
            'options' => array(
                'label' => 'Title',
                'label_attributes' => array(
                    'class' => 'mycss classes'
                ),
            ),
        ));
        
        $arrTemplate = array();
        foreach($_templates as $_template => $_item) $arrTemplate[$_template] = $_item['name'];
        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Select',
            'group' => 'basic@@@Basic',
            'attributes' => array(
                'value' => 'product' //set checked to '1'
            ),
            'options' => array(
                'label' => 'Template',
                'description' => 'test',
                'value_options' => $arrTemplate,
            ),
        ));
        
        $arrCategories = array(
            "0" => "ROOT",
        );
        $this->add(array(
            'name' => 'parent_id',
            'type' => 'Zend\Form\Element\Select',
            'group' => 'basic@@@Basic',
            'attributes' => array(
                'value' => '0' //set checked to '0'
            ),
            'options' => array(
                'label' => 'Parent Category',
                'description' => 'Parent Category',
                'value_options' => $arrCategories,
            ),
        ));
        
        $this->loadTemplate($_extraFields);
        
        $this->add(array(
            'name' => 'is_enabled',
            'type'  => 'hidden',
            'group' => 'basic@@@Basic',
            'attributes' => array('value' => '0'),
        ));
        $this->add(array(
            'name' => 'is_deleted',
            'type'  => 'hidden',
            'group' => 'basic@@@Basic',
            'attributes' => array('value' => '0'),
        ));
        $this->add(array(
            'name' => 'is_locked',
            'type'  => 'hidden',
            'group' => 'basic@@@Basic',
            'attributes' => array('value' => '0'),
        ));
        
        //Controll buttons
        $this->add(array(
            'name' => 'submit',
            'group' => '_control@@@Action',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
                'class' => 'cms_btn',
            ),
            'options' => array(
                'label' => 'Submit',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit_or_cancel',
            'group' => '_control@@@Action',
            'attributes' => array(
                'type'  => 'button',
                'value' => '/admin/category/',
                'id' => 'submitorcancelbutton',
                'class' => 'close_modal cms_btn',
            ),
            'options' => array(
                'label' => 'Cancel',
            ),
        ));
        //Controll buttons(END)
    }
    
}