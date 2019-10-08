<?php
  ob_start();

  session_start();
  $pageTitle = 'Add New Item';
 
    include 'init.php';

    if (isset($_SESSION['user'])) {

    
 ?>

 <section>
 	 <div class="container">
 	 	<div class="row">
 	 		<div class="col-lg-12 card">
 	 			 <div class="card-header">
 	 			 	 <h4>Add New Item</h4>
 	 			 </div>
 	 			 <div class="card-body">
 	 			 	<div class="row">
 	 			 		<div class="col-lg-8">
 	 			 			<!--Create New Item Form Start -->
 	 			 			<form class="add-item-form" action="<?php echo $_SERVER['PHP_SELF']  ?>" method="POST">

 	 			 				<!--Start  Item Name Field -->
 	 			 				<div class="form-group">
 	 			 					<label class="col-lg-3">Name</label>
 	 			 					<div  class="col-lg-9">
 	 			 						<div class="input-group">
 	 			 							<input 
 	 			 							pattern=".{4,}"
 	 			 							title="This field requird at least 4 character" 
 	 			 							type="text"
 	 			 							 name="name"
 	 			 							  class="form-control" autocomplete="off"
 	 			 							   placeholder="Name Of The Item" required
 	 			 							   data-class=".live-title" > 
 	 			 						</div>
 	 			 					</div>
 	 			 				</div>

 	 			 				<!--Start  Item Description Field -->
 	 			 				<div class="form-group">
 	 			 					<label class="col-lg-3">Description</label>
 	 			 					<div  class="col-lg-9">
 	 			 						<div class="input-group">
 	 			 							<input 
 	 			 							pattern=".{10,}"
 	 			 							title="This field requird at least 10 character" 
 	 			 							type="text"
 	 			 							 name="Desc"
 	 			 							  class="form-control" autocomplete="off"
 	 			 							   placeholder="Description Of The Item" required
 	 			 							   data-class=".live-desc" > 
 	 			 						</div>
 	 			 					</div>
 	 			 				</div>

 	 			 				<!--Start  Item Price Field -->
 	 			 				<div class="form-group">
 	 			 					<label class="col-lg-3">Price</label>
 	 			 					<div  class="col-lg-9">
 	 			 						<div class="input-group">
 	 			 							<input  
 	 			 							type="text"
 	 			 							 name="Price"
 	 			 							  class="form-control" autocomplete="off"
 	 			 							   placeholder="Price Of The Item" required
 	 			 							   data-class=".live-Price" > 
 	 			 						</div>
 	 			 					</div>
 	 			 				</div>

 	 			 				<!--Start Country Field -->
 	 			 				<div class="form-group">
 	 			 					<label class="col-lg-3">Country</label>
 	 			 					<div  class="col-lg-9">
 	 			 						<div class="input-group">
 	 			 							<input  
 	 			 							type="text"
 	 			 							 name="Country"
 	 			 							  class="form-control" autocomplete="off"
 	 			 							   placeholder="Made By Country" required
 	 			 							    > 	     
 	 			 						</div>
 	 			 					</div>
 	 			 				</div>

 	 			 				<!--Start Status Field -->
 	 			 				<div class="form-group">
 	 			 					<label class="col-lg-3">Status </label>
 	 			 					<div  class="col-lg-9">
 	 			 						<select class="form-control" name="Status" required> 

 	 			 						<option value="0">.....</option>
 	 			 						<option value="1">Brand New</option>
				                        <option value="2">Like New</option>
				                          <option value="3">Used</option>
				                          <option value="4">Very Old</option>
 	 			 						 </select>
 	 			 					</div>
 	 			 				</div>

 	 			 				<!--Start member Category Field  -->
 	 			 				<div class="form-group">
 	 			 					<label class="col-lg-3">Member </label>
 	 			 					<div  class="col-lg-9">
 	 			 						<select class="form-control" name="Member" required> 
                                 <option value="0">.....</option>
 	 			 						<?php
 	 			 			$stmt = $con->prepare("SELECT * FROM users");
 	 			 			$stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach ($users  as $user ) {
                    echo "<option value='" . $user['UserID'] . "'>" .$user['UserName'] . "</option>";
                            }
                        ?>
 	 			 						
 	 			 				</select>
 	 			 					</div>
 	 			 				</div>

 	 			 				<!--Start Item category Field -->
 	 			 				<div class="form-group">
 	 			 					<label class="col-lg-3"> Category </label>
 	 			 					<div  class="col-lg-9">
 	 			 						<select class="form-control" name=" category" required> 
                                 <option value="0">.....</option>
 	 			 					 <?php
                            $allCats = getAllFrom("*","categories","where Parent = 0","","ID");
                            foreach ($allCats  as $Cat) {
                    echo "<option value='" . $Cat['ID'] . "'>" .$Cat['Name'] . "</option>";

                      $childCAts = getAllFrom("*","categories","where Parent = {$Cat['ID']}","","ID");

                      foreach ($childCAts as $child ) {
                        echo "<option value='" . $child['ID'] . "'> ---" . $child['Name'] . "</option>";
                      }
                            }
                        ?>	
 	 			 						
 	 			 				</select>
 	 			 					</div>
 	 			 				</div>

							<div class="form-group">
								<input type="button" class="btn btn-primary" value="Add new Item">

							</div>

 	 			 			</form>
 	 			 			<!--Create New Item Form END -->
 	 			 		</div>
 	 			 			
 	 			 				
 	 			 			</div>

 	 			 		</div>

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