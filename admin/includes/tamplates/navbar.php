
    <!-- Navigation menu Start-->

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN');  ?></a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="categories.php?do=Manage"> <?php echo lang('CATAGORIES');  ?> </a>
      </li> 

      <li class="nav-item">
        <a class="nav-link" href="item.php?do=Manage"><?php echo lang('ITEMS');  ?></a>
      </li>

       <li class="nav-item">
        <a class="nav-link" href="members.php?do=Manage"><?php echo lang('MEMBERS');  ?></a>
      </li>

       
      

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION['UserName']; ?> 
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">View Website</a>
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['UserID'];?>">Edit Profile</a>
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="logout.php">Log Out</a>
        </div>
      </li>
     
    </ul>
  </div>
</nav>

    <!-- Navigation menu End-->