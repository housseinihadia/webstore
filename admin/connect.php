<?php 

$dsn = 'mysql:host=localhost;dbname=shops';
$user = 'root';
$pass = '';
$option = array(

PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

);

try { // if connect

	$con = new PDO($dsn, $user, $pass, $option);

	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to tell me error

	//echo " You are connected welcom to database";
}

catch(PDOException $e) { // if not connection 

	echo "Failed connect  " . $e->getMessage();
}

/*

           <h1 class="text-center">Edit Category</h1>
			<div class="container" >	
				<form class="form-horizontal" action="?do=update" method="POST">
				<input type="hidden" name="catid" value="<?php echo $catid; ?>"> <!--transfer the data to update page by using hidden input-->
				<!--sart name-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Name</label>
						<div class="col-sm-10 col-md-6">
						<input type="text" name="name" class="form-control" placeholder="write the Name of category"
						 value="<?php echo $cat['Name']?>" />	
						</div>
				</div>
				<!--end name-->

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
								<input id="comm-yes" type="radio" name="comments" value="0" <?php if($cat['Allow_comm'] ==0){echo 'checked';}?>/>
								<label for="comm-yes">Yes</label>

							</div>

							   <div>
								<input id="comm-no" type="radio" name="comments" value="1" <?php if($cat['Allow_comm'] ==1){echo 'checked';}?> />
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
								<input id="adv-yes" type="radio" name="Advertise" value="0" <?php if($cat['Allow_adver'] ==0){echo 'checked';}?>>
								<label for="adv-yes">Yes</label>

							</div>

							   <div>
								<input id="adv-no" type="radio" name="Advertise" value="1" <?php if($cat['Allow_adver'] ==1){echo 'checked';}?>>
								<label for="adv-no">No</label>

							</div>	
						</div>
				</div>
				<!--end advertise feild-->

					<!--sart submit-->
				<div class="form-group form-group-lg">
							<div class=" col-sm-offset-3 col-sm9 ">
							     <input type="submit" value="Save Category" class="btn btn-primary ">
							</div>
						</div>
				</div>
				<!--end submit-->
		
				</form>

			</div>


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
elseif($do == 'edit') {

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
				<!--sart name-->
				<div class="form-group form-group-lg">
						<label class="col-sm-2 label-control">Name</label>
						<div class="col-sm-10 col-md-6">
						<input type="text" name="name" class="form-control" placeholder="write the Name of category"
						 value="<?php echo $cat['Name']?>" />	
						</div>
				</div>
				<!--end name-->

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
								<input id="comm-yes" type="radio" name="comments" value="0" <?php if($cat['Allow_comm'] ==0){echo 'checked';}?>/>
								<label for="comm-yes">Yes</label>

							</div>

							   <div>
								<input id="comm-no" type="radio" name="comments" value="1" <?php if($cat['Allow_comm'] ==1){echo 'checked';}?> />
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
								<input id="adv-yes" type="radio" name="Advertise" value="0" <?php if($cat['Allow_adver'] ==0){echo 'checked';}?>>
								<label for="adv-yes">Yes</label>

							</div>

							   <div>
								<input id="adv-no" type="radio" name="Advertise" value="1" <?php if($cat['Allow_adver'] ==1){echo 'checked';}?>>
								<label for="adv-no">No</label>

							</div>	
						</div>
				</div>
				<!--end visibility-->

					<!--sart submit-->
				<div class="form-group form-group-lg">
							<div class=" col-sm-offset-3 col-sm9 ">
							     <input type="submit" value="Save Category" class="btn btn-primary ">
							</div>
						</div>
				</div>
				<!--end submit-->
		
				</form>

			</div>


			////////////////////////////////////////////////////////////////////////////////////



					if($do == 'mange') {
			// ordering  the category by using ordrig coulm 
			$sort = 'ASC';

			$sort_arr = array('ASC', 'DESC');

			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_arr)) {

				$sort = $_GET['sort'];
			} 

		     $stmt = $con->prepare("SELECT * FROM categories Order by Ordring $sort");

			$stmt->execute();

			$rows = $stmt->fetchall(); ?>

			<h1 class="text-center">Mange Category</h1>
			<div class="container category">
				<div class="panel panel-default">
				<div class="panel-heading">Mange Category
					<div class='sort pull-right'>
						Ordering <a  class="<?php if($sort == 'ASC'){echo 'active';} ?>" href="?sort=ASC">Asc</a> |
						        <a class="<?php if($sort == 'DESC'){echo 'active';} ?>" href="?sort=DESC">Desc</a>
					</div>
				</div>
				<div class="panel-body">
					<?php

					foreach ($rows as $cat) {
						echo "<div class='cat'>";
							echo "<div class='hidden-buttons'>";
								echo "<a href='categories.php?do=edit&catid=" . $cat['ID']. "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
								echo "<a href='#' class='btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
							echo "</div>";
							echo "<h2>" . $cat['Name'] . "</h2>";
							echo  "<p>"; 
							   if($cat['Description'] == ''){echo "This Empty Description";} else{echo $cat['Description'];}
							 echo "</p>";

							if($cat['Visibility'] == 1) {echo "<span class='visb'>  Hidden</span>";} else{echo "<span class='enable'>Enable</span>";}
							 //its maen no in form
							if($cat['Allow_comm'] == 1) {echo "<span class='comm'>Disabled Comment</span>";}else{echo "<span class='enable'>Enable</span>";}
							 //its maen no in form
							if($cat['Allow_adver'] == 1) {echo "<span class='advertise'> No advertise</span>";}else{echo "<span class='enable'>Enable</span>";} //its maen no in form

						echo "</div>";
						echo "<hr>";
					} 


					?>
				</div>
				</div>
				
			</div>

		<?php } 











*/