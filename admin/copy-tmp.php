<?php 

/*
=======================
=== Categories page
===================================
*/
	ob_start();

	session_start();

	$titlepage = 'Categories';


	if(isset($_SESSION['username'])) {


		include 'init.php';

		// content of page

		  $do = (isset($_GET['do'])) ? $_GET['do'] : 'mange'; // move between pages through $do

		  if($do =- 'mange') {

		  	echo 'welcom';
		  }

		  elseif($do == 'add') {


		  }

		  elseif($do == 'edit') {

		  	
		  }

		  elseif($do == 'update') {

		  	
		  } 

			

		  include  $tmp1 . "footer.php";


		}else{

			header('location:index.php');
		}

		ob_end_flush();

		?>
