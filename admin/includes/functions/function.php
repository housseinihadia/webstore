<?php 


/*
** General Function 
** Get all records in any tables in data base and can be access 
** function to get records  from database  

*/
function getall ($field, $table, $where = NULL, $and = NULL, $orderby, $orderfeild = 'DESC') {

	global $con;

	$stmt = $con->prepare("SELECT $field From $table $where $and ORDER BY $orderby $orderfeild");

	$stmt->execute();

	$all = $stmt->fetchall();

	return $all; 
}


















/*
** this function print title page if 
contain $titlepage variable or print  default title
*/


function print_title() {

	global $titlepage;

	if(isset($titlepage)) {

		echo $titlepage;

	} else {

		echo 'default';

	}
}

/*
** Home redirect Function to home page v2.0
** function accept parameters 
** $themsg = the message will be [error | success | warning]
** $url = the link you want redirect to it
** $secound = the secounds befot redirect  
*/

function redirecthome ($themsg, $url = null,  $secound = 3) {

	if($url === null) { // if leave $url [argument] null in Calling function

		$url = 'index.php';

		$link = 'home page';

	} else {

		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') { // you coming from page befor this

			$url = $_SERVER['HTTP_REFERER']; // go to back
			$link = 'previous page';

		} else { // you don't coming from page and not exist HTTP_REFERRER

			$url = 'index.php';
			$link = 'home page';

		}

		

	}

			echo $themsg;

			echo "<div class='container text-center'>";

				echo "<div class='alert alert-info'>You will be redirect to $link after $secound secounds </div>";

			echo "</div>";

	        header("refresh:$secound;url=$url");

	       exit();

}

/*
** check User in the database or not v1.0 
**function to check item in database
** function accept parameters
** $select = the item to select [example: Username, Item]
** $from = the table to select [examle: users table]
** $value = the value of select [example: the value coming from form such as ?]
*/

function checkitem ($select, $from, $value) { // check if the user have the same user or item name in database or not if == 1 then exsist in db 

	global $con;

	$stmt2 = $con->prepare("SELECT $select FROM $from WHERE $select = ?" );

	$stmt2->execute(array($value));

	$count2 = $stmt2->rowcount();

	return $count2;
}

/*
** check count of items v1.0
** check the numbers of users in database
** function have 2 arg
** $items = count of itnems
** $table = table

*/
function countItems($items, $table) {

	global $con;

	$stmt2 = $con->prepare("SELECT count($items) FROM $table");

	$stmt2->execute();
	
	return $stmt2->fetchcolumn();
}

/*
** Get least records 
** function to get least Items from database [items, users, comments]
** function accepted parameters
** $select = feild to select 
** $table = the table to choose from 
** $order = whiche the field I need do sorting 
** $limit = number of records to get it  
*/
/*
function getleast ($select, $table, $order, $limit = 5) {

	global $con;

	$stmt = $con->prepare("SELECT $select From $table ORDER BY $order DESC LIMIT $limit");

	$stmt->execute();

	$row = $stmt->fetchall();

	return $row;

}
*/
function getleast ($select, $table, $order, $limit = 5) {

	global $con;

	$stmt = $con->prepare("SELECT $select  From $table ORDER BY $order ASC LIMIT $limit");

	$stmt->execute();

	$row = $stmt->fetchall();

	return $row; 
}





