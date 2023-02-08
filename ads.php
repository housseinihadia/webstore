<?php 
    ob_start();
    session_start();
    
    $titlepage = 'New Ads';
   
    include 'init.php';

    if(isset($_SESSION['user'])) { 


        if($_SERVER['REQUEST_METHOD'] == 'POST') {


                // Upload Files Variables

               $file_name = $_FILES['avatar']['name']; //file name
               $file_type = $_FILES['avatar']['type']; //file type
               $file_temp = $_FILES['avatar']['tmp_name']; //path file
               $file_size = $_FILES['avatar']['size'];    // file size

               // list of permosion to Upload file
               $file_allow_extention = array("jpg", "png", "gif");

               //get file
               @$filt_extintion = strtolower(end(explode(".", $file_name)));

            $formerrors = array();

            $name    = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $desc    = filter_var($_POST['descption'], FILTER_SANITIZE_STRING);
            $price   = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
            $status  = filter_var($_POST['select-stat'], FILTER_SANITIZE_NUMBER_INT);
            $cats    = filter_var($_POST['cats'], FILTER_SANITIZE_NUMBER_INT);
            $tags    = filter_var($_POST['tags'], FILTER_SANITIZE_STRING); 

            // start validate form
            if(strlen($name) < 4) {

                $formerrors[] = 'You Must Be Less Than 4 Chars';
            }

             if(strlen($desc) < 10) {

                $formerrors[] = 'You Must Be Less Than 10 Chars';
            }

            if(strlen($country) < 2) {

                $formerrors[] = 'You Must Be Less country Than 2 Chars';
            }

            if(empty($price)) {

                $formerrors[] = 'You Must Be price  Not Empty';
            }

            if(empty($status)) {

                $formerrors[] = 'You Must Be status  Not Empty';
            }

            if(empty($cats)) {

                $formerrors[] = 'You Must Be cats Not Empty';
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


            if(empty($formerrors)) { // there is no errors

                    $avatar = rand(0, 1000000) . '_' . $file_name;

                    move_uploaded_file($file_temp, "uploads\avatars\\" . $avatar); 

                $stmt1 = $con->prepare("INSERT INTO items (Name, Description, Price, Add_date, Country_made, Status, Cat_id, 
                    tags, avatar, Member_id) VALUES (:zname, :zdesc, :zprice, now(), :zcon, :zstat, :zcatid, :ztags, :avatar, :zmemid)");

                $stmt1->execute(array(

                    'zname'   => $name,
                    'zdesc'   => $desc,
                    'zprice'  => $price,
                    'zcon'    => $country,
                    'zstat'   => $status,
                    'zcatid'  => $cats,
                    'ztags'   => $tags,
                    'avatar'  => $avatar,
                    'zmemid'  => $_SESSION['userid']


                    ));

               // sucsess msg
                if($stmt1) {

                    $sucsess_msg =  "<div class='alert alert-success'>You Added An Item </div>";
                }

        }

        }


    	?>


    <h1 class="text-center"><?php echo $titlepage; ?></h1>
    <div class="adsblock">
    	<div class="container">
    		<div class="panel panel-primary">
    			<div class="panel-heading">My information</div>
    			<div class=" panel-body">
                    <div class="row">
                        <div class="col-md-8">
                                    <form class="form-horizontal" action="?<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <!--sart name-->
                            <div class="form-group form-group-lg">
                                    <label class="col-sm-2 label-control ">Name</label>
                                    <div class="col-sm-10 col-md-9">
                                      <input type="text" name="name" class="form-control user-live" placeholder="write the Name of Item"  title="Must be 4 chars at Least " required=""/>    
                                    </div>
                            </div>
                            <!--end name-->

                                <!--sart Description-->
                            <div class="form-group form-group-lg">
                                    <label class="col-sm-2 label-control">Description</label>
                                    <div class="col-sm-10  col-md-9">
                                    <input type="text" name="descption" class="form-control desc" placeholder="Type your Description"   title="Must be 10 chars at Least " required=""/>
                                    
                                    </div>
                            </div>
                            <!--end Description-->

                                <!--sart price-->
                            <div class="form-group form-group-lg">
                                    <label class="col-sm-2 label-control">Price</label>
                                    <div class="col-sm-10  col-md-9">
                                    <input type="text" name="price" placeholder="Type your Price" class="form-control price-live" required="" />    
                                    </div>
                            </div>
                            <!--end price-->

                                <!--sart country of made-->
                        <div class="form-group form-group-lg">
                                    <label class="col-sm-2 label-control">Country</label>
                                    <div class="col-sm-10  col-md-9">
                                    <input type="text" name="country" placeholder="Country of made" class="form-control" /> 
                                    </div>
                            </div>
                            <!--end country of made-->

                            <!--sart staus-->
                        <div class="form-group form-group-lg">
                                    <label class="col-sm-2 label-control">Status</label>
                                    <div class="col-sm-10  col-md-9">
                                        <select name="select-stat" class="status">
                                            <option value="0">...</option>
                                            <option value="1">New</option>
                                            <option value="2">Like of New</option>
                                            <option value="3">Old</option>
                                            
                                        </select>   
                                    </div>
                            </div>
                        <!--end staus-->



                        <!--sart Categories-->
                        <div class="form-group form-group-lg">
                                    <label class="col-sm-2 label-control">Categories</label>
                                    <div class="col-sm-10  col-md-9">
                                        <select name="cats" class="status">
                                            <option value="0">...</option>
                                            <?php

                                                $cats = getall('*', 'categories', 'where parent = 0', '', 'ID');

                                                foreach($cats as $cat) {

                                                    echo "<option value=' " . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
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
                        <div class="col-sm-10  col-md-9">
                        <input type="text" name="tags" data-role="tagsinput" placeholder="Seprator Words As (,)" class="form-control tags" />   
                        </div>
                </div>
                <!--end tags



                        <!--sart submit-->
                            <div class="form-group form-group-lg">
                                        <div class=" col-sm-offset-3 col-sm9 ">
                                             <input type="submit" value="Add Item" class="btn btn-primary btn-lg">
                                           
                                        </div>
                                    </div>
                        
                            <!--end submit-->
                                
                            </form>
                            <!-- start print errors -->
                            <?php 

                            if(!empty($formerrors)) {

                                foreach($formerrors as $error) {

                                    echo '<div class="alert alert-danger">' . $error . '</div>';
                                }

                            } else {
                                if(isset($sucsess_msg)) {
                                    echo $sucsess_msg;
                                } 
                            }


                            ?>
                            <!-- end print errors -->

                            <!-- start success meassge -->


                            <!-- start success meassge -->
                            
                        </div>

                        <div class="col-md-4">

                             <div class='thumbnail item-box live-preview'>
                                <span class="price">Price</span>
                                <img class="imge-responsive" src='User-Default.JPG' />
                                  <div class="caption">
                                        <h3>Name</h3>
                                        <p>Description</p>
                                  </div>

                        </div>

                        </div>
                    </div>

    			</div>
    		</div>
    	</div>
    </div>


<?php } else { // if not sign in session 

	header('location:login.php');
	exit();
}

  include  $tmp1 . "footer.php"; 

  ob_end_flush();


 ?>