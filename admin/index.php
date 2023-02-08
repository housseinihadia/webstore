<?php 

	session_start();

    $nonavbar = '';
    $titlepage = 'Login';

	if(isset($_SESSION['username'])) {

		header('location: homepage.php'); // go to homepage page 
	}
   
    include 'init.php';

   

    // check if coming post request
    //55.564569

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

    	$user = $_POST['user'];

    	$pass = $_POST['pass']; 

    	$hashpass = sha1($pass); // to hash the password in db


    	//chek if user exist in database

    	$stmt = $con->prepare('SELECT UserID, Username, Password from users WHERE Username = ? AND Password = ? AND GroupID = 1 LIMIT 1');

    	$stmt->execute(array($user, $hashpass));

        $row = $stmt->fetch(); //to get data from database on array

    	$count = $stmt->rowcount();

    	// if count > 0 this mean the database contain record this username
    	// check is admine or member conut > 0 GroupID = 1

    	if($count > 0) {

    		$_SESSION['username'] = $user; //keep session from form

            $_SESSION['id'] = $row['UserID']; //get on ID from database by using array fetch and keep in session 

    		header('location: homepage.php'); // go to homepage page 
            
    		exit();

            
    	} else {

            echo '<div class="container">

                <div class="alert alert-danger">this user name not admin</div>   


            </div>';
        }



    	
    }

?>


<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>

	<h3 class="text-center">Admin login</h3>

	<input class= 'form-control' type="text" name="user" placeholder="Username" autocomplete="off">

	<input class= 'form-control' type="password" name="pass" placeholder="Password" autocomplete="new-password">

	<input class= 'btn btn-primary btn-block' type="submit" name="submit" value="login">


</form>



<?php include  $tmp1 . "footer.php"; ?>