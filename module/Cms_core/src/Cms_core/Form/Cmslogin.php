<?php

namespace Cms_core\Form;
 
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Captcha\Image as CaptchaImage;
 
class CMSLogin extends Form
{
    public function __construct($boolCaptcha = false)
    {
        // we want to ignore the name passed
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'lg_username',
            'type'  => 'text',
            'options' => array(
                'label' => 'Username',
            ),
        ));
        
        $this->add(array(
            'name' => 'lg_password',
            'type'  => 'password',
            'options' => array(
                'label' => 'Password',
            ),
        ));
        
        $this->add(array(
            'name' => 'rememberme',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Remember me?',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
//                'label_position' => 'append',
                'label_attributes' => array('class' => 'checkbox'),
            ),
        ));
        
        if($boolCaptcha){
            //Organize captcha
            $captchaObj = new CaptchaImage(array(
                'font' => './data/font/arial.ttf',
                'width' => 208,
                'height' => 40,
                'wordLen' => 6,
                'dotNoiseLevel' => 40,
                'lineNoiseLevel' => 3)
            );
            $captchaObj->setImgDir('./public/captcha');
            $captchaObj->setImgUrl('/captcha');
            $this->add(array(
                'type' => 'Zend\Form\Element\Captcha',
                'name' => 'captcha',
                'options' => array(
                    'label' => 'Please verify you are human',
                    'captcha' => $captchaObj,
                ),
                'attributes' => array(
                    'class' => 'cms_captcha',
                ),
            ));
        }
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
                'id' => 'submitbutton',
            ),
        ));
    }
}