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

use Cms_core\Form\CMSNode;
use Cms_core\Model\Entity\CMSNode as NodeEntity;
use Cms_core\Form\SEOForm;

class NodeController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $dbAdapter;

    private function init()
    {
        $this->title = "Node";
        $sm = $this->getServiceLocator();
        $this->workTable = $sm->get('Cms_core\Model\CMSNodeTable');
        $this->template = array(
            "default" => "Default",
            "image" => "Image",
        );
        $this->seoTable = $sm->get('Cms_core\Model\SEOTable');
        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    }
    
    public function indexAction()
    {
        $this->init();
        $this->layout()->sideWidget = "This is sidewidget";
        
        return new ViewModel(array("template" => $this->template));
    }
    
    public function gridAction()
    {
        $this->init();
        $id = $this->params()->fromRoute('id', 0);
        $arrParams = explode("@@@", $this->params()->fromRoute('param', 0));
        $boolEmbed = $this->params()->fromQuery('embed', 1);//Default is without layout
        
        $obj_table = $arrParams[0];
        $node_type = $arrParams[1];
        $node_template = $arrParams[2];
        $node_root_id = $this->workTable->newSeed($id, $obj_table, $node_type);
        $nodes = $this->workTable->getChildren($node_root_id, $arrParams[1]);
        
        $viewModel = new ViewModel(array(
            'nodes' => $nodes,
            'entity_id' => $id,
            'node_root' => $node_root_id,
            'node_type' => $node_type,
            'node_template' => $node_template,
            'obj_table' => $obj_table,
        ));
        if($boolEmbed) $viewModel->setTerminal(true);//disable layout
        
        return ($viewModel);
    }
    
    public function editAction()
    {
        $this->init();
        $id = $this->params()->fromRoute('id', 0);
        $entity_id = $this->params()->fromRoute('param');
        $source = $this->params()->fromRoute('source');
        if (!$id) {
            return $this->redirect()->toRoute('cms_article', array(
                'action' => 'edit'
            ));
        }
        $node = $this->workTable->getRecord($id);

        if(!$node) die("No data");
        
        //Load form with template
        if(file_exists(SITE_ROOT . "/data/template/Node/{$node->cms_template}.php"))
            $arrExtraFields = require_once SITE_ROOT . "/data/template/Node/{$node->cms_template}.php";
        else $arrExtraFields = array();
        $this->title = $this->title . " (" . $arrExtraFields["template_name"] . ")";//Correction of page heading
        $form = new CMSNode($arrExtraFields, "/admin/{$source}/edit/{$entity_id}", $this->dbAdapter);
        $form->setData($node->getLogicFields());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $values = (array)$request->getPost();
//            $form->setInputFilter($article->getInputFilter());
            $form->setData($values);

            if ($form->isValid()) {
                $node = $node->setDatas($values);
                $this->workTable->save($node);
                // Redirect to list of albums
                return $this->redirect()->toRoute('cms_article',array('action' => 'edit', 'id' => $entity_id));
            }
        }

        return new ViewModel(array(
            'id' => $id,
            'form' => $form,
            'title' => $this->title,
        ));
    }
    
    public function addAction()
    {
        $this->init();
        $obj_id = $this->params()->fromQuery('obj_id');
        $obj_table = $this->params()->fromQuery('obj_table');
        $root_id = $this->params()->fromQuery('root_id');
        $node_type = $this->params()->fromQuery('type');
        $node_template = $this->params()->fromQuery('template');
        
        if(file_exists(SITE_ROOT . "/data/template/Node/{$node_template}.php"))
            $arrExtraFields = require_once SITE_ROOT . "/data/template/Node/{$node_template}.php";
        else $arrExtraFields = array();
        $this->title = $this->title . " (" . $arrExtraFields["template_name"] . ")";//Correction of page heading
        $form = new CMSNode(null, "/admin/{$obj_table}/edit/{$obj_id}", $this->dbAdapter);
        $form->get('obj_id')->setValue($obj_id);
        $form->get('obj_table')->setValue($obj_table);
        $form->get('root_id')->setValue($root_id);
        $form->get('type')->setValue($node_type);
        $form->get('cms_template')->setValue($node_template);
        $messages = "";

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $node = new NodeEntity((array)$request->getPost(), true);
                $id = $this->workTable->save($node);

                // Redirect to list of edit-article
//                return $this->redirect()->toRoute('cms_article',array('action' => 'edit', 'id' => $node->obj_id));
                return $this->redirect()->toUrl("/admin/article/edit/{$node->obj_id}#Node");
            }else{
                $messages = $form->getMessages();
            }
        }
        
        return new ViewModel(array(
            'title' => $this->title,
            'form' => $form,
            'message' => $messages
        ));
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
    
    // Save order
    public function saveorderAction()
    {
        $this->init();
        $listing = $this->params()->fromPost('listing');
        $this->workTable->reorder($listing);
        $result = new JsonModel(array(
            'status' => '1',
            'message' => 'data order saved',
        ));
        
        return $result;
    }
}
