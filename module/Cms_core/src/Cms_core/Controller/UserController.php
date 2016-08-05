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
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Result as Result;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Cms_core\Form\CMSUser as theForm;
use Cms_core\Model\Entity\CMSUser as theEntity;

class UserController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;

    private function init()
    {
        $this->title = "System User";
        $sm = $this->getServiceLocator();
        $this->workTable = $sm->get('Cms_core\Model\CMSUserTable');
        $this->sideWidget = "This is sidewidget";
        
        $this->cms_url_base = "/admin/user";
        $this->base_route = "cms_user";
    }
    
    public function indexAction()
    {
        $this->init();
        $this->layout()->sideWidget = $this->sideWidget;
        
        return new ViewModel(array(
            "title" => $this->title,
            "grid_url" => $this->cms_url_base . "/grid",
        ));
    }
    
    public function binAction()
    {
        $this->init();
        $this->layout()->sideWidget = "This is sidewidget";
        
        return new ViewModel(array(
            "grid_url" => $this->cms_url_base . "/grid",
            "back_url" => $this->cms_url_base,
        ));
    }
    
    public function gridAction()
    {
        $this->init();
        $listType = $this->params()->fromPost('listType');
        
        $users = $this->workTable->getAllRecord();
        $data = array();
        foreach($users as $_item){
            if(!$listType){//NORMAL LISTING
                if($_item->is_deleted!=0) continue;
                $iconEnable = ($_item->is_enabled==1)?"enable":"disable";
                //Row function
                $arrRowFunctions = array(
                    "<a class='icon_sprite edit' href='{$this->cms_url_base}/edit/{$_item->id}'> </a>",
                    "<a class='icon_sprite ajax delete' href='{$this->cms_url_base}/delete/{$_item->id}'> </a>",
                    "<a class='icon_sprite ajax {$iconEnable}' href='{$this->cms_url_base}/enable/{$_item->id}'> </a>",
                );
                //Row function(END)
            }
            else if($listType=='bin'){//BIN LISTING
                if($_item->is_deleted!=1) continue;
                //Row function
                $arrRowFunctions = array(
                    "<a class='icon_sprite ajax erase' href='{$this->cms_url_base}/erase/{$_item->id}' confirm='Are you sure to erase?'> </a>",
                    "<a class='icon_sprite ajax restore' href='{$this->cms_url_base}/restore/{$_item->id}'> </a>",
                );
                //Row function(END)
            }
            
            $data[] = $_item->getLogicFields()+array('_actions' => implode(" ",$arrRowFunctions));
        }
        $result = new JsonModel(array(
            'status' => '1',
            'message' => 'data load success',
            'records' => count($users),
            'data' => $data,
        ));
        
        return $result;
    }
    
    public function editAction()
    {
        $this->init();
        $this->layout()->sideWidget = $this->sideWidget;
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute($this->base_route, array(
                'action' => 'add'
            ));
        }
        $theRecord = $this->workTable->getRecord($id);

        if(!$theRecord) die("No data");
        
        //Load form with template
        $form = new theForm();
        $form->setData($theRecord->getLogicFields());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $values = (array)$request->getPost();
            $theRecord = $theRecord->setDatas($values);
//            $form->setInputFilter($article->getInputFilter());
            $form->setData($values);

            if ($form->isValid()) {
                $this->workTable->save($theRecord);
                // Redirect to list of albums
                return $this->redirect()->toRoute($this->base_route, array('action' => 'edit', 'id' => $id));
            }
        }

        return new ViewModel(array(
            'id' => $id,
            'title' => $this->title,
            'form' => $form,
        ));
    }
    
    public function addAction()
    {
        $this->init();
        $form = new theForm();
        $boolEmbed = $this->params()->fromQuery('embed', 0);
        $messages = "";

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $thisEntity = new theEntity((array)$request->getPost(), true);
                $id = $this->workTable->save($thisEntity);

                // Redirect to list of edit-article
                return $this->redirect()->toRoute($this->base_route, array('action' => 'edit', 'id' => $id));
            }else{
                $messages = $form->getMessages();
            }
        }
        
        $viewModel = new ViewModel(array(
            'title' => $this->title,
            'form' => $form,
            'message' => $messages
        ));
        if($boolEmbed) $viewModel->setTerminal(true);//disable layout
        
        return $viewModel;
    }
    
    // Soft delete
    public function deleteAction()
    {
        $this->init();
        $id = $this->params()->fromRoute('id');
        $this->workTable->softdelete($id);
        
        $result = new JsonModel(array(
            'status' => '1',
            'message' => 'data deleted success',
        ));
        
        return $result;
    }
    
    // Soft delete
    public function restoreAction()
    {
        $this->init();
        $id = $this->params()->fromRoute('id');
        $this->workTable->softrestore($id);
        
        $result = new JsonModel(array(
            'status' => '1',
            'message' => 'data restored success',
        ));
        
        return $result;
    }
    
    // Erase from database
    public function eraseAction()
    {
        $this->init();
        $id = $this->params()->fromRoute('id');
        $this->workTable->deleteOne($id);
        
        $result = new JsonModel(array(
            'status' => '1',
            'message' => 'data erased success',
        ));
        
        return $result;
    }
    
    // Enable/disable
    public function enableAction()
    {
        $this->init();
        $id = $this->params()->fromRoute('id');
        $this->workTable->switchEnable($id);
        
        $result = new JsonModel(array(
            'status' => '1',
            'message' => 'data change status success',
        ));
        
        return $result;
    }
}
