<?php 

/*
movement between the pages by using get request

[mange | edit | update | delete | iknsert] => this is pages

*/
$do = '';

if(isset($_GET['do'])) {

	$do = $_GET['do'];

}
 else {

	$do = 'mange';
}

// if the page is main 

if($do == 'mange') {

	echo 'welcome in main page';

} elseif ($do == 'update') {
	
	echo 'welcom in update page';

} elseif($do == 'insert') {

	echo 'welcom in insert page';

} else {

	echo 'Error this false page ';
}

