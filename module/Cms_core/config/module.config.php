<?php
return array(
    'router' => array(
        'routes' => array(
            'cms_core' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin[/[:action][/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Cms_core\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'cms_auth' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/auth[/[:action]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Cms_core\Controller\CMSAuth',
                        'action'     => 'login',
                    ),
                ),
            ),
            'cms_systeminfo' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/systeminfo[/[:action]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Cms_core\Controller\Systeminfo',
                        'action'     => 'index',
                    ),
                ),
            ),
            'cms_filemanager' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/filemanager[/[:action]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Cms_core\Controller\Filemanager',
                        'action'     => 'index',
                    ),
                ),
            ),
            'cms_article' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/article[/[:action][/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Cms_core\Controller\Article',
                        'action'     => 'index',
                    ),
                ),
            ),
            'cms_node' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/node[/[:action][/:id[/:param[/:source]]]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Cms_core\Controller\Node',
                        'action'     => 'index',
                    ),
                ),
            ),
            'cms_user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/user[/[:action][/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Cms_core\Controller\User',
                        'action'     => 'index',
                    ),
                ),
            ),
            'cms_seo' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/seo[/[:action][/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Cms_core\Controller\Seo',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Cms_Core\Controller\CMSAuth' => 'Cms_core\Controller\CMSAuthController',
            'Cms_core\Controller\Index' => 'Cms_core\Controller\IndexController',
            'Cms_core\Controller\Article' => 'Cms_core\Controller\ArticleController',
            'Cms_core\Controller\Node' => 'Cms_core\Controller\NodeController',
            'Cms_core\Controller\User' => 'Cms_core\Controller\UserController',
            'Cms_core\Controller\Systeminfo' => 'Cms_core\Controller\SysteminfoController',
            'Cms_core\Controller\Filemanager' => 'Cms_core\Controller\FilemanagerController',
            'Cms_core\Controller\Seo' => 'Cms_core\Controller\SeoController',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'CMSPlugin' => 'Cms_core\Controller\Plugin\CMSPlugin',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'cms_core' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'systeminfo_LeftNavi' => __DIR__ . '/../view/cms_core/systeminfo/_partialLeftNavi.phtml',
            'layout/cms_layout' => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'form_elements' => array(
        'invokables' => array(
            'filemanager' => 'Cms_core\Form\Element\Filemanager'
        )
    ),
    'view_helpers' => array(  
        'invokables' => array(  
            'formFilemanager' => 'Cms_core\View\Helper\FilemanagerHelper',
            'cmsFormHelper' => 'Cms_core\View\Helper\formHelper',
        )  
    ),
);