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
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Result as Result;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Cms_core\Model\Entity\SEO as SEOEntity;
use Cms_core\Form\SEOForm;

class SeoController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;

    private function init()
    {
        $sm = $this->getServiceLocator();
        $this->workTable = $sm->get('Cms_core\Model\SEOTable');
    }
    
    public function indexAction()
    {
        $this->init();
        
        return new ViewModel();
    }
    
    public function saveAction()
    {
        $this->init();
        $messages = "";

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = (array)$request->getPost();
            $seo_entity = new SEOEntity($data);
            $id = $this->workTable->save($seo_entity);
        }
        
        $result = new JsonModel(array(
            'status' => '1',
            'message' => 'data save success',
        ));
        
        return $result;
    }
}
