<?php
ob_start();
session_start();
error_reporting(1);
define('SITEURL','https://checkaim.com/');
define('LEADURL','https://checkaim.com/dashboard/');
define('ADMINURL','https://checkaim.com/newadmin/');
define('ADMINURLUSER','https://checkaim.com/newadmin/clients.php');
define('ROOT', __DIR__);
$host = "localhost";
$username = "cadbuser";
$password = "54?nUl1x"; 
$databasename = "checkaim";
$prefix = "av_";
$lines  = 10;
$currSymbol  = "&pound;";
require_once('function.php');
$con = connect($host, $username,  $password, $databasename);



?> 