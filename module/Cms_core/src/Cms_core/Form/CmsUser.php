<?php

namespace Cms_core\Form;
 
use Zend\Form\Form;
use Zend\Form\Element;
use Cms_core\Form\coreForm;
 
class CMSUser extends coreForm
{
    private $_groups;//array
    
    public function __construct($_templates = array(), $_extraFields = array())
    {
        // we want to ignore the name passed
        parent::__construct('article');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'login',
            'type'  => 'text',
            'group' => 'basic@@@Basic',
            'attributes' => array(
                'placeholder' => 'test',
                'required' => 'required',
                'class' => 'text1',
                'description' => 'Login name',
                'id' => 'login',
            ),
            'options' => array(
                'label' => 'Login name',
                'label_attributes' => array(
                    'class' => 'mycss classes'
                ),
            ),
        ));
        
//        $arrTemplate = array();
//        foreach($_templates as $_template => $_item) $arrTemplate[$_template] = $_item['name'];
//        $this->add(array(
//            'name' => 'cms_template',
//            'type' => 'Zend\Form\Element\Select',
//            'group' => 'basic@@@Basic',
//            'attributes' => array(
//                'value' => '2' //set checked to '1'
//            ),
//            'options' => array(
//                'label' => 'Template',
//                'description' => 'test',
//                'value_options' => $arrTemplate,
//            ),
//        ));
        
        $this->add(array(
            'name' => 'username',
            'type'  => 'text',
            'group' => 'basic@@@Basic',
            'attributes' => array(
                'placeholder' => 'username',
                'id' => 'username',
                'description' => 'Username for internal use',
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type'  => 'password',
            'group' => 'basic@@@Basic',
            'attributes' => array(
                'placeholder' => 'password',
                'id' => 'password',
                'description' => 'Left blank if no change',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        
        $this->add(array(
            'name' => 'roles',
            'type' => 'Zend\Form\Element\Select',
            'group' => 'basic@@@Basic',
            'attributes' => array(
                'value' => '2' //set checked to '1'
            ),
            'options' => array(
                'label' => 'Roles',
                'description' => 'Roles in system',
                'value_options' => array(
                    "1" => "Role-1",
                    "2" => "Role-2",
                    "3" => "Role-3",
                ),
            ),
        ));
        
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
                'value' => '/admin/user/',
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