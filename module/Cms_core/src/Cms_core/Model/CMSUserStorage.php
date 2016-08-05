<?php
namespace Cms_core\Model;
 
use Zend\Authentication\Storage;
 
class CMSUserStorage extends Storage\Session
{
    public function setRememberMe($rememberMe = 0, $time = 1200)
    {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe(604800);
        } else {
            $this->session->getManager()->rememberMe($time);
        }
    }
     
    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
    }
}