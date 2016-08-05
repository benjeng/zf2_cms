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

use Cms_core\Form\CMSArticle as theForm;
use Cms_core\Model\Entity\CMSArticle as theEntity;
use Cms_core\Form\SEOForm;

class ArticleController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;

    private function init()
    {
        $this->title = "Articles";
        $sm = $this->getServiceLocator();
        $this->workTable = $sm->get('Cms_core\Model\CMSArticleTable');
        $this->template = require_once SITE_ROOT . '/data/article_template.php';
        $this->sideWidget = "This is sidewidget";
        $this->seoTable = $sm->get('Cms_core\Model\SEOTable');
        $this->seoType = 'article';
        $this->nodeTable = $sm->get('Cms_core\Model\CMSNodeTable');
        
        $this->cms_url_base = "/admin/article";
        $this->base_route = "cms_article";
    }
    
    public function indexAction()
    {
        $this->init();
        $this->layout()->sideWidget = $this->sideWidget;
        
        return new ViewModel(array(
            "title"    => $this->title,
            "template" => $this->template,
            "grid_url" => $this->cms_url_base . "/grid",
        ));
    }
    
    public function binAction()
    {
        $this->init();
        $this->layout()->sideWidget = "This is sidewidget";
        
        return new ViewModel(array(
            "title"    => $this->title,
            "template" => $this->template,
            "grid_url" => $this->cms_url_base . "/grid",
            "back_url" => $this->cms_url_base,
        ));
    }
    
    public function gridAction()
    {
        $this->init();
        $listType = $this->params()->fromPost('listType');
        
        $articles = $this->workTable->getAllRecord();
        $data = array();
        foreach($articles as $_item){
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
            
            $_item->publish_from = date("Y-m-d", strtotime($_item->publish_from));//Correct publish timestamp to date
            $_item->publish_to = date("Y-m-d", strtotime($_item->publish_to));//Correct publish timestamp to date
            
            $data[] = $_item->getLogicFields()+array('_actions' => implode(" ",$arrRowFunctions));
        }
        $result = new JsonModel(array(
            'status' => '1',
            'message' => 'data load success',
            'records' => count($articles),
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
        if(file_exists(SITE_ROOT . "/data/template/Article/{$theRecord->cms_template}.php"))
            $arrExtraFields = require_once SITE_ROOT . "/data/template/Article/{$theRecord->cms_template}.php";
        else $arrExtraFields = array();
        $form = new theForm($this->template, $arrExtraFields);
        $form->setData($theRecord->getLogicFields());

        //Load SEO form
        $seo_entity = $this->seoTable->getRecord($id, $this->seoType);
        $seo_form = new SEOForm();
        $seo_form->setData($seo_entity->getLogicFields());
        
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
            'seo_form' => $seo_form,
            'tabs' => isset($this->template[$theRecord->cms_template]['chains'])?$this->template[$theRecord->cms_template]['chains']:array(),
        ));
    }
    
    public function addAction()
    {
        $this->init();
        $form = new theForm($this->template);
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
        $this->nodeTable->deleteRelative($id);
        $this->seoTable->deleteRelative($id);
        
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
