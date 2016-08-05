<?php

namespace Cms_core\Form;
 
use Zend\Form\Form;
use Zend\Form\Element;
 
class SEOForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('seo_form');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'seo_title',
            'type'  => 'text',
            'options' => array(
                'label' => 'Title',
            ),
        ));
        
        $this->add(array(
            'name' => 'seo_description',
            'type'  => 'text',
            'options' => array(
                'label' => 'Description',
            ),
        ));
        
        $this->add(array(
            'name' => 'seo_keywords',
            'type'  => 'text',
            'options' => array(
                'label' => 'Keywords',
            ),
        ));
        
        $this->add(array(
            'name' => 'object',
            'type'  => 'hidden',
        ));
        
        $this->add(array(
            'name' => 'obj_id',
            'type'  => 'hidden',
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'button',
                'value' => 'Save',
                'id' => 'submitbutton',
                'class' => 'cms_btn',
            ),
        ));
    }
}