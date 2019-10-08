<?php
 
 //Start Session For Save UserName
 session_start();
 //print_r($_SESSION);

 if (isset($_SESSION['UserName'])) {
 	$pageTitle = 'Dashboard';
 	include 'init.php';

 	/*Number of total members we want to show  */
 	$numUsers = 4;
 	$LatestUser = getLatest("*","users","UserID",$numUsers);

 	$numItems = 4;
 	$LatestItem = getLatest("*","items","Item_ID",$numItems);

 }

?>

<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="text-center">Welcome to the Dashboard</h1>
			</div>

				<!-- Total Memebers-->
				<div class="col-lg-4">
						<div class="Total-Members">
							<i class="fa fa-users fa-3x"></i>
						  <div class="info">
					Total Members 
					<span><a href="members.php?do=Manage"><?php echo countMembers('UserID','users');?></a></span>
						  </div>
						</div>
				</div>

				<!-- Total Pendings-->
				<div class="col-lg-4">
					<div class="Pending-Members">
						  <i class="fa fa-user-plus fa-3x"></i>
						<div class="info">
							Pendings Members
							<span>
								<a href="members.php?do=Manage&page=Pending">
									<?php
										echo CheckItem("RegStatus","users",0);
									?>
								</a>
							</span>
						</div>
					</div>
				</div>
				
				<!--Total Items -->
				<div class="col-lg-4">
					<div class="Total-Items">
						   <i class="fa fa-product-hunt fa-3x"></i>
						<div class="info">
						   Total Items <span><a href="item.php"><?php echo countItems('Item_ID','items'); ?></a></span>
						</div>
					</div>
				</div>
				
				
						<!-- Second latest section-->
				
						<div class="col-lg-12">
							 <div class="card">
							 	<div class="card-header">
							 		<h4><i class="fa fa-users"></i> Latest <?php echo $numUsers; ?> Members </h4>
							 		</div>

							 		<!-- Card body-->
							 		<ul class="list-unstyled">
							 			<?php
							 				if (!empty($LatestUser)) {
							 					foreach ($LatestUser as $User) {
							 						echo '<li>' . $User['UserName'] . '<span class="btn btn-default"><i class="fa fa-edit"></i><a href="members.php?do=Edit&userid='. $User['UserID']. '">Edit</a></span></li> ';

							 					}
							 				}

							 			?>
							 		</ul>

							 		

							 </div>

							 </div>
						</div>
					
						<div class="col-lg-12">
							 <div class="card">
							 	<div class="card-header">
							 		<h4><i class="fa fa-users"></i> Latest <?php echo $numItems; ?> Items </h4>
							 		</div>

							 		<!-- Card body-->
							 		<ul class="list-unstyled">
							 			<?php
							 				if (!empty($LatestItem)) {
							 					foreach ($LatestItem as $item ) {
							 						echo '<li>' . $item['Name'] . '<span class="btn btn-default"><i class="fa fa-edit"></i><a href="item.php?do=Edit&itemid='. $item['Item_ID']. '">Edit</a></span></li> ';

							 					}
							 				}

							 			?>
				</div>						
			</div>
						
	    
</section>


   <?php 
  include $tpl .'footer.php';
?>

