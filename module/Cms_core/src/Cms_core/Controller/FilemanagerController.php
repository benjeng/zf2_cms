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
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class FilemanagerController extends AbstractActionController
{
    protected $rootFolder;
    
    public function __construct()
    {
        $this->rootFolder = SITE_ROOT . "/public/tmp";
        $this->_folderItems = array();
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    //Return json data for EasyUI-tree
    public function loadfolderAction()
    {
        $data = $this->gatherFolder($this->rootFolder, true, $this->rootFolder);
        $result = new JsonModel($data);
        
        return $result;
    }
    
    public function loadfolderlistAction()
    {
        $this->gatherFolder($this->rootFolder, true, $this->rootFolder);
        $result = new JsonModel($this->_folderItems);
        
        return $result;
    }
    
    public function createfolderAction()
    {
        $resultJson = array(
            'status' => '0',
            'message' => 'action fail',
        );
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $baseFolder = $this->params()->fromPost('current_name', '');
            $newFolder = $this->params()->fromPost('create_name', '');
            $newPath = ($this->rootFolder . $baseFolder . "/" . $newFolder);
            
            if(strpos($newPath, $this->rootFolder)!==false &&
                    $this->rootFolder != $newPath &&
                    preg_match('/^[\w-]+$/', $newFolder))
            {
                mkdir($newPath);
                $resultJson = array(
                    'status' => '1',
                    'message' => 'Folder created succeed.',
                );
            }
        }
        
        $result = new JsonModel($resultJson);
        return $result;
    }
    
    public function deletefolderAction()
    {
        $resultJson = array(
            'status' => '0',
            'message' => 'action fail',
        );
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $baseFolder = $this->params()->fromPost('current_name', '');
            $deletePath = ($this->rootFolder . $baseFolder);
            
            if(strpos($deletePath, $this->rootFolder)!==false &&
                    $this->rootFolder != $deletePath)
            {
                try{
                    $_result = @rmdir($deletePath);
                    if($_result){
                        $resultJson = array(
                            'status' => '1',
                            'message' => 'Folder delete succeed.',
                        );
                    }
                }catch(Exception $e){
                    $resultJson = array(
                        'status' => '2',
                        'message' => $e->getMessage(),
                    );
                }
                
            }
        }
        
        $result = new JsonModel($resultJson);
        return $result;
    }
    
    public function renamefolderAction()
    {
        $resultJson = array(
            'status' => '0',
            'message' => 'Action fail',
        );
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $baseFolder = $this->params()->fromPost('current_name', '');
            $newFolder = $this->params()->fromPost('newname', '');
            $oldPath = $this->rootFolder . $baseFolder;
            $newPath = dirname($this->rootFolder . $baseFolder) . "/" . $newFolder;
            if(strpos($newPath, $this->rootFolder)!==false &&
                    $this->rootFolder != $newPath &&
                    preg_match('/^[\w-]+$/', $newFolder))
            {
                $_result = @rename($oldPath, $newPath);
                if($_result){
                    $resultJson = array(
                        'status' => '1',
                        'message' => 'Folder created succeed.',
                    );
                }
            }
        }
        
        $result = new JsonModel($resultJson);
        return $result;
    }
    
    public function movefolderAction()
    {
        $resultJson = array(
            'status' => '0',
            'message' => 'Action fail',
        );
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $baseFolder = $this->params()->fromPost('current_name', '');
            $newFolder = $this->params()->fromPost('newpath', '');
            $oldPath = $this->rootFolder . $baseFolder;
            $filename = basename($oldPath);
            $newPath = $this->rootFolder . $newFolder . $filename;
            $_result = @rename($oldPath, $newPath);
            if($_result){
                $resultJson = array(
                    'status' => '1',
                    'message' => 'Item moved succeed.',
                );
            }
        }
        
        $result = new JsonModel($resultJson);
        return $result;
    }
    
    //Traverse folder structure (Structure for EasyUI-tree)
    private function gatherFolder($root, $boolIgnoreHidden=true, $maskPath=null)
    {
        $folderCurrItem = str_replace($this->rootFolder, "", $root."/");
        if(!in_array($folderCurrItem, $this->_folderItems)) $this->_folderItems[] = $folderCurrItem;
        $myHelper = $this->getServiceLocator()->get('viewhelpermanager')->get('systeminfoHelper');
        $dir = opendir($root);
        $result = array();
        while(($item = readdir($dir)) !== false){
            if($item=="." || $item=="..") continue;
            if($boolIgnoreHidden && $item[0]=='.') continue;
            if(is_dir($root . "/" . $item))
            {
                $arrSubFolders = $this->gatherFolder($root . "/" . $item, $boolIgnoreHidden, $maskPath);
                $result[] = array(
                    "id" => str_replace($maskPath, "", $root."/".$item),
                    "text" => $item,
                    "state" => count($arrSubFolders)?"closed":"open",
                    "attributes" => array(
                        "type" => 'folder',
                    ),
                    "children" => $arrSubFolders
                );
            }else{
                $fileInfo = pathinfo($root . "/" . $item);
                $result[] = array(
                    "id" => str_replace($maskPath, "", $root."/".$item),
                    "text" => $item,
                    "attributes" => array(
                        "type" => 'file',
                        "size" => $myHelper->byteToSize(filesize($root . "/" . $item)),
                        "ext" => $fileInfo['extension'],
                    ),
                );
            }
        }
        return $result;
    }
    //Traverse folder structure(END)
    
    public function uploadAction()
    {
        file_put_contents("/tmp/ttt.txt", "Upload".time());
//        $this->_helper->viewRenderer->setNoRender(TRUE);
//        $this->_helper->layout->disableLayout();
        
        $uploadDestination = $this->rootFolder;
        $uploadAdapter = new \Zend\File\Transfer\Adapter\Http();
        $uploadAdapter->setDestination($uploadDestination);
        
        if (!$uploadAdapter->receive()) {
            $messages = $uploadAdapter->getMessages();
            echo implode("\n", $messages);
        }else{
            $fileInfo = $uploadAdapter->getFileInfo();
            $hash = $uploadAdapter->getHash('md5');

//            $this->_helper->redirector('index', $this->_controller, $this->_module);
        }
        return true;
    }
}