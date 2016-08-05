<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/
define('PUBLIC_ROOT', realpath(__DIR__ . "/../"));//point to public folder
define('SITE_ROOT', realpath(PUBLIC_ROOT . "/../"));//Point to project root
define('CORE_ROOT', realpath(SITE_ROOT . "/module/cms_core"));//Point to project root

return array(
    'cms-js' => array(
        '//js/jquery.min.js',
        CORE_ROOT . '/src/Cms_core/public/js/jquery.ui.min.js',
        CORE_ROOT . '/src/Cms_core/public/js/jquery.effects.core.js',
        CORE_ROOT . '/src/Cms_core/public/js/jquery.tabSlideOut.v1.3.js',
        CORE_ROOT . '/src/Cms_core/public/js/plupload/js/plupload.full.js',
        CORE_ROOT . '/src/Cms_core/public/js/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js',
        CORE_ROOT . '/src/Cms_core/public/js/jquery.easyui.min.js',
        CORE_ROOT . '/src/Cms_core/public/js/cms_topnavi.js',
        CORE_ROOT . '/src/Cms_core/public/js/cms_admin.js',
        CORE_ROOT . '/src/Cms_core/public/js/cms_filemanager.js',
        CORE_ROOT . '/src/Cms_core/public/js/redactor.js',
    ),
    'cms-css' => array(
        CORE_ROOT . '/src/Cms_core/public/css/easyui.css',
        CORE_ROOT . '/src/Cms_core/public/css/easyui_icon.css',
        CORE_ROOT . '/src/Cms_core/public/css/cms_filemanager.css',
        CORE_ROOT . '/src/Cms_core/public/js/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css',
        CORE_ROOT . '/src/Cms_core/public/css/datepicker.css',
        CORE_ROOT . '/src/Cms_core/public/css/systeminfo.css',
        CORE_ROOT . '/src/Cms_core/public/css/cms_topnavi.css',
        CORE_ROOT . '/src/Cms_core/public/css/cms_style.css',
        CORE_ROOT . '/src/Cms_core/public/css/redactor.css',
    ),
    'site-css' => array(
        PUBLIC_ROOT . '/css/jquery.glide.css',
        PUBLIC_ROOT . '/css/style.css',
    ),
    'site-js' => array(
        PUBLIC_ROOT . '/js/jquery.bpopup.min.js',
        PUBLIC_ROOT . '/js/jquery.glide.min.js',
        PUBLIC_ROOT . '/js/site.js',
    ),
);