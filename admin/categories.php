<?php 

/*
=======================
=== mange categories  page
=== you can add/ edit/ delete
===================================
*/	ob_start();

	session_start();

	$titlepage = 'Categories Page';


	if(isset($_SESSION['username'])) {


		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'mange'; //if condtion 

		if($do == 'mange') {

			// ordering  the category by using ordrig coulm 
			$sort = 'ASC';

			$sort_arr = array('ASC', 'DESC');

			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_arr)) {

				$sort = $_GET['sort'];
			} 

		     $stmt = $con->prepare("SELECT * FROM categories WHERE parent = 0 Order by Ordring $sort");

			$stmt->execute();

			$rows = $stmt->fetchall(); ?>

			<h1 class="text-center">Mange Category</h1>
			<div class="container category">
				<div class="panel panel-default">
				<div class="panel-heading">Mange Category
					<div class='option pull-right'>
						[ Ordering : <a  class="<?php if($sort == 'ASC'){echo 'active';} ?>" href="?sort=ASC">Asc</a> |
						        <a class="<?php if($sort == 'DESC'){echo 'active';} ?>" href="?sort=DESC">Desc</a> ]
						[ View : <span class="active" data-view="full">Full</span> |
						 	<span data-view="classic">Classic</span>   ]    
					</div>
				</div>
				<div class="panel-body">
					<?php

					foreach ($rows as $cat) {
						echo "<div class='cat'>";
							echo "<div class='hidden-buttons'>";
									echo "<a href='categories.php?do=edit&catid=" . $cat['ID']. "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
									echo "<a  href='categories.php?do=delete&catid=" . $cat['ID'] . "' class='btn btn-xs btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
							echo "</div>";
							echo "<h2>" . $cat['Name'] . "</h2>";
							echo "<div class='full-view'>";
										echo  "<p>"; 
										   if($cat['Description'] == ''){echo "This Empty Description";} else{echo $cat['Description'];}
										 echo "</p>";

										if($cat['Visibility'] == 1) {echo "<span class='visb'> <i class='fa fa-eye'></i>Hidden</span>";} else{echo "<span class='enable'> <i class='fa fa-plus'></i>Enable</span>";}
										 //its maen no in form
										if($cat['Allow_comm'] == 1) {echo "<span class='comm'> <i class='fa fa-lock'></i>Disabled Comment</span>";}else{echo "<span class='enable'> <i class='fa fa-plus'></i>Enable</span>";}
										 //its maen no in form
										if($cat['Allow_adver'] == 1) {echo "<span class='advertise'>  <i class='fa fa-lock'></i>Disabled advertise</span>";}else{echo "<span class='enable'> <i class='fa fa-plus'></i>Enable</span>";} //its maen no in form

									echo "</div>";

						   echo "</div>";

						 // Get child Gategory
						$childcats = getall ("*", "categories", "WHERE parent = {$cat['ID']}", "", "ID", "ASC");
						if(!empty($childcats)) {
							echo "<h4 class='heading-child'>child-category  <i class='fa fa-arrow-right' aria-hidden='true'></i> 
							</h4>";	
							foreach($childcats as $c) {
								echo "<ul class='list-unstyled child-cats'>";
								   echo "<li class='child-link'>
								         <a href='categories.php?do=edit&catid=" . $c['ID'] . "' >". $c['Name'] . "</a>
								         <a  href='categories.php?do=delete&catid=" . $c['ID'] . "' class='show-delete confirm'>Delete</a>

								   </li>";

								echo "</ul>";
							}
					} 
						echo "<hr>";

					  }	
					?>

				  </div>
				</div>

				<a href='?do=add' class="add-cat btn btn-primary"><i class="fa fa-plus"></i>Add New Category</a>
				
			</div>


		<?php 
	} 
		elseif($do == 'add') { ?>

			<h1 class="text-center">Add New Category</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=insert" method="POST">
				<!--sart name-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Name</label>
						<div class="col-sm-10 col-md-6">
						<input type="text" name="name" class="form-control" placeholder="write the Name of category" autocomplete="off" required='required'/>	
						</div>
				</div>
				<!--end name-->

					<!--sart Description-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Description</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="descption" class="form-control" placeholder="Type your Description">
						
						</div>
				</div>
				<!--end Description-->

					<!--sart Ordring-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Ordring</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="ordering" placeholder="Type your Ordering" class="form-control" >	
						</div>
				</div>
				<!--end Ordring-->


				<!--sart parent category -->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Parent?</label>
						<div class="col-sm-10  col-md-6">
						<select name="parent">
						<option value="0">None</option>
						<?php 

                         $allcats = getall ("*", "categories", "WHERE parent = 0", " ", "ID", "ASC");
                         foreach($allcats as $cate) {

                         	echo "<option value='" . $cate['ID'] . "'>" . $cate['Name'] .  "</option>";
                         }

						?>
						</select>
						</div>
				</div>
				<!--end parent category-->

					<!--sart visibility-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Visibility</label>
						<div class="col-sm-10  col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="vis" value="0" checked>
								<label for="vis-yes">Yes</label>

							</div>

							   <div>
								<input id="vis-no" type="radio" name="vis" value="1" >
								<label for="vis-no">No</label>

							</div>	
						</div>
				</div>
				<!--end visibility-->

				<!--sart comment feild-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Allow Comments</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="comm-yes" type="radio" name="comments" value="0" checked>
								<label for="comm-yes">Yes</label>

							</div>

							   <div>
								<input id="comm-no" type="radio" name="comments" value="1" >
								<label for="comm-no">No</label>

							</div>	
						</div>
				</div>
				<!--end visibility-->

				<!--sart advertise feild-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Allow Advertise</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="adv-yes" type="radio" name="Advertise" value="0" checked>
								<label for="adv-yes">Yes</label>

							</div>

							   <div>
								<input id="adv-no" type="radio" name="Advertise" value="1" >
								<label for="adv-no">No</label>

							</div>	
						</div>
				</div>
				<!--end visibility-->

					<!--sart submit-->
				<div class="form-group form-group-lg">
							<div class=" col-sm-offset-3 col-sm9 ">
							     <input type="submit" value="Add Category" class="btn btn-primary ">
							</div>
						</div>
				</div>
				<!--end submit-->
		</form>


			</div>


		<?php }

		 elseif($do == 'insert') {

		 			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Inserted member</h1>";

			    echo "<div class='container'>";

				$name  = $_POST['name'];
				$desc  = $_POST['descption'];
				$order = $_POST['ordering'];
				$parent = $_POST['parent'];
				$vis   = $_POST['vis'];
				$comm  = $_POST['comments'];
				$adv   = $_POST['Advertise'];

					// use the function is check the if name of category has this name exist in database or not 

					$check = checkitem ('Name', 'categories', $name);

					if($check == 1) { // exist username in with the same name

						$themsg = '<div class="alert alert-danger text-center">Sorry this Name exist </div>';

						redirecthome ($themsg, 'back', 5);

					} else {


								// insert categories in  the database with info
								$stmt = $con->prepare('INSERT INTO categories (Name, Description, Ordring, parent, Visibility, Allow_comm, Allow_adver) VALUES (:name, :des, :order, :par,  :vis, :comm, :adv)');
								$stmt->execute(array(

									'name'  => $name,
									'des'   => $desc,
									'order' => $order,
									'par' => $parent,
							     	'vis'   => $vis,
									'comm'  => $comm,
									'adv'   => $adv
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
		} elseif($do == 'edit') {

				// check if request get is numeric value 

			     $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :0;  //if condition 

			     // seleect on data depend on userid request

				$stmt = $con->prepare('SELECT * from categories WHERE ID = ? ');

				//execute this query on this check => $userid

		    	$stmt->execute(array($catid));

		    	//fetch the data

		        $cat = $stmt->fetch(); //to get data from database on array

		    	$count = $stmt->rowcount();

		    	 //if there is data with this id show the form 
 	
		    	if($count > 0) { ?> 



             <h1 class="text-center">Edit Category</h1>

			<div class="container" >	
				<form class="form-horizontal" action="?do=update" method="POST">
				<input type="hidden" name="catid" value="<?php echo $catid; ?>"> <!--transfer the data to update page by using hidden input-->
				<!--sart username-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Name</label>
						<div class="col-sm-10 col-md-6">
						<input type="text" name="name" class="form-control" placeholder="write the Name of category"
						 value="<?php echo $cat['Name']?>"/>	
						</div>
				</div>
				<!--end username-->

					<!--sart Description-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Description</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="descption" class="form-control" placeholder="Type your Description"
						value="<?php echo $cat['Description']?>" />
						
						</div>
				</div>
				<!--end Description-->

					<!--sart Ordring-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Ordring</label>
						<div class="col-sm-10  col-md-6">
						<input type="text" name="ordering" placeholder="Type your Ordering" class="form-control"
						value="<?php echo $cat['Ordring']?>" />	
						</div>
				</div>
				<!--end Ordring-->

				<!--sart parent category -->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Parent? </label>
						<div class="col-sm-10  col-md-6">
						<select name="parent">
						<option value="0">None</option>
						<?php 

                         $sub_cats = getall ("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
                         foreach($sub_cats as $c) {

                         	echo "<option value='" . $c['ID'] . "'";

                         	if($cat['parent'] == $c['ID']) {echo  'selected';}
                         	

                         	echo ">" . $c['Name'] .  "</option>";

                         	 
                         }

						?>

						</select>

						</div>
				</div>
				<!--end parent category-->

					<!--sart visibility-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Visibility</label>
						<div class="col-sm-10  col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="vis" value="0" <?php if($cat['Visibility'] == 0){echo 'checked';}?> />
								<label for="vis-yes">Yes</label>

							</div>

							   <div>
								<input id="vis-no" type="radio" name="vis" value="1" <?php if($cat['Visibility'] == 1){echo 'checked';}?> />
								<label for="vis-no">No</label>

							</div>	
						</div>
				</div>
				<!--end visibility-->


				<!--sart comment feild-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Allow Comments</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="comm-yes" type="radio" name="comments" value="0" <?php if($cat['Allow_comm'] == 0){echo 'checked';}?>/>
								<label for="comm-yes">Yes</label>

							</div>

							   <div>
								<input id="comm-no" type="radio" name="comments" value="1" <?php if($cat['Allow_comm'] == 1){echo 'checked';}?> />
								<label for="comm-no">No</label>

							</div>	
						</div>
				</div>
				<!--end comment feild-->
				<!--start adv -->
				<div class="form-group form-group-lg">
                 <label class="col-sm-2 label-control">Allow Advertise</label>
                 		<div class="col-sm-10 col-md-6">
							<div>
								<input id="adv-yes" type="radio" name="Advertise" value="0" <?php if($cat['Allow_adver'] == 0){echo 'checked';}?>/>
								<label for="adv-yes">Yes</label>

							</div>


							   <div>
								<input id="adv-no" type="radio" name="Advertise" value="1" <?php if($cat['Allow_adver'] ==1){echo 'checked';}?>>
								<label for="adv-no">No</label>

							</div>	


						
				</div>					

				</div> 
				<!-- end adv -->
			

					<!--sart submit-->
				<div class="form-group">
							<div class=" col-sm-offset-3 col-sm-6 ">
							 <input type="submit" value="save" class="btn btn-primary ">
							</div>
						</div>

						<!--end submit-->

						</form>
				</div>
				
					
				

			

			 <?php } ?>

			 <?php }  elseif($do == 'update') {

			 	echo "<h1 class='text-center'>Update Category</h1>";
			 	echo "<div class='container'>";

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				$id    = $_POST['catid']; // hidden input his value = old id
				$name  = $_POST['name'];
				$desc  = $_POST['descption'];
				$order = $_POST['ordering'];
				$vis   = $_POST['vis'];
				$comm  = $_POST['comments'];
				$adv  = $_POST['Advertise'];

				// upadate the database with info

				$stmt = $con->prepare('UPDATE  categories SET Name = ?, Description = ?, Ordring = ?, Visibility = ?, Allow_comm = ?,
					Allow_adver = ?
				 WHERE ID = ? ');
				$stmt->execute(array($name, $desc, $order, $vis, $comm, $adv,  $id));

				//echo sucsees message
				$themsg = "<div class='alert alert-success'>" . $stmt->rowcount() . ' Record Updated sucssfuly </div>';

				redirecthome($themsg, 'back');

				echo "</div>";



			}else {

				$themsg = '<div class="alert alert-danger text-center">Sorry you cant update this page</div>';

				redirecthome($themsg);

			}





			 } elseif($do == 'delete') {

				// check if request get is numeric value 

			     $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :0;  //if condition 

		    	 //check if the user exist in database 

		    	 $check = checkitem ('ID', 'categories', $catid);
 	
		    	if($check > 0) { 

		    		$stmt = $con->prepare('DELETE FROM categories WHERE ID = :catid');
		    		$stmt->bindparam(':catid', $catid); // connect with $user
		    		$stmt->execute();

		    		$themsg =  "<div class='alert alert-success text-center'  style='margin-top:30px;'>" . $stmt->rowcount() . ' Record Delete sucssfuly </div>';

		    		redirecthome($themsg);


		    	} else {

		    		$themsg =  '<div class="alert alert-danger text-center"  style="margin-top:30px;">No Username in the Database</div>';

		    		redirecthome($themsg);
		    	}


			 }
		    	

			
		  include  $tmp1 . "footer.php";


		} else{

			header('location:index.php');
		}

		ob_end_flush();

		?>