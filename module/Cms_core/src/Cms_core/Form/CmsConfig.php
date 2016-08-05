<?php

namespace Cms_core\Form;
 
use Zend\Form\Form;
use Zend\Form\Element;
 
class CMSConfig extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('config');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'project_title',
            'type'  => 'text',
            'options' => array(
                'label' => 'Project Title',
            ),
        ));
        
        $this->add(array(
            'name' => 'captcha',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'required' => false,
            ),
            'options' => array(
                'label' => 'Enable captcha on login?',
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0,
            ),
        ));
        
        $this->add(array(
            'name' => 'systeminfo_password',
            'type'  => 'password',
            'options' => array(
                'label' => 'Systeminfo access password',
            ),
        ));
        
        $this->add(array(
            'name' => 'log_level',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => false,
            ),
            'options' => array(
                'label' => 'Log level',
                'value_options' => array(
                    '0' => 'No log',
                    '1' => 'Normal log',
                    '2' => 'Detail log',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'data_log',
            'type' => 'Zend\Form\Element\MultiCheckbox',
            'attributes' => array(
                'required' => false,
                'value' => 'n',
            ),
            'options' => array(
                'label' => 'Database access log',
                'value_options' => array(
                    'n' => 'no log',
                    'r' => 'Select',
                    'c' => 'Insert',
                    'u' => 'Update',
                    'd' => 'Delete',
                ),
            )
        ));
        
        $this->add(array(
            'name' => 'login_session',
            'type'  => 'text',
            'options' => array(
                'label' => 'Login expiry time (sec)',
            ),
            'attributes' => array(
                'required' => false,
                'value' => 1800,
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
                'class' => 'cms_btn',
            ),
        ));
    }
}