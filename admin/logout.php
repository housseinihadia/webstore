<?php 

session_start();

session_unset(); //unset the data

session_destroy(); 

header('location: index.php');

exit();

