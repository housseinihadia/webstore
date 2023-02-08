<?php 

/*
=======================
=== mange memberment page
=== you can add/ edit/ delete
===================================
*/
	session_start();

	$titlepage = 'Members Page';


	if(isset($_SESSION['username'])) {


		include 'init.php';

		// content of page

		  if(isset($_GET['do'])) { // move between pages through $do 

			$do = $_GET['do'];

		}
		 else {

			$do = 'mange';
		}

		// start mange page
		if($do == 'mange') { 

			$query = '';

			if(isset($_GET['page']) && $_GET['page'] == 'pending') {

				$query = 'AND RegStatus = 0';
			}


			//$qurey => variable to use the same statement in pending page   

			// select all records except admin

			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");

			$stmt->execute();

			$rows = $stmt->fetchall();

			if(! empty($rows)) {

			?> 

			<h1 class="text-center">Pending members</h1>

			<div class="container">
				<div class="table-reponsive">
					<table class="table text-center mange-member table table-bordered">
						<tr>
							<td>#ID</td>
							<td>#Image</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Registed Date</td>
							<td>control</td>
						</tr>

				
							
							<?php

								foreach($rows as $row) {

									echo "<tr>";
										echo "<td>" . $row['UserID'] .  "</td>";
										echo "<td>";
										if(empty($row["avatar"])) {
											echo "<img src='uploads/avatars/User-Default.jpg' alt=''/>";
										} else {
										           echo "<img src='uploads/avatars/" . $row["avatar"] . "' alt=''/>";
							             }
										echo "</td>";
										echo "<td>" . $row['Username'] .  "</td>";
										echo "<td>" . $row['Email'] .  "</td>";
										echo "<td>" . $row['Fullname'] .  "</td>";
										echo "<td>" . $row['Cur_date'] . "</td>";
										echo "<td>

										<a href='members.php?do=edit&userid=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
										<a href='members.php?do=delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

										if($row['RegStatus'] == 0) { // the user not activate

										 echo "<a href='members.php?do=activate&userid=" . $row['UserID'] . "' class='btn btn-info act'><i class='fa fa-plus-circle'></i>Activate</a>";

										}


										 echo "</td>";


									echo "</tr>";

								}


							?>
			</table>
				</div>

					<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>  New member</a>

			
			</div> <?php } else {
				           echo "<div class='container text-center'>";

							        echo  '<div class="alert alert-danger">No Pending Members here </div>';
							        echo '<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>  New member</a>';


					        echo "</div>";
			            } ?>

		<?php }

		elseif($do == 'add') { // in add page 

			$titlepage = 'Add member';

			?>



			  <h1 class="text-center">Add New member</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=insert" method="POST" enctype="multipart/form-data">
				<!--sart username-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Username</label>
						<div class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" placeholder="Type your Name" autocomplete="off" required='required'/>	
						</div>
				</div>
				<!--end username-->

					<!--sart Password-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Password</label>
						<div class="col-sm-10 col-md-6">
						<input type="Password" name="pass" class="password form-control" placeholder="Type your Password" required='required'>
						<i class="show-pass fa fa-eye fa-2x"></i>	
						</div>
				</div>
				<!--end Password-->

					<!--sart Email-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Email</label>
						<div class="col-sm-10 col-md-6">
						<input type="Email" name="email" placeholder="Type your Email" autocomplete="off" class="form-control" required='required'>	
						</div>
				</div>
				<!--end Email-->

					<!--sart Fullname-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Fullname</label>
						<div class="col-sm-10 col-md-6">
						<input type="text" name="full" placeholder="Type your Full Name" autocomplete="off" class="form-control" required='required'>	
						</div>
				</div>
				<!--end Fullname-->

				<!--sart image user-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Image User</label>
						<div class="col-sm-10 col-md-6">
						<input type="file" name="avatar" class="form-control">	
						</div>
				</div>
				<!--end image user-->

					<!--sart submit-->
				<div class="form-group">
							<div class="btn btn-block">
							     <input type="submit" value="Add member" class="btn btn-primary ">
							</div>
						</div>
				
				<!--end submit-->



					
				</form>


			</div>

		<?php } 

		elseif($do == 'insert') {// insert page


			

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Inserted member</h1>";

			    echo "<div class='container'>";

			    // Upload Files Variables

			   $file_name = $_FILES['avatar']['name']; //file name
			   $file_type = $_FILES['avatar']['type']; //file type
			   $file_temp = $_FILES['avatar']['tmp_name']; //path file
			   $file_size = $_FILES['avatar']['size'];    // file size

			   // list of permosion to Upload file
			   $file_allow_extention = array("jpg", "png", "gif");

			   //get file
			   $filt_extintion = strtolower(end(explode(".", $file_name)));



				$name  = $_POST['username'];
				$pass  = $_POST['pass'];
				$email = $_POST['email'];
				$full  = $_POST['full'];

				$hashpass = sha1($pass);


				//pass trick

	
				// validate form 

				$formerrors = array();

				if(strlen($name) < 4) {

					$formerrors[] = ' User cant be <storng> 4 </storng>character';
				}

				if(empty($name)) {

					$formerrors[] = ' User cant be <storng>Empty</storng>';
				}

				if(empty($email)) {

					$formerrors[] = 'Email cant be <storng>Empty</storng>';
				}

			    if(empty($pass)) {

					$formerrors[] = 'Pass cant be <storng>Empty</storng>';
				}

				if(empty($full)) {

					$formerrors[] = 'Fullname cant be <storng>Empty</storng>';
				}

				if(!empty($file_name) && !in_array($filt_extintion, $file_allow_extention)) {

					$formerrors[] = 'File is Not <storng>allow</storng>';
				}
				if(empty($file_name)) {

					$formerrors[] = 'File Not be <storng>Empty</storng>';

				}

				if($file_size > 45900259) { // size with miga byte mg

					$formerrors[] = 'File more than <storng>4mg</storng>';

				}

				foreach ($formerrors as $errors) {
					echo '<div class="alert alert-danger">' . $errors . '</div>';

				}

				if(empty($formerrors)) { // NO error

					$avatar = rand(0, 1000000) . '_' . $file_name;

					move_uploaded_file($file_temp, "uploads\avatars\\" . $avatar); 

			

					// use the function is check the if user has this name exist in database or not 

					$check = checkitem ('Username', 'users', $name);

					if($check == 1) { // exist username in with the same name

						$themsg = '<div class="alert alert-danger text-center">Sorry this Name exist </div>';

						redirecthome ($themsg, 'back', 5);

					} else {


								// insert un the database with info
								$stmt = $con->prepare('INSERT INTO users (Username, Password, Email, Fullname, RegStatus, Cur_date, avatar) VALUES (:name, :pass, :mail, :full, 1, now(), :avatar)');
								$stmt->execute(array(

									'name'   => $name,
									'pass'   => $hashpass,
									'mail'   => $email,
									'full'   => $full,
									'avatar' => $avatar

									));

							

							//echo sucsees message
							$themsg =  "<div class='alert alert-success text-center'>" . $stmt->rowcount() . ' Record Inserted sucssfuly </div>';

							redirecthome ($themsg);


				  }

				}

				

			
			} else { // if you dont coming throgh post request

				echo "<div class='container text-center'>";

					$themsg =  '<div class="alert alert-danger">Sorry you cant Redirect  this page</div>';

					redirecthome($themsg, 'back');

				echo "</div>";
			}

			echo "</div>";
		}
		

		elseif($do == 'edit') { //edit page 

					// check if request get is numeric value 

			     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;  //if condition 

			     // seleect on data depend on userid request

				$stmt = $con->prepare('SELECT * from users WHERE UserID = ? LIMIT 1 ');

				//execute this query on this check => $userid

		    	$stmt->execute(array($userid));

		    	//fetch the data

		        $row = $stmt->fetch(); //to get data from database on array

		    	$count = $stmt->rowcount();

		    	 //if there is data with this id show the form 
 	
		    	if($count > 0) { ?>

             <h1 class="text-center">Edit member</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=update" method="POST">
				<input type="hidden" name="userid" value="<?php echo $userid; ?>"> <!--transfer the data to update page by using hidden input-->
				<!--sart username-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Username</label>
						<div class="col-sm-10 col-md-6">
						<input type="text" name="username" class="form-control" value="<?php echo $row['Username']?>" autocomplete="off" required='required'/>	
						</div>
				</div>
				<!--end username-->

					<!--sart Password-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Password</label>
						<div class="col-sm-10 col-md-6">
						<input type="hidden" name="old-pass" value="<?php echo $row['Password']?>">
						<input type="Password" name="new-pass" class="form-control" placeholder="Leave Blank if you dont wnat to change" autocomplete="new-password">	
						</div>
				</div>
				<!--end Password-->

					<!--sart Email-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Email</label>
						<div class="col-sm-10 col-md-6">
						<input type="Email" name="email" value="<?php echo $row['Email']?>" autocomplete="off" class="form-control" required='required'>	
						</div>
				</div>
				<!--end Email-->

					<!--sart Fullname-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Fullname</label>
						<div class="col-sm-10 col-md-6">
						<input type="text" name="full" value="<?php echo $row['Fullname']?>" autocomplete="off" class="form-control" required='required'>	
						</div>
				</div>
				<!--end Fullname-->

					<!--sart submit-->
				<div class="form-group">
							<div class=" col-sm-offset-6 col-sm-6 ">
							     <input type="submit" value="save" class="btn btn-primary ">
							</div>
						</div>
				</div>
				<!--end submit-->



					
				</form>


			</div>



		    	<?php
		    	// else if not exist and less 0 
		    	  } else {

		    	  	echo "<div class='container text-center'>";

			    		$themsg =  '<div class="alert alert-danger">NO id in your selections </div>';

			    		redirecthome($themsg);

		    		echo "</div>";


		    	}

			?>
		
		<?php }

		elseif($do == 'update') { // update page

			echo "<h1 class='text-center'>Update member</h1>";

			echo "<div class='container'>";

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				$id = $_POST['userid']; // hidden input his value = old id
				$name = $_POST['username'];
				$email = $_POST['email'];
				$full = $_POST['full'];

				//pass trick

				$pass = '';

				if(empty($_POST['new-pass'])) { // no update in password field

					$pass = $_POST['old-pass'];

				} else {

					$pass = sha1($_POST['new-pass']);


				}

				// validate form 

				$formerrors = array();

				if(strlen($name) < 4) {

					$formerrors[] = ' User cant be <storng> 4 </storng>character';
				}

				if(empty($name)) {

					$formerrors[] = ' User cant be <storng>Empty</storng>';
				}

				if(empty($email)) {

					$formerrors[] = 'Email cant be <storng>Empty</storng>';
				}

				if(empty($full)) {

					$formerrors[] = 'Fullname cant be <storng>Empty</storng>';
				}

				foreach ($formerrors as $errors) {
					echo '<div class="alert alert-danger">' . $errors . "</div>";
				}

				if(empty($formerrors)) { //NO error

					// special check if we update the username is as the same name id db
					
					$stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");

					$stmt2->execute(array($name, $id));

					$count = $stmt2->rowcount();

					if($count == 1) {

						$themsg =  "<div class='alert alert-danger'>there is username this with name</div>";
						redirecthome($themsg, 'back');

					} else {


					// upadate the database with info

				$stmt = $con->prepare('UPDATE  users SET Username = ?, Email = ?, Fullname = ?, Password = ? WHERE UserID = ? ');
				$stmt->execute(array($name, $email, $full, $pass, $id));

				//echo sucsees message
				$themsg = "<div class='alert alert-success'>" . $stmt->rowcount() . ' Record Updated sucssfuly </div>';

				redirecthome($themsg, 'back');

					} 	
				}

				

				echo "</div>";

			
			} else {

				$themsg = '<div class="alert alert-danger text-center">Sorry you cant update this page</div>';

				redirecthome($themsg);
			}
			
		} elseif($do == 'delete') { // delete page

				// check if request get is numeric value 

			     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;  //if condition 

		    	 //check if the user exist in database 

		    	 $check = checkitem ('userid', 'users', $userid);
 	
		    	if($check > 0) { 

		    		$stmt = $con->prepare('DELETE FROM users WHERE UserID = :zuser');
		    		$stmt->bindparam(':zuser', $userid); // connect with $user
		    		$stmt->execute();

		    		$themsg =  "<div class='alert alert-success text-center'  style='margin-top:30px;'>" . $stmt->rowcount() . ' Record Delete sucssfuly </div>';

		    		redirecthome($themsg);


		    	} else {

		    		$themsg =  '<div class="alert alert-danger text-center"  style="margin-top:30px;">No Username in the Database</div>';

		    		redirecthome($themsg);
		    	}


		} elseif($do == 'activate') {

					// check if request get is numeric value 

			     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;  //if condition 

		    	 //check if the user exist in database 

		    	 $check = checkitem ('userid', 'users', $userid);
 	
		    	if($check > 0) { 

		    		$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

		    		$stmt->execute(array($userid));

		    		$themsg =  "<div class='alert alert-success text-center'  style='margin-top:30px;'>" . $stmt->rowcount() . ' Record Activate sucssfuly </div>';

		    		redirecthome($themsg);


		    	} else {

		    		$themsg =  '<div class="alert alert-danger text-center"  style="margin-top:30px;">No Username in the Database</div>';

		    		redirecthome($themsg);
		    	}
		}


		include $tmp1 . "footer.php";


	} else {

		header('location: index.php');

		exit();
	}
