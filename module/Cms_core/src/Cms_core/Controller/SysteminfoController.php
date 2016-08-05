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
use Zend\Config\Writer\Ini as iniWriter;
use Zend\Config\Config;
use Zend\Session\Container;

use Cms_core\Form\CMSConfig;

class SysteminfoController extends AbstractActionController
{
    private function init()
    {
        $this->session_systeminfo = new Container('session_systeminfo');
        if(!$this->session_systeminfo->login)
        {
            return $this->redirect()->toRoute('cms_systeminfo', array(
                'action' => 'login'
            ));
        }
    }
    
    public function indexAction()
    {
        $this->init();
        return new ViewModel();
    }
    
    public function loginAction()
    {
        $message = "";
        $this->session_systeminfo = new Container('session_systeminfo');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = (array)$request->getPost();
            if(sha1($data['access_code'])==$this->applicationConfig['main']['cms']['systeminfo_password']){
                $this->session_systeminfo->login = true;
                return $this->redirect()->toRoute('cms_systeminfo');
            }else{
                $message = "Access code is wrong!";
            }
        }
        return new ViewModel(array('message' => $message));
    }
    
    public function folderstructureAction()
    {
        $this->init();
        $arrFolders[SITE_ROOT] = $this->gatherFolder(SITE_ROOT);
        return new ViewModel(array('folders' => $arrFolders, 'test' => $this->session_systeminfo->login));
    }
    
    public function phpinfoAction()
    {
        return new ViewModel();
    }
    
    public function dbinfoAction()
    {
        $arrTables = $this->getMySQL_info();
        return new ViewModel(array('tablesInfo' => $arrTables));
    }
    
    //Traverse folder structure
    private function gatherFolder($root, $boolIgnoreHidden=true)
    {
        $dir = opendir($root);
        $result = array();
        $fileCount = $fileSize = 0;
        $subfileCount = $subfileSize = 0;
        while(($item = readdir($dir)) !== false){
            if($item=="." || $item=="..") continue;
            if($boolIgnoreHidden && $item[0]=='.') continue;
            if(is_dir($root . "/" . $item))
            {
                $arrSubFolders = $this->gatherFolder($root . "/" . $item);
                $result[$item] = $arrSubFolders;
                $subfileCount += $arrSubFolders['@@@subfileCount'];
                $subfileSize += $arrSubFolders['@@@subfileSize'];
            }else{
                $fileCount ++;
                $fileSize += filesize($root . "/" . $item);
            }
        }
        $result['@@@fileCount'] = $fileCount;
        $result['@@@fileSize'] = $fileSize;
        $result['@@@subfileCount'] = $subfileCount + $fileCount;//subfolder total
        $result['@@@subfileSize'] = $subfileSize + $fileSize;//subfolder total
        return $result;
    }
    //Traverse folder structure(END)
    
    //Get mysql database info
    private function getMySQL_info()
    {
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $sql = "show tables";
        $stmt = $dbAdapter->query($sql);$resultSet = $stmt->execute();
        $arrTables = array();
        foreach($resultSet as $_row){
            foreach($_row as $_item){
                //Get data count
                $sql = "SELECT count(*) as COUNT from ".$_item;
                $stmt = $dbAdapter->query($sql);$resultSet2 = $stmt->execute();
                $tableCount = $resultSet2->current();
                //Get data count(END)
                $arrTables[] = array(
                    'table' => $_item,
                    'records' => $tableCount['COUNT'],
                );
            }
        }
        return $arrTables;
    }
    //Get mysql database info(END)
    
    //Read/write application.ini
    public function configAction()
    {
        $data['project_title'] = $this->applicationConfig['main']['cms']['project_title'];
        $data['log_level'] = @$this->applicationConfig['main']['cms']['log_level'];
        $data['captcha'] = $this->applicationConfig['main']['cms']['login']['captcha'];
        $data['login_session'] = $this->applicationConfig['main']['cms']['login']['login_session'];
        
        $form = new CMSConfig();
        $form->setData($data);
        $form->get('captcha')->setChecked($data['captcha']);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = (array)$request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $config = new Config(array(), true);
                $config->main = array();
                $config->main->cms = array();
                $config->main->cms->project_title = $data['project_title'];
                $config->main->cms->log_level = $data['log_level'];
                if($data['systeminfo_password']) $config->main->cms->systeminfo_password = sha1($data['systeminfo_password']);
                else $config->main->cms->systeminfo_password = $this->applicationConfig['main']['cms']['systeminfo_password'];
                $config->main->cms->login = array();
                $config->main->cms->login->captcha = isset($data['captcha'])?$data['captcha']:false;
                $config->main->cms->login->login_session = isset($data['login_session'])?$data['login_session']:false;
                
                $writer = new iniWriter();
                $writer->toFile(SITE_ROOT . '/config/application.ini', $config);//toString
                
                return $this->redirect()->toRoute('cms_systeminfo',array('action' => 'config'));
            }else{
                die(print_r($form->getMessages(),true));
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
        ));
    }
    //Read/write application.ini(END)
    
    public function versionAction()
    {
        return new ViewModel();
    }
    
    public function settingAction()
    {
        return new ViewModel();
    }
    
    //load and render CMS top mavigation
    public function cmsnaviAction()
    {
        $configNavi = CORE_ROOT . "/config/cms_navigation.php";
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $currentDepth = 2;
            $data = $request->getPost('new_navi');
            $new_navi = json_decode($data, true);
            //Generate output
            $result = "<?php\n\n";
            $result .= "return(array(\n";
            $result .= $this->gonavi($new_navi['children'], 2);
            $result .= "    )\n";
            $result .= ");\n";
            $result .= "?>\n";
            file_put_contents($configNavi, $result);
            //Generate output(END)
        }
        $arrTopNaviMenus = require $configNavi;
        
        return new ViewModel(array(
            'naviArray' => $arrTopNaviMenus,
        ));
    }
    private function gonavi($data, $depth){
        $result = "";
        foreach($data as $_item){
            $title = $_item['text'];
            if(isset($_item['children']))
                $result .= str_repeat("    ",$depth)."\"{$title}\" => array(\n".$this->gonavi($_item['children'], $depth+1).str_repeat("    ",$depth)."),\n";
            else
                $result .= str_repeat("    ",$depth)."\"{$title}\" => \"{$_item['attributes']['param']}\",\n";
        }
        return $result;
    }
}