<?php

namespace Cms_product\Form;
 
use Zend\Form\Form;
use Zend\Form\Element;
use Cms_core\Form\coreForm;
 
class CMSProduct extends coreForm
{
    private $_groups;//array
    
    public function __construct($_templates = array(), $_extraFields = array())
    {
        // we want to ignore the name passed
        parent::__construct('article');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'name',
            'type'  => 'text',
            'group' => 'basic@@@Basic',
            'attributes' => array(
                'placeholder' => 'product name',
                'required' => 'required',
                'class' => 'text',
                'description' => 'Product Name',
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
        
        $this->add(array(
            'name' => 'url',
            'type'  => 'text',
            'group' => 'basic@@@Basic',
            'attributes' => array(
                'placeholder' => 'product url',
                'id' => 'url',
            ),
            'options' => array(
                'label' => 'URL',
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
                'value' => '/admin/product/',
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