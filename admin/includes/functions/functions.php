<?php
/*
===================================
Title Function  That Echo Page Title In case The Page Has The variable $pageTitle and Echo Deafult Tttle For other page.
===================================
*/

	function getTitle(){

		global  $pageTitle;

		if (isset($pageTitle)) {
			echo $pageTitle;
		}else{
			echo 'Deafult';
		}
	}

/*
===================================
= Get ALL data from DATABASE
=To get all the recors from databse table
===================================
*/
 function getAllFrom($field,$table, $where = NULL,$and = NULL, $orderingField ){

   global $con;

   $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY   $orderingField ");
   $getAll->execute(); 
   $all = $getAll->fetchAll();
   return $all;
 }


/*
===================================
= Check Item Function 
= $select = The Item To Select from The Table [Example : Username, Fullname etc]
=$form = The table to Select From Database [users]
=$value = The Value of Select [Example : salman, shahed etc]
===================================
*/

	function CheckItem($select, $form,$value){

		global $con;

		$statement = $con->prepare("SELECT $select From $form WHERE $select=?");
		$statement-> execute(array($value));
		$count = $statement->rowCount();
		return $count;

	}

/*
===================================
=[This Function Accept Parameter ]
=$theMsg = Echo The Message [Error | Success | Warning]
=$url = The Link You Want to Redirect 
=$second = Seconds Before Redirect  
===================================
*/

function redirectHome($theMsg,$url = null, $seconds =3){

	if ($url === null) {
		
		$url = 'index.php';
		$link - 'Homepage';
	}
	else {
		//Condition? True : False 
		$url = isset($_SERVER['HTTP_REFFER']) && $_SERVER['HTTP_REFFER'] !== ''? $_SERVER['HTTP_REFFER']: 'index.php';
		
		$link = 'Previous Page';
	}
	echo $theMsg;

	echo "<div class='alert alert-info'>You will be redirect to $link after $seconds seconds. </div>";

	header("refresh:$seconds; url= $url");
	exit();
}

/*
===================================
*Get the latest record function for total members
*Function to get latest Info Database [Users,Items,Comments]
*$select = field to select
*$table = the table we want to select
*$order = Define latest info  ASC | DESC
*$limit = Number to get the latest infor limit

===================================
*/

function getLatest($select, $table, $order, $limit=5 ){
	global $con ;

	$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY  $order ASC LIMIT $limit ");
	$getStmt->execute();
	$rows = $getStmt->fetchAll();
	return $rows;
}



/*
* Count the Total members from the table
*$members = to select all the members
*$table = to select the required table
*/

function countMembers($members,$table ){

  global $con;
  $stmt2 = $con->prepare("SELECT COUNT(UserID) FROM $table ");
   $stmt2->execute();
   echo  $stmt2->fetchcolumn();

}


/*
* Count the Total Items from the table
*$items = to select all the Items
*$table = to select the required table
*/

function countItems($items,$table ){

  global $con;
  $stmt2 = $con->prepare("SELECT COUNT(Item_ID) FROM $table ");
   $stmt2->execute();
   echo  $stmt2->fetchcolumn();

}







?>