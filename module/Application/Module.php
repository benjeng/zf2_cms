<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();

        //This snippet is coming from http://stackoverflow.com/questions/18942786/zf2-dynamic-routing
        $eventManager->attach (MvcEvent::EVENT_ROUTE, function (MvcEvent $e) {
            $controller_loader = $e->getApplication ()->getServiceManager ()->get ('ControllerLoader');
            $controller = $e->getRouteMatch ()->getParam ('controller');
            $article_id = null;

            // Verify article exists?
            if(strpos($controller, "\\")===false){// General Pages
                $controller_class = "Application\\Controller\\" . ucfirst ($controller).'Controller';
                $articleTable = $e->getApplication()->getServiceManager()->get('Cms_core\Model\CMSArticleTable');
                $cms_url = "/" . $controller;
                $thisPageArticle = $articleTable->getByField("cms_url", $cms_url, true);
                if(!$thisPageArticle && $cms_url!='/Index'){//not found
                    die("Sorry! Page not found!");
                }else if(!class_exists($controller_class)){
                    if($thisPageArticle->cms_template != 'general'){
                        die("Sorry! ".$controller_class. " not found!");
                    }else{
                        $controller_class = "Application\\Controller\\" . "Gen01Controller";
                        $article_id = $thisPageArticle->id;
                        //die("Use generic controller");
                    }
                }else{//Found Controller
                    $article_id = @$thisPageArticle->id;
                }
            }else{// Admin Pages, with specified rounting
                $controller_class = ucfirst ($controller).'Controller';
            }
            // Verify article exists?(END)
        
            // Add service locator to the controller
            $controller_object = new $controller_class($article_id);
            $controller_object->setServiceLocator ($e->getApplication ()->getServiceManager ());
            // ------------------------------------
            $controller_loader->setService ($controller, $controller_object);
        });
        
//        $eventManager->attach (MvcEvent::EVENT_ROUTE, function (MvcEvent $e) {
//            $controller = $e->getRouteMatch ()->getParam ('controller');
//            $controller_class = "Application\\Controller\\" . ucfirst ($controller).'Controller';
//            if (!class_exists($controller_class)) {
//                die($controller_class." not found!");
//            }
//        });
        
        //This snippet is zf2 original
//        $moduleRouteListener = new ModuleRouteListener();
//        $moduleRouteListener->attach($eventManager);
    }

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
        );
    }
}
