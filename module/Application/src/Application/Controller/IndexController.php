<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $sm = $this->getServiceLocator();
        $this->nodeTable = $sm->get('Cms_core\Model\CMSNodeTable');
        $this->articleTable = $sm->get('Cms_core\Model\CMSArticleTable');
        $this->seoTable = $sm->get('Cms_core\Model\SEOTable');
        
        //Get homepage Article
        $homePageArticle = $this->articleTable->getByField("cms_url", "/");
        $article_id = $homePageArticle->id;
        
        //Get slide from Node
        $root_id = $this->nodeTable->getRootId($article_id, 'article');
        $nodeRecords = $this->nodeTable->getChildren($root_id, 'home_slide');
        foreach($nodeRecords as $item){
            $arrTmp = json_decode($item->json, true);
            $arrSlides[] = array(
                "img"   => "/tmp" . $arrTmp["node_field2"],
                "title" => $arrTmp["title"],
            );
        }

        //Get product from Node
        $productRecords = $this->nodeTable->getChildren($root_id, 'home_product');
        foreach($productRecords as $item){
            $arrTmp = json_decode($item->json, true);
            $productCategory = $arrTmp['category'];
            $arrProducts[$productCategory][] = array(
                "img"   => "/tmp" . $arrTmp["node_field2"],
                "name"  => $arrTmp["node_field1"],
                "price" => $arrTmp["node_field3"],
                "title" => $arrTmp["title"],
            );
        }

        //Get SEO
        $objSEO = $this->seoTable->getRecord($article_id);//return an object
        
        return new ViewModel(array(
            "slides"    => $arrSlides,
            "products"  => $arrProducts,
            "seo"       => $objSEO,
            "page_article"=> $homePageArticle,
            )
        );
    }
}
