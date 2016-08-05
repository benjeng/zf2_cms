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

// Generic Controller
class Gen01Controller extends AbstractActionController
{
    protected $prefetch_article_id;
    
    public function __construct($_id=null) {
        $this->prefetch_article_id = $_id;
    }
    
    public function indexAction()
    {
        $sm = $this->getServiceLocator();
        $this->nodeTable = $sm->get('Cms_core\Model\CMSNodeTable');
        $this->articleTable = $sm->get('Cms_core\Model\CMSArticleTable');
        $this->seoTable = $sm->get('Cms_core\Model\SEOTable');
        
        //Get homepage Article
        $thePageArticle = $this->articleTable->getByField("id", $this->prefetch_article_id);
        $article_id = $thePageArticle->id;

        //Get SEO
        $objSEO = $this->seoTable->getRecord($article_id);//return an object
        
        return new ViewModel(array(
            "seo"       => $objSEO,
            "page_article"=> $thePageArticle,
            )
        );
    }
}
