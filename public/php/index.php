<?php
ini_set("display_errors","on");
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));


//Ensure zend library is on include_path   
$rootDir = dirname(__FILE__);
set_include_path($rootDir . '/library' . PATH_SEPARATOR . get_include_path());    


/** Zend_Application */
require_once 'library/Zend/Application.php';  



// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini'
);


$config = new Zend_Config_Ini('application/configs/application.ini','production');  //FOR LINUX



$application->bootstrap()->run();
?>