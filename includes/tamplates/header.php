<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title><?php echo getTitle(); ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

  <!-- Font awesome CDN link-->
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Admin panel CSS file-->
  <link rel="stylesheet" type="text/css" href="<?php echo $css;?>Fontend.css">

  </head>
  <body>

   <!-- <div class="upper-navar"> -->
    <nav class="navbar navbar-dark bg-dark">
     <div class="container">
        <div class="row">
          <?php
            if (isset($_SESSION['user'])) {?>
            
                  <!-- Image and text -->
                
                  <a class="navbar-brand" href="#">
                    <img src="layout/images/tp.png" width="90" height="90" class="d-inline-block align-top" alt="">
                  </a>
                           

            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <?php  echo $SessionUser;?>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="profile.php">My profile</a>
                <a class="dropdown-item" href="newAdd.php">New Items</a>
                <a class="dropdown-item" href="logout.php">LogOut</a>
              </div>
            </div>

            <?php
          }
            else{
              ?>
                  <a href="login.php">
                    <div class="">
                      Login| Sign UP
                    </div>

                  </a>

            <?php
            }
          ?>
     </div>
   </div>

   </nav> 

   