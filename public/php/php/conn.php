<?php
error_reporting (E_ALL ^ E_NOTICE);
ob_start();
//ini_set('session.bug_compat_warn',0);
ini_set('session.gc_maxlifetime', 1800);
ini_set('session.gc_divisor', 1);
ini_set('session.gc_probability', 1);
//date_default_timezone_set('Asia/Calcutta');
@session_start();

/*
	$db_server="exploreexamadmin.db.9496261.hostedresource.com";
	$db_username="exploreexamadmin";
	$db_password="Angshu@190613";
	$db_name="exploreexamadmin";
*/
$db_server="localhost";
$db_username="root";
$db_password="";
$db_name="bsc_work";
$db_conn=mysql_connect($db_server,$db_username,$db_password) or die("Couldn't connect to server");
mysql_select_db($db_name,$db_conn);

?>