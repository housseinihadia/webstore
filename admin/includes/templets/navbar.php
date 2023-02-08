

<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><?php echo langs('home-admin') ?></a>
    </div>

   
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?php echo langs('session') ?> </a></li>
        <li><a href='items.php'><?php echo langs('items') ?> </a></li>
        <li><a href="#"><?php echo langs('statics') ?> </a></li>
        <li><a href="comments.php"><?php echo langs('comments') ?> </a></li>
        <li><a href="members.php"><?php echo langs('members') ?> </a></li>
        <li><a href="#"><?php echo langs('logs') ?> </a></li>
      </ul>
    
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hesham <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="../index.php">Visit Show</a></li>
            <li><a href="members.php?do=edit&userid=<?php echo $_SESSION['id'] ?>"><?php echo langs('edit') ?></a></li>
             <li><a href="#"><?php echo langs('setting') ?></a></li>
            <li><a href="logout.php"><?php echo langs('logout') ?></a></li>
          </ul>
        </li>
      </ul>
    </div>
</nav>