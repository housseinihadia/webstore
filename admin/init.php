<?php

include 'connect.php';


// pathes & roots

$tmp1 = 'includes/templets/'; //templet header & footer directory 

$lang = 'includes/langs/'; 

$func = 'includes/functions/'; // functions directory

$css = 'Design/css/'; // Css directory 

$js = 'Design/js/'; // js directory 



// imortant files 

include $func . 'function.php';

 include $lang . 'english.php'; // must be file language first

 include $tmp1 . "header.php";



// include navebar in all pages expect page contain nonavbar variable


  if(!isset($nonavbar)) {

  	include $tmp1 . "navbar.php";

  }