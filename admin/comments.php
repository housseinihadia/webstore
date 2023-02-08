<?php 

/*
=======================
=== mange comments page
=== you can / edit/ update /delete
===================================
*/
	session_start();

	$titlepage = 'Comments Page';


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

			// select all records except admin

			$stmt = $con->prepare("SELECT comments.*, items.Name AS item_name, users.Username AS username FROM comments INNER JOIN

			 items ON items.Item_id = comments.item_id INNER JOIN users ON users.UserID = comments.user_id ORDER BY c_id DESC");

			$stmt->execute();

			$rows = $stmt->fetchall();

			if(! empty($rows)) {

			?> 

			<h1 class="text-center">manage comments</h1>

			<div class="container">
				<div class="table-reponsive">
					<table class="table text-center table table-bordered">
						<tr>
							<td>ID</td>
							<td>Comment</td>
							<td>Status</td>
							<td>Date</td>
							<td>Item</td>
							<td>User</td>
							<td>Control</td>

						</tr>

				
							
							<?php

								foreach($rows as $row) {

									echo "<tr>";
										echo "<td>" . $row['c_id'] .  "</td>";
										echo "<td>" . $row['comment'] .  "</td>";
										echo "<td>" . $row['status'] .  "</td>";
										echo "<td>" . $row['comment_date'] .  "</td>";
										echo "<td>" . $row['item_name'] . "</td>"; // from as .... query 
										echo "<td>" . $row['username'] . "</td>"; // from as .... query
										echo "<td>

										<a href='comments.php?do=edit&commid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
										<a href='comments.php?do=delete&commid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

										if($row['status'] == 0) { // the user not activate

										 echo "<a href='comment.php?do=approve&commid=" . $row['c_id'] . "' class='btn btn-info act'><i class='fa fa-plus-circle'></i>Activate</a>";

										}


										 echo "</td>";


									echo "</tr>";

								}


							?>
			</table>
				</div>

			
			</div> 
			<?php } else {

                          echo "<div class='container text-center'>";
							        echo  '<div class="alert alert-danger">No comment here </div>';
			                        echo "</div>";
			} ?>

		<?php }	

		elseif($do == 'edit') { //edit page 

					// check if request get is numeric value 

			     $commid = isset($_GET['commid']) && is_numeric($_GET['commid']) ? intval($_GET['commid']) :0;  //if condition 

			     // seleect on data depend on userid request

				$stmt = $con->prepare('SELECT * from comments');

				//execute this query on this check => $userid

		    	$stmt->execute(array($commid));

		    	//fetch the data

		        $row = $stmt->fetch(); //to get data from database on array

		    	$count = $stmt->rowcount();

		    	 //if there is data with this id show the form 
 	
		    	if($count > 0) { ?>

             <h1 class="text-center">Edit comment</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=update" method="POST">
				<input type="hidden" name="commid" value="<?php echo $commid; ?>"> <!--transfer the data to update page by using hidden input-->
				<!--sart username-->
				<div class="form-group">
						<label class="col-sm-2 label-control">Username</label>
						<div class="col-sm-10 col-md-6">
						<textarea class="form-control" name="comment"><?php echo $row['comment']?></textarea>
						</div>
				</div>
				<!--end username-->


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

			echo "<h1 class='text-center'>Update Comment</h1>";

			echo "<div class='container'>";

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				$commid = $_POST['commid']; // hidden input his value = old id

				$comment = $_POST['comment'];

				$stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");

				$stmt->execute(array($comment, $commid));

				//echo sucsees message
				$themsg = "<div class='alert alert-success'>" . $stmt->rowcount() . ' Record Updated sucssfuly </div>';

				redirecthome($themsg, 'back'); 

			} else {

				$themsg = '<div class="alert alert-danger text-center">Sorry you cant update this page</div>';

				redirecthome($themsg);
			}


			
		} elseif($do == 'delete') { // delete page

					// check if request get is numeric value 

			     $commid = isset($_GET['commid']) && is_numeric($_GET['commid']) ? intval($_GET['commid']) :0;  //if condition 

		    	 //check if the user exist in database 

		    	 $check = checkitem ('c_id', 'comments', $commid);
 	
		    	if($check > 0) { 

		    		$stmt = $con->prepare('DELETE FROM comments WHERE c_id = :zid');

		    		$stmt->bindparam(':zid', $commid); // connect with $user

		    		$stmt->execute();

		    		$themsg =  "<div class='alert alert-success text-center'  style='margin-top:30px;'>" . $stmt->rowcount() . ' Record Delete sucssfuly </div>';

		    		redirecthome($themsg, 'back');


		    	} else {

		    		$themsg =  '<div class="alert alert-danger text-center"  style="margin-top:30px;">No Username in the Database</div>';

		    		redirecthome($themsg);
		    	}


		} elseif($do == 'approve') {

		  		echo "<h1 class='text-center'>Approve comment</h1>";
		  		echo "<div class='continer'>";
		  		 // check if request get is numeric value 

			     $commid = isset($_GET['commid']) && is_numeric($_GET['commid']) ? intval($_GET['commid']) :0;  //if condition 


		    	 //check if the user exist in database 

		    	 $check = checkitem ('c_id', 'comments', $commid);
 	
		    	if($check > 0) { 

		    		$stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ? ");

		    		$stmt->execute(array($commid));

		    		$themsg =  "<div class='alert alert-success text-center' style='margin-top:30px;'>" . $stmt->rowcount() . ' Record Activate sucessfuly </div>';

		    		redirecthome($themsg,'back');


		    	} else {

		    		$themsg =  '<div class="alert alert-danger text-center"  style="margin-top:30px;">No Items in the Database</div>';

		    		redirecthome($themsg);
		    	}

		    	echo "</div>";

		  }	


		include $tmp1 . "footer.php";


	} else {

		header('location: index.php');

		exit();
	}
