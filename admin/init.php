<?php

//Database Connection file
include 'connect.php';
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

/*==================================
 # if any page has the variable named $noNavbar > our navigation will be hide.
 #if any page has no instruction aboit $noNavbar > Navigation Menu eill be show */

if (!isset($noNavbar)) {
	include $tpl . 'navbar.php';
}


?>