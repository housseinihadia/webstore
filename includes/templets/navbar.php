<div class="uppe-bar">

  <div class="container">
  <?php 

  if(isset($_SESSION['user'])) { ?>
  
    <img class="my-iamge img-responsive img-thumbnail img-circle" src='User-Default.JPG' />
  <div class="btn-group">
    <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <?php echo $sessionuser; ?>
    <span class="caret"></span>
    </span>
      <ul class="dropdown-menu">
        <li><a href="profile.php">My profile</a></li>
        <li><a href="ads.php">add ads</a></li>
        <li><a href="logout.php">Log out</a></li>
      </ul>

  </div>


 
  <?php 
  }else {  ?>

             <a href="login.php">
                <span class="pull-right"> Signup | Login </span>
  

     <?php } ?>
    </div>

</div>

<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>

   
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">


      <?php

      $allcats = getall ("*", "categories", "WHERE parent = 0", "", "ID"); // this function can show all records from any table in data base 

        
        foreach($allcats as $cat) { // this movement between all cats through Get request 

            echo '<li>
            <a href="categories.php?catid=' . $cat['ID'] .'&catname=' . str_replace('','-', $cat['Name']). '">' . $cat['Name'].   '</a>
            </li>';


        } 


      ?>
    
       </ul>
    

    </div>
</nav>