<?php 
session_start();
/*
if ($_SESSION['sha1password'] == sha1($userpass)) {

}*/
require_once 'models/config.php';		//asetukset
require_once 'models/functions.php';	//business logic
require_once 'models/admin.php';		//business logic admin sivuille
require_once 'models/parameters.php';	//parametri check
require_once 'templates/layout.php';	//view/template
?>