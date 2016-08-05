<?php

namespace Cms_core\Form;
 
use Zend\Form\Form;
use Zend\Form\Element;
 
class CMSNode extends coreForm
{
    private $_groups;//array
    
    public function __construct($_extraFields = array(), $back_source = "",  $dbAdapter = null)
    {
        // we want to ignore the name passed
        parent::__construct('node');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'title',
            'type'  => 'text',
            'group' => 'basic@@@Basic',
            'attributes' => array(
                'placeholder' => 'title',
                'required' => 'required',
                'class' => 'text1',
                'description' => 'Title for internal use',
                'id' => 'title',
            ),
            'options' => array(
                'label' => 'Name',
                'label_attributes' => array(
                    'class' => 'mycss classes'
                ),
            ),
        ));
        
        $this->loadTemplate($_extraFields, $dbAdapter);
        
        $this->add(array(
            'name' => 'cms_template',
            'type'  => 'hidden',
            'group' => 'basic@@@Basic',
            'attributes' => array('value' => 'article'),
        ));
        $this->add(array(
            'name' => 'type',
            'type'  => 'hidden',
            'group' => 'basic@@@Basic',
            'attributes' => array('value' => 'article'),
        ));
        $this->add(array(
            'name' => 'is_enabled',
            'type'  => 'hidden',
            'group' => 'basic@@@Basic',
            'attributes' => array('value' => '1'),
        ));
        $this->add(array(
            'name' => 'obj_id',
            'type'  => 'hidden',
            'group' => 'basic@@@Basic',
            'attributes' => array('value' => '0'),
        ));
        $this->add(array(
            'name' => 'obj_table',
            'type'  => 'hidden',
            'group' => 'basic@@@Basic',
            'attributes' => array('value' => '0'),
        ));
        $this->add(array(
            'name' => 'root_id',
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
                'value' => $back_source,
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