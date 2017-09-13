<?php
error_reporting (E_ALL ^ E_NOTICE);
ob_start();
//ini_set('session.bug_compat_warn',0);
ini_set('session.gc_maxlifetime', 1800);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_probability', 1);
date_default_timezone_set('Asia/Calcutta');
@session_start();

/*
	$db_server="exploreexamadmin.db.9496261.hostedresource.com";
	$db_username="exploreexamadmin";
	$db_password="Angshu@190613";
	$db_name="exploreexamadmin";
*/
	$db_server="mysql1416.ixwebhosting.com";
	$db_username="C351186_mobile";
	$db_password="WDC123";
	$db_name="C351186_ram";


$db_conn=mysql_connect($db_server,$db_username,$db_password) or die("Couldn't connect to server");
mysql_select_db($db_name,$db_conn);



define("ADMIN_EMAIL","admin@talentangle.com");
define("LIMIT","10"); 		// number of rows display for listing (pagination)
define("ADJACENTS","3");	// number of rows display for listing (pagination)

define("USER_LIMIT","10"); 		// number of rows display for listing (pagination)
define("USER_ADJACENTS","1");	// number of rows display for listing (pagination)

$CD=date("Y-m-d H:i:s");
$OCD=date("Y-m-d");
//$OCD="2012-12-14";
$AD=$_SESSION['MG_USER']['adminid'];


//$pg_name=basename($_SERVER['PHP_SELF']); 


?>