<?php 
ini_set("display_errors","on");
error_reporting (E_ALL ^ E_NOTICE);
//error_reporting (E_ALL | E_DEPRECATED);
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

    
$rootDir = dirname(__FILE__);

set_include_path('.' . PATH_SEPARATOR . './library/'
	 . PATH_SEPARATOR . './application/models/'
	 . PATH_SEPARATOR . './application/lib/'
	 . PATH_SEPARATOR . get_include_path());
include "Zend/Loader.php";

/** Zend_Application */
require_once 'library/Zend/Application.php';



Zend_Loader::loadClass('Zend_Controller_Front');
Zend_Loader::loadClass('Zend_Registry');
Zend_Loader::loadClass('Zend_View');
Zend_Loader::loadClass('Zend_Config_Ini');
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_Db_Table');
Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
Zend_Loader::loadClass('Zend_Debug');
Zend_Loader::loadClass('Zend_Auth');

//cp -a osp/rams/. pxm_retail/

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini'
);

//GET ALL CONFIGURATION PAREMETER FROM THE CONFIG FILE
$config = new Zend_Config_Ini('application/configs/application.ini','production');  //FOR LINUX
$config_mail= new Zend_Config_Ini('application/configs/application.ini','mail');  //FOR LINUX


$siteurl     = $config->siteurl;
$sitedocroot = $_SERVER['DOCUMENT_ROOT'];
$site_asset     = $config->site_asset;

define('HOST', $config_mail->Host);
define('Username', $config_mail->Username);
define('Password', $config_mail->Password);
define('Port',$config_mail->Port);
define('From',$config_mail->From);
define('FromName',$config_mail->FromName);


define('SITEURL', $siteurl); //DEFINE SITE URL AS CONSTANT
define('SITEDOCROOT', $sitedocroot); //DEFINE SITE DOC ROOT AS CONSTANT
define('SITEASSET', $site_asset);
date_default_timezone_set('Asia/Singapore');
define('CD',date('Y-m-d H:i:s'));
define('OCD',date('Y-m-d'));
define('LIMIT',10);

define('salt_email_pre', "sieyt9sde66d nh55");
define('salt_email_post',"sstgbyer6t3455tie");
define('salt_pass_pre',  "sieysdvbstw455t92");
define('salt_pass_post', "sie755475bdbyt925");
$tranzgo_session 		= new Zend_Session_Namespace('tranzgo_session');
//echo 'this'; exit;

$array_max_passenger = array(1=>'1 - 4',2=>'4 - 7',3=>'8 - 11');

$application->bootstrap()->run();
?>