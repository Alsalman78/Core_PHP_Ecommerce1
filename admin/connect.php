<?php
 //Database connection Using PDO [PHP DATA OBJECT]

$dsn  = 'mysql:host=localhost;dbname=WOC';
$user ='salman';
$pass ='wszD8aIZPRl38gFG';

$option =  array(

	PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
);

try{

	$con = new PDO($dsn,$user,$pass,$option);
	$con -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	//Check The Database Connection stablish or not 

	//echo 'Database connection is established.';
}
catch(PDOEXCEPTION $e){

	echo 'Database connection failed.';

}

?>