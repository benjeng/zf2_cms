<?php

namespace Cms_core\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Config\Reader\Ini as IniReader;
use Zend\Session\Container;

class CMSPlugin extends AbstractPlugin{
    
    public function loadTopNavi() {
        $configNavi = CORE_ROOT . "/config/cms_navigation.php";
        $arrTopNaviMenus = require $configNavi;
//        $arrTopNaviMenus = array(
//            "Home" => "/admin@@@class@@@id",
//            "Articles" => "/admin/article",
//            "Products" => array(
//                "Product" => "/admin/product",
//                "Price" => "//google.com",
//                "Category" => "/admin/category",
//            ),
//            "Systeminfo" => "/admin/systeminfo",
//            "Submenu" => array(
//                "Item1" => "//google.com",
//                "Sub2" => array(
//                    "Item1-1" => "/",
//                    "Item1-2" => "/",
//                    "Filemanager" => "/admin/filemanager",
//                ),
//                "Filemanager" => "javascript:;@@@filemanager-open",
//            ),
//        );
        return $arrTopNaviMenus;
    }
    
    //Load config/application.ini
    //In Module.php, use as $this->applicationConfig in controller
    public function loadConfig() {
        $reader = new IniReader();
        $data = $reader->fromFile(SITE_ROOT . '/config/application.ini');
        return $data;
    }
    
    //CMS Session Management
    public function sessionMng() {
        //Clear systeminfo session
        $this->session_systeminfo = new Container('session_systeminfo');
        $this->session_systeminfo->login = null;
        //Clear systeminfo session(END)
    }
            
}