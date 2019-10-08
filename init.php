<?php


// Error reporting 
ini_set('display_error', 'On');
error_reporting(E_ALL);



//Database Connection file
include 'admin/connect.php';

$SessionUser = '';

if (isset($_SESSION['user'])) {
	
	$SessionUser = $_SESSION['user'];
}


/*=================
= Rounting for CSS,JS,Templates,image,languages,functions. 
===================*/

$css  = 'layout/CSS/';
$js  = 'layout/js/';
$tpl ='includes/tamplates/';
$img  = 'layout/images/';
$lang = 'includes/languages/';
$func  = 'includes/functions/';

include $func .'functions.php';
include $lang .'english.php';
include $tpl .'header.php';




?>