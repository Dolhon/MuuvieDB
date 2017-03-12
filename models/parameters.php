<?php


//parametrien oletus arvot
$view = "listMovies";
$id = 1;
$cat = "all";
$security_level = "admin";

//tarkistaa onko view olemassa
if(isset($_GET['p'])) 
{
	if (array_key_exists($_GET['p'], $views)) {
		$view = $_GET['p'];
		$security_level = "guest";
	} else if (array_key_exists($_GET['p'], $admin_views))
	{
		$view =  $_GET['p'];
		require_once 'models/admin.php';	//admin funktiot
	} else {
		$view = "error";
	}
}
//tarkistaa onko elokuvan id olemassa
if(isset($_GET['id'])) 
{
	$movies = get_all_movies();
	$movieID = array();
	foreach ($movies as $row) {
		$movieID[] = $row['movieID'];
	}
	if (in_array($_GET['id'], $movieID)) {
		$id = $_GET['id'];
	} else {
		$id = 1;
		$view = "error";
	}
}
//tarkistaa onko elokuva kategoria olemassa
if(isset($_GET['cat'])) 
{
	$categories = get_all_categories();
	$catID = array();
	foreach ($categories as $row) {
		$catID[] = $row['categoryID'];
	}
	if (in_array($_GET['cat'], $catID)) {
		$cat = $_GET['cat'];
	} else {
		$cat = "all";
		$view = "error";
	}
}


?>