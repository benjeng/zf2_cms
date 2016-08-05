<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cms_core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Cms_core\Form\Cmslogin;

class IndexController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;
    
    public function indexAction()
    {
        $this->layout()->sideWidget = "This is sidewidget";
        return new ViewModel();
    }
    
}
