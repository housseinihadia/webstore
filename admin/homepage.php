<?php 

	ob_start(); // output buffring start => to solve the prblems of hraders sent 

	session_start();

	$titlepage = 'Homepage';

	if(isset($_SESSION['username'])) {

		include 'init.php';
		

		/*Start home page*/



		?>

		<div class="container home-stats text-center">

		<h1 class="text-center">Home Page</h1>
		  <div class="row">
				<div class="col-md-3">
					<div class="stats st-members">

								<i class='fa fa-users'></i>
								<div class="info">
									
									Total members
								    <span><a href="members.php"><?php echo countItems('UserID', 'users')?></a> </span>

								</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="stats st-panding">
					<i class="fa fa-user-plus"></i>
					<div class="info">
					Pandings members
					<span><a href="members.php?do=mange&page=pending"><?php echo checkitem ("RegStatus", "users", 0) ?></a></span>

					</div>


					</div>
				</div>

				<div class="col-md-3">
					<div class="stats st-items">
					<i class="fa fa-tags"></i>
					<div class="info">

							Total Items
					       <span><a href="items.php"><?php echo countItems('Item_id', 'items')?></a></span>
						
					</div>
				

					</div>
				</div>
				<div class="col-md-3">
						<div class="stats st-comments">
						<i class="fa fa-comments"></i>
						<div class="info">
							
						Total Comments
						<span><a href="comments.php"><?php echo countItems('c_id', 'comments')?></a></span>

						</div>


						</div>
					</div>

			    </div>
		</div>

		<div class="container least">
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
					<?php 
					$num_users = 5; //num of users

					$num_items = 5 //num of users




					



					?> 
						<div class="panel-heading">
						<i class="fa fa-users"></i> Latest <?php echo $num_users; ?> users
						<span class="toggle pull-right">
							<i class="fa fa-plus fa-lg"></i>
						</span>
						</div>
						<div class="panel-body">
						<ul class="list-unstyled lastusers">
									<?php

									$least_users = getleast ("*", "users", "UserID", $num_users); // is function to get the least users
									if(! empty($least_users)) {
									foreach($least_users as $users) {

										echo "<li>"; 
											echo  $users["Username"];

											echo '<a href="members.php?do=edit&userid= ' . $users['UserID'] . '">';

												 echo "<span class='btn btn-success pull-right'>";
												     echo " <i class='fa fa-edit'></i>Edit";

										if($users['RegStatus'] == 0) { // the user not activate

										 echo "<a href='members.php?do=activate&userid=" . $users['UserID'] . "' class='btn btn-info pull-right act'><i class='fa fa-plus-circle'></i>Activate</a>";

										}
												 echo "</span>";
											 echo "</a>";
										echo "</li>";
									}
								}else {

									echo 'No users in Row';
								}

									?>
							</ul>


						</div>
				      </div>
			    </div>

			    					<div class="col-sm-6">
							<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-tags"></i> Latest <?php echo $num_items ?> Items
										 <span class="toggle pull-right">
											<i class="fa fa-plus fa-lg"></i>
										</span>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled lastusers">
											<?php

											$least_items = getleast ("*", "items", "Item_id", $num_items); // is function to get the least items
											if(! empty($least_items)) {
											foreach($least_items as $items) {

												echo "<li>"; 
													echo  $items["Name"];

													echo '<a href="items.php?do=edit&itemid= ' . $items['Item_id'] . '">';
													
														 echo "<span class='btn btn-success pull-right'>";
														     echo " <i class='fa fa-edit'></i>Edit";

												if($items['Approve'] == 0) { // the user not activate

												 echo "<a href='items.php?do=approve&itemid=" . $items['Item_id'] . "' class='btn btn-info pull-right act'><i class='fa fa-plus-check'></i>Approve</a>";

												}
														 echo "</span>";
													 echo "</a>";
												echo "</li>";
											}
										} else {

											echo "No Records in Row";
										}

											?>
									</ul>
					          </div>
				        </div>
		</div>

			</div>


		<!-- start comments -->

				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
						<?php 
						$num_comm = 5; //num of users

						?> 
							<div class="panel-heading">
							<i class="fa fa-comments"></i> Latest <?php echo $num_comm; ?> comments
							<span class="toggle pull-right">
								<i class="fa fa-plus fa-lg"></i>
							</span>
							</div>
							<div class="panel-body">
							   <ul class="list-unstyled lastcomm">

							<?php 

									$stmt = $con->prepare("SELECT 
				                      comments.*,  
				                        users.Username AS member 
				                          FROM 
				                          comments 
			                               INNER JOIN 
			                                 users 
			                                   ON 
			                                   users.UserID = comments.user_id

			                                   ORDER BY c_id DESC

			                                   LIMIT $num_comm			                            
			                                   ");

							$stmt->execute();

							$comments = $stmt->fetchall();

							if(!empty($comments)) {

								foreach($comments as $comm) {

									echo "<div class='comm-box' >";

										echo '<span class="member-n">' . $comm['member'] .  '</span>';
										echo '<span class="member-c">' . $comm['comment'] .  '</span>';

									echo "</div>";
								}
							}else {

								echo "No Record here";
							}



							?>

								</ul>
							</div>
					      </div>
				    </div>
				    </div>
			</div>



		<!-- start comments -->


		<?php
		/*end home page*/

		include $tmp1 . "footer.php";

	} else {

		header('location: index.php');

		exit();
	}
	
	ob_end_flush();

	?>