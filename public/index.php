<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
define('PUBLIC_ROOT', __DIR__);//point to public folder
define('SITE_ROOT', realpath(PUBLIC_ROOT . "/../"));//Point to project root
define('CORE_ROOT', realpath(SITE_ROOT . "/module/cms_core"));//Point to project root

chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
