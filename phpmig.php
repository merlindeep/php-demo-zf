<?php
define('APPLICATION_ENV', getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development');
define('MIGRATIONS_PATH', getenv('MIGRATIONS_PATH') ? getenv('MIGRATIONS_PATH') : 'migrations');
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Set some constants
define('PHPMIG_PATH', realpath(dirname(__FILE__)));

define('VENDOR_PATH', APPLICATION_PATH . '/../vendor');
set_include_path(get_include_path() . PATH_SEPARATOR . VENDOR_PATH);

define('APPCONFIG_FILE_NAME', APPLICATION_PATH . '/configs/application.ini');

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

/** Zend_Application */
require_once 'Zend/Application.php';
// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPCONFIG_FILE_NAME
);


$application->bootstrap();

use \Phpmig\Adapter,
    \Phpmig\Pimple\Pimple;

$container = new Pimple();

$container['db'] = $container->share(function() {
    return Mrl_Instance::db('dbmig');
});

$container['phpmig.adapter'] = $container->share(function() use ($container) {
    $db = $container['db'];
    $configuration = Zend_Registry::get(Mrl_Constants::REG_KEY_PHP_MIG);
    return new Phpmig\Adapter\Zend\Db($db, $configuration);
});

$container['phpmig.migrations'] = function() {
    $files = array();
    foreach (explode(":", MIGRATIONS_PATH) as $path) {
        $files = array_merge(
            $files,
            glob(APPLICATION_PATH . '/../'.$path. '/*.php')
        );
    }
    return $files;
};
return $container;