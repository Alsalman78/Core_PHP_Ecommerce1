<?php
  ob_start();

  session_start();
  $pageTitle = 'Profile';
 
    include 'init.php';

    if (isset($_SESSION['user'])) {
	$getUser = $con->prepare('SELECT * FROM users WHERE UserName=?');

	$getUser->execute(array($SessionUser));

	$info = $getUser->fetch();

	$userid = $info['UserID'];
	

?>

 <section>
 	<div class="container">
 		<div class="row">
 			<div class="col-lg-12">
 				 <h1 class="text-center">My Profile</h1>
 			</div>
 		</div>
 	</div>
 </section>

 <section>
   <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-header">
                      <h4>My Information</h4>
                  </div>
                  <div class="card-body">  
                     <ul class="list-unstyled">
                       <li>
                        <i class="fa fa-user "></i>
                        <span> UserName </span>: <?php echo $info['UserName'] ; ?>
                       </li>

                       <li>
                        <i class="fa fa-user "></i>
                        <span> Full Name </span>: <?php echo $info['FullName'] ; ?>
                       </li>

                       <li>
                        <i class="fa fa-envelope "></i>
                        <span> Email </span>: <?php echo $info['Email'] ; ?>
                       </li>

                        <li>
                        <i class="fa fa-calendar "></i>
                        <span> Registration Date </span>: <?php echo $info['Date'] ; ?>
                       </li>

                       <li>
                        <i class="fa fa-phone "></i>
                        <span> Phone Number </span>: <?php echo $info['PhoneNumber'] ; ?>
                       </li>

                       <li>
                        <i class="fa-address-card-o "></i>
                        <span> Address </span>: <?php echo $info['PAaddress'] ; ?>
                       </li>
                     </ul>
                      <a href="" class="btn btn-primary btn-block">Edit Information</a>
                  </div>

              </div>
          </div>
      </div>
   </div>
 </section>

  <section>
     <div class="container">
        <div class="row">
           <div class="col-lg-12">
              <div class="card">
                 <div class="card-header">
                    <h4>My Items</h4>
                 </div>
                  <div class="card-body">
                      
                      <?php
                          $myItems = getAllFrom("*","items","where Member_ID = $userid","","Item_ID");

                          if (!empty($myItems)) {
                           echo '<div class="row">';
                               
                                foreach ($myItems as $Item) {
                               echo '<div class="col-lg-3">';

                                   echo '<div class="item-box">';
                                    if ($Item['Approve'] == 0) {
                                      echo '<span class="approval-status">Waiting for Admin Approval. </span>';
                                    }

                    echo '<h3 class="item-name">' . $Item['Name'] . '</h3>';
                    echo "<br>";
                    echo '<img src="layout/images/sa.jpg" class="img-fluid" class="item-box">';
                     echo '<span class="price-tag" >$' . $Item['Price'] . '</span>';
                    echo "<br>";
                    
                    echo "<br>";
                    echo '<span class="item-Desc">' . $Item['Description'] . '</span>'; 
                    echo "<br>";
                    echo '<p class="item-Add_Date">' . $Item['Add_Date'] . '</p>';

                    echo '<button type="button" class="btn btn-warning"><i class="fas fa-shopping-cart"></i> Add to cart</button>';
                                    

                                    echo '</div>';
                               echo '</div>';
                                }

                            echo '</div>';
                          }else{

                            echo 'Sorry ,There is no item to show,.<br> <br>  <a href="newAdd.php" class="btn btn-primary"> Add New item</a>';
                          }

                      ?>
                  </div>

              </div>
           </div>
        </div>
     </div>
  </section>





<?php

 }
  else{
  	header('Location : login.php');
  	exit();
  }
  include $tpl . 'footer.php';

  ob_end_flush();
?>