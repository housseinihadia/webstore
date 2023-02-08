<?php 

/*
=======================
=== Items  page
===================================
*/
	ob_start();

	session_start();

	$titlepage = 'Items';


	if(isset($_SESSION['username'])) {


		include 'init.php';

		// content of page

		  $do = (isset($_GET['do'])) ? $_GET['do'] : 'mange'; // move between pages through $do

		  if($do == 'mange') {
		  				
		  			$stmt = $con->prepare("SELECT items.*,
		  			                                   categories.Name AS categry_name, 
		  			                                    users.Username AS User_item
		  			                                       from items

												INNER JOIN categories ON  categories.ID = items.Cat_id

												INNER JOIN users ON  users.UserID = items.Member_id 
												ORDER BY Item_id DESC ");
		  			$stmt->execute();

		  			$items = $stmt->fetchall();

		  			if(! empty ($items)) { 
		  			 ?>
		  			

		  			<h1 class="text-center">Mange Items</h1>
		  			<div class="container">
		  				
		  				<div class="table-reponsive">
		  					<table class="table text-center table table-bordered">

		  						<tr>
		  							<td>#ID</td>
		  							<td>#Name</td>
		  							<td>#Description</td>
		  							<td>#Price</td>
		  							<td>#Date</td>
		  							<td>#Category</td>
		  							<td>#Username</td>
		  							<td>#Control</td>
		  						</tr>
		  						<?php

		  							foreach($items as $item) {

		  								echo "<tr>";

		  									echo "<td>" . $item['Item_id'].  "</td>";
		  									echo "<td>" . $item['Name'].  "</td>";
		  									echo "<td>" . $item['Description'].  "</td>";
		  									echo "<td>" . $item['Price'].  "</td>";
		  									echo "<td>" . $item['Add_date'].  "</td>";
		  									echo "<td>" . $item['categry_name'].  "</td>";
		  									echo "<td>" . $item['User_item'].  "</td>";
		  									echo "<td>

		  											<a href='items.php?do=edit&itemid=" . $item['Item_id'] . "'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
		  											<a href='items.php?do=delete&itemid=" . $item['Item_id'] . "'class='btn btn-danger'><i class='fa fa-close'></i>Delete</a>";

		  								 if($item['Approve'] == 0) { // the user not activate

										 echo "<a href='items.php?do=approve&itemid=" . $item['Item_id'] . "' class='btn btn-info act'><i class='fa fa-check'></i>Activate</a>";

										}
		  								  echo "</td>";

		  								echo "</tr>";
		  							}


		  						 ?>
		  						
		  					</table>
		  				</div>

		  					<a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>  New Item</a>

		  			</div>
					<?php } else {
				           echo "<div class='container text-center'>";

							        echo  '<div class="alert alert-danger">No Record here </div>';
							        echo '<a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>  New Item</a>';

					        echo "</div>";

					} ?>



		  	 <?php }

		  elseif($do == 'add') { ?>

		  	<h1 class="text-center">Add New Item</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=insert" method="POST" enctype="multipart/form-data">
				<!--sart name-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Name</label>
						<div class="col-sm-10 col-md-6">
						  <input type="text" name="name" class="form-control" placeholder="write the Name of Item"/>	
						</div>
				</div>
				<!--end name-->

					<!--sart Description-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Description</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="descption" class="form-control" placeholder="Type your Description" />
						
						</div>
				</div>
				<!--end Description-->

					<!--sart price-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Price</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="price" placeholder="Type your Price" class="form-control"/>	
						</div>
				</div>
				<!--end price-->

					<!--sart country of made-->
			<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Country</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="country" placeholder="Country of made" class="form-control" />	
						</div>
				</div>
				<!--end country of made-->

				<!--sart staus-->
			<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Status</label>
						<div class="col-sm-10  col-md-6">
							<select name="select-stat" class="status">
								<option value="0">...</option>
								<option value="1">New</option>
								<option value="2">Like of New</option>
								<option value="3">Old</option>
								
							</select>	
						</div>
				</div>
			<!--end staus-->

			<!--sart Members-->
			<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Members</label>
						<div class="col-sm-10  col-md-6">
							<select name="members" class="status">
								<option value="0">...</option>
								<?php

									$allusers = getall ("*", "users", "where GroupID != 1" , "", "UserID"); 

									foreach($allusers as $user) {

										echo "<option value=' " . $user['UserID']. "'>" . $user['Username'] . "</option>";
									}
 
								?>		
								
							</select>	
						</div>
				</div>

			<!--end members-->


			<!--sart Categories-->
			<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Categories</label>
						<div class="col-sm-10  col-md-6">
							<select name="cats" class="status">
								<option value="0">...</option>
								<?php
									$allcats = getall ("*", "categories", "where parent = 0" , "", "ID"); // main cats
									foreach($allcats as $cat) {

										echo "<option value=' " . $cat['ID'] . "'>" . "[ " . $cat['Name'] . " ]" . "</option>";

										$childs = getall ("*", "categories", "where parent = {$cat['ID']}" , "", "ID"); // sub cats
										foreach($childs as $child) {

											echo "<option value=' " . $child['ID'] . "'>" . "--" . $child['Name'] .  "</option>";

										}
									}
 
								?>		
								
							</select>	
						</div>
				</div>

			<!--end members-->


				<!--sart item user-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Image Item</label>
						<div class="col-sm-10 col-md-6">
						<input type="file" name="avatar" class="form-control">	
						</div>
				</div>
				<!--end item user-->

			<!--sart tags-->
			<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Tags</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="tags" data-role="tagsinput" placeholder="Seprator Words As (,)" class="form-control tags" />	
						</div>
				</div>
				<!--end tags



			<!--sart submit-->
				<div class="form-group form-group-lg">
							<div class=" col-sm-offset-3 col-sm9 ">
								<i class='fa fa-plus icon-add-item'></i>
							     <input type="submit" value="Add Item" class="btn btn-primary btn-lg">
							   
							</div>
						</div>
			
				<!--end submit-->
					
				</form>

			</div>


		<?php  }elseif($do == 'insert') {


				if($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insert Item</h1>";

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

				$name  = $_POST['name'];
				$desc  = $_POST['descption'];
				$price = $_POST['price'];
				$country  = $_POST['country'];
				$select  = $_POST['select-stat'];
				$members  = $_POST['members'];
				$cats  = $_POST['cats'];
				$tags  = $_POST['tags'];


	
				// validate form 

				$formerrors = array();

				if(empty($name)) {

					$formerrors[] = ' You Can\'t be Name<storng> Empty </storng>';
				}

				if(empty($desc)) {

					$formerrors[] = 'You Can\'t be Description <storng>Empty</storng>';
				}

				if(empty($price)) {

					$formerrors[] = 'You can\'t be Price <storng>Empty</storng>';
				}

			    if(empty($country)) {

					$formerrors[] = 'You can\'t be Country <storng>Empty</storng>';
				}

				if(empty($select)) {

					$formerrors[] = 'You cant be Select<storng>Empty</storng>';
				}
				// valid upload image

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


								// insert un the database with info
								$stmt = $con->prepare('INSERT INTO items (Name, Description, Price, Country_made, Status, Add_date, 
									Member_id, Cat_id,  tags, avatar) VALUES (:name, :des, :price, :con, :stat, now(), :member, :cat, :tags, :avatar)');
								$stmt->execute(array(

									'name'   => $name,
									'des'    => $desc,
									'price'  => $price,
									'con'    => $country,
									'stat'   => $select,
									'member' => $members,
									'cat'    => $cats,
									'tags'   => $tags,
									'avatar' => $avatar


									));

							

							//echo sucsees message
							$themsg =  "<div class='alert alert-success text-center'>" . $stmt->rowcount() . ' Record Inserted sucssfuly </div>';

							redirecthome ($themsg, 'back');
	
				}

				

			
			} else { // if you dont coming throgh post request

				echo "<div class='container text-center'>";

					$themsg =  '<div class="alert alert-danger">Sorry you cant Redirect  this page</div>';

					redirecthome($themsg, 'back');

				echo "</div>";
			}

			echo "</div>";


		}

		  elseif($do == 'edit') { 

		  		// check if request get is numeric value 

			     $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0;  //if condition 

			     // seleect on data depend on itemid request

				$stmt = $con->prepare("SELECT * from items WHERE Item_id = ?");

				//execute this query on this check => $userid

		    	$stmt->execute(array($itemid));

		    	//fetch the data

		        $items = $stmt->fetch(); //to get data from database on array

		    	$count = $stmt->rowcount();

		    	 //if there is data with this id show the form 
 	
		    	if($count > 0) { ?>


		    <h1 class="text-center">Edit Item</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=update" method="POST">
				<input type="hidden" name="itemid" value="<?php echo $itemid; ?>"> 
				<!--sart name-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Name</label>
						<div class="col-sm-10 col-md-6">
						  <input type="text" name="name" class="form-control" placeholder="write the Name of Item"
						  value="<?php echo  $items['Name']?>" />	
						</div>
				</div>
				<!--end name-->

					<!--sart Description-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Description</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="descption" class="form-control" placeholder="Type your Description" 
						 value="<?php echo $items['Description']?>" />
						
						</div>
				</div>
				<!--end Description-->

					<!--sart price-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Price</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="price" placeholder="Type your Price" class="form-control"
						 value="<?php echo $items['Price']?>" />	
						</div>
				</div>
				<!--end price-->

					<!--sart country of made-->
			<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Country</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="country" placeholder="Country of made" class="form-control" 
						 value="<?php echo $items['Country_made']?>" />	
						</div>
				</div>
				<!--end country of made-->

				<!--sart staus-->
			<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Status</label>
						<div class="col-sm-10  col-md-6">
							<select name="select-stat" class="status">
								<option value="1" <?php if($items['Status'] == 1){echo "selected";}?>>New</option>
								<option value="2"<?php if($items['Status'] == 2){echo "selected";}?>>Like of New</option>
								<option value="3" <?php if($items['Status'] == 3){echo "selected";}?>>Old</option>
								
							</select>	
						</div>
				</div>
			<!--end staus-->

			<!--sart Members-->
			<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Members</label>
						<div class="col-sm-10  col-md-6">
							<select name="members" class="status">
								<?php

									$stmt = $con->prepare("SELECT * FROM users");
									$stmt->execute();
									$users = $stmt->fetchall();

									foreach($users as $user) {

										echo "<option value=' " . $user['UserID']. "'"; 
										if($items['Member_id'] == $user['UserID']){echo 'selected';}
										 echo ">" . $user['Username'] . "</option>";


									}
 
								?>		
								
							</select>	
						</div>
				</div>

			<!--end members-->


			<!--sart Categories-->
			<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Categories</label>
						<div class="col-sm-10  col-md-6">
							<select name="cats" class="status">
								<option value="0">...</option>
								<?php

									$stmt = $con->prepare("SELECT * FROM categories");
									$stmt->execute();
									$cats = $stmt->fetchall();

									foreach($cats as $cat) {

										echo "<option value=' " . $cat['ID']. "'";
										if($items['Cat_id'] == $cat['ID']) {echo 'selected';}
										echo ">" . $cat['Name'] . "</option>";
									}
 
								?>		
								
							</select>	
						</div>
				</div>

			<!--end members-->

			<!--sart tags-->
			<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Tags</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="tags" placeholder="Seprator Words As (,)" value="<?php echo $items['tags'];?>" class="form-control" />	
						</div>
				</div>
				<!--end tags



			<!--sart submit-->
				<div class="form-group form-group-lg">
							<div class=" col-sm-offset-3 col-sm9 ">
								<i class='fa fa-plus icon-add-item'></i>
							     <input type="submit" value="save Item" class="btn btn-primary btn-lg">
							   
							</div>
						</div>
			
				<!--end submit-->
					
				</form> 
				<?php 

			// select all records except admin

			$stmt = $con->prepare("SELECT 
				                      comments.*,  
				                        users.Username AS username 
				                          FROM 
				                          comments 
			                               INNER JOIN 
			                                 users 
			                                   ON 
			                                   users.UserID = comments.user_id
			                                   WHERE item_id = ?

			                                   ");

			$stmt->execute(array($itemid));

			$rows = $stmt->fetchall();

			if(! empty($rows)) {

					?> 

					<h1 class="text-center">manage[ <?php echo  $items['Name']?> ] comments</h1>

					<div class="container">
							<div class="table-reponsive">
								<table class="table text-center table table-bordered">
									<tr>
										
										<td>Comment</td>
										<td>Date</td>
										<td>User</td>
										<td>Control</td>

									</tr>

							
										
										<?php

											foreach($rows as $row) {

												echo "<tr>";
													
													echo "<td>" . $row['comment'] .  "</td>";
													echo "<td>" . $row['comment_date'] .  "</td>";
													echo "<td>" . $row['username'] . "</td>"; // from as .... query
													echo "<td>

													<a href='comments.php?do=edit&commid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
													<a href='comments.php?do=delete&commid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

													if($row['status'] == 0) { // the user not activate

													 echo "<a href='comments.php?do=approve&commid=" . $row['c_id'] . "' class='btn btn-info act'><i class='fa fa-plus-circle'></i>Activate</a>";

													}


													 echo "</td>";


												echo "</tr>";

											}


										?>
						         </table>
							</div>

						<?php } ?>
				
				     </div>

			</div>



		  	<?php }

 }

		  elseif($do == 'update') { //update page

		  	echo "<h1 class='text-center'>Update Items</h1>";

			echo "<div class='container'>";

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

			    echo "<div class='container'>";
			    $id       = $_POST['itemid'];
				$name     = $_POST['name'];
				$desc     = $_POST['descption'];
				$price    = $_POST['price'];
				$country  = $_POST['country'];
				$select   = $_POST['select-stat'];
				$members  = $_POST['members'];
				$cats     = $_POST['cats'];
				$tags     = $_POST['tags'];
	
				// validate form 

				$formerrors = array();

				if(empty($name)) {

					$formerrors[] = ' You Can\'t be Name<storng> Empty </storng>';
				}

				if(empty($desc)) {

					$formerrors[] = 'You Can\'t be Description <storng>Empty</storng>';
				}

				if(empty($price)) {

					$formerrors[] = 'You can\'t be Price <storng>Empty</storng>';
				}

			    if(empty($country)) {

					$formerrors[] = 'You can\'t be Country <storng>Empty</storng>';
				}

				if(empty($select)) {

					$formerrors[] = 'You cant be Select<storng>Empty</storng>';
				}

				foreach ($formerrors as $errors) {

					echo '<div class="alert alert-danger">' . $errors . '</div>';
				}

				if(empty($formerrors)) { // NO error



					// upadate the database with info

				$stmt = $con->prepare(" UPDATE items SET Name = ?, Description = ?, Price = ?, Country_made = ?, Status = ?,
				 Member_id = ?, Cat_id = ?, tags = ?  WHERE Item_id = ? ");
				$stmt->execute(array($name, $desc, $price, $country, $select, $members, $cats, $tags,  $id));

				//echo sucsees message
				$themsg = "<div class='alert alert-success'>" . $stmt->rowcount() . ' Record Updated sucssfuly </div>';

				redirecthome($themsg, 'back');

				}

				echo "</div>";

			
			} else {

				$themsg = '<div class="alert alert-danger text-center">Sorry you cant update this page</div>';

				redirecthome($themsg);
			}

              }elseif($do == 'delete') { // delete page

					// check if request get is numeric value 

			     $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0;  //if condition 

		    	 //check if the user exist in database 

		    	 $check = checkitem ('Item_id', 'items', $itemid);
 	
		    	if($check > 0) { 

		    		$stmt = $con->prepare('DELETE FROM items WHERE Item_id = :zid');
		    		$stmt->bindparam(':zid', $itemid); // connect with $user
		    		$stmt->execute();

		    		$themsg =  "<div class='alert alert-success text-center'  style='margin-top:30px;'>" . $stmt->rowcount() . ' Record Delete sucssfuly </div>';

		    		redirecthome($themsg, 'back');


		    	} else {

		    		$themsg =  '<div class="alert alert-danger text-center"  style="margin-top:30px;">No Userid in the Database</div>';

		    		redirecthome($themsg);
		    	}


		}


		  	
		  elseif($do == 'approve') {


		  		echo "<h1 class='text-center'>Approve Items</h1>";
		  		echo "<div class='continer'>";
		  		 // check if request get is numeric value 

			     $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0;  //if condition 


		    	 //check if the user exist in database 

		    	 $check = checkitem ('Item_id', 'items', $itemid);
 	
		    	if($check > 0) { 

		    		$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_id = ?");

		    		$stmt->execute(array($itemid));

		    		$themsg =  "<div class='alert alert-success text-center'  style='margin-top:30px;'>" . $stmt->rowcount() . ' Record Activate sucessfuly </div>';

		    		redirecthome($themsg,'back');


		    	} else {

		    		$themsg =  '<div class="alert alert-danger text-center"  style="margin-top:30px;">No Items in the Database</div>';

		    		redirecthome($themsg);
		    	}

		    	echo "</div>";




		  }		

		  include  $tmp1 . "footer.php";


		}else{

			header('location:index.php');
		}

		ob_end_flush();

		?>
