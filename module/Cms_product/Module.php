<?php
namespace Cms_product;

use Zend\ModuleManager\ModuleManager;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Mvc\MvcEvent;

use Cms_product\Model\CMSProductTable;
use Cms_product\Model\CMSCategoryTable;
use Cms_core\Model\SEOTable;

define ('PRODUCT_MODULE_ROOT', __DIR__);//Point to project root
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        );
    }
    
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Cms_product\Model\CMSProductTable' => function($sm) {
                    $table = new CMSProductTable($sm->get('Zend\Db\Adapter\Adapter'));
                    return $table;
                },
                'Cms_product\Model\CMSCategoryTable' => function($sm) {
                    $table = new CMSCategoryTable($sm->get('Zend\Db\Adapter\Adapter'));
                    return $table;
                },
                'Cms_core\Model\SEOTable' => function($sm) {
                    $table = new SEOTable($sm->get('Zend\Db\Adapter\Adapter'));
                    return $table;
                },
            ),
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                // the array key here is the name you will call the view helper by in your view scripts
//                'systeminfoHelper' => function($sm) {
//                    $locator = $sm->getServiceLocator(); // $sm is the view helper manager, so we need to fetch the main service manager
//                    return new systeminfoHelper();
//                },
            ),
        );
    }
    
    public function init(ModuleManager $moduleManager)
    {
        $sm = $moduleManager->getEvent()->getParam('ServiceManager');
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) use ($sm) {
            // This event will only be fired when an ActionController under the MyModule namespace is dispatched.
            $pgCMSPlugin = $sm->get('ControllerPluginManager')->get('CMSPlugin');
            $controller = $e->getTarget();
            $controller->layout('layout/cms_layout');
            //$controller->layout()->topNaviMenus = $controller->CMSPlugin()->loadTopNavi();//auto load top navi
            $controller->layout()->topNaviMenus = $pgCMSPlugin->loadTopNavi();
            
            //Load application.ini to controller and layout
            //$controller->applicationConfig = $controller->CMSPlugin()->loadConfig();
            $controller->applicationConfig = $pgCMSPlugin->loadConfig();
            $controller->layout()->applicationConfig = $controller->applicationConfig;
            
            //Sesion mng except systeminfo
            $ignoreController = array(
                'Cms_Core\Controller\Filemanager',
                'Cms_Core\Controller\Systeminfo',
                'Cms_Core\Controller\Node',
            );
            $controllerName = $controller->params('controller');
            if(!in_array($controllerName, $ignoreController))
                //$controller->CMSPlugin()->sessionMng();
                $pgCMSPlugin->sessionMng();
        }, 100);
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('route', array($this, 'CMSAuthCheck'), 2);
    }
    
    public function CMSAuthCheck(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $router = $sm->get('router');
        $request = $sm->get('request');
        $matchedRoute = $router->match($request);
        if (null !== $matchedRoute) {
            $controller = $matchedRoute->getParam('controller');
            $action = $matchedRoute->getParam('action');

            // check auth...
            $strMatchRoute = $matchedRoute->getMatchedRouteName();
            if (substr($strMatchRoute,0,4)=='cms_' && $strMatchRoute != 'cms_auth' && !$sm->get('CMSAuthService')->hasIdentity()){
                 $url = $router->assemble(array(), array('name' => 'cms_auth'));

                 $response = $e->getResponse();
                 $response->setStatusCode(302);
                 $response->getHeaders()->addHeaderLine('Location', $url);
            }
        }
    }
    
}
