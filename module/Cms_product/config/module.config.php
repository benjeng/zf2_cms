<?php
return array(
    'router' => array(
        'routes' => array(
            'cms_product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/product[/[:action][/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Cms_product\Controller\Product',
                        'action'     => 'index',
                    ),
                ),
            ),
            'cms_category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/category[/[:action][/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Cms_product\Controller\Category',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Cms_product\Controller\Product' => 'Cms_product\Controller\ProductController',
            'Cms_product\Controller\Category' => 'Cms_product\Controller\CategoryController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'cms_product' => __DIR__ . '/../view',
            'cms_category' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'view_helpers' => array(  
        'invokables' => array(  
            'formFilemanager' => 'Cms_core\View\Helper\FilemanagerHelper',
            'cmsFormHelper' => 'Cms_core\View\Helper\formHelper',
        )  
    ),
);