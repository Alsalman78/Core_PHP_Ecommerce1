<?php
ob_start();
//Start Session for Save Username
session_start();
$pageTitle = 'Login';

if (isset($_SESSION['user'])) {
	header('Location: index.php');
}

include 'init.php';

// Check if the user coming from HTTP Request
   if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
     $username= $_POST['username'];
     $password = $_POST['password'];
     $hassedPass = sha1($password);

    // Check the username,password,hassedpass working or not.
     //echo $username . ' '.$password.' '.$hassedPass;

     $stmt = $con -> prepare (
      "SELECT
     UserID,UserName,Password 
     FROM users
     WHERE UserName = ?
     AND Password = ?
    
     ");

     $stmt -> execute(array($username, $hassedPass));
     $get = $stmt -> fetch();
     $count= $stmt -> rowCount();

     if ($count > 0) {
     
     	$_SESSION['user'] = $username; //Register Username for session
     	$_SESSION['uid'] = $userID;    //Register userID for session
    

     header('Location: index.php');
      exit();
     }
     else if ($count > 1) {
     	//Show the Error on login failure



     }


     else{
     	$formErrors = array();

     	$username  = $_POST['username'];
     	$password  = $_POST['password'];
     	$password2 = $_POST['password2'];
     	$Email     = $_POST['Email'];

     	if (isset($username)) {
     		$FilteredUser = filter_var($username, FILTER_SANITIZE_STRING);
     		if (strlen($username) < 4) {
     				$formErrors[] = 'UserName Must Be Larger Than 4 characters';

     		}
     	}

     	if (isset($password ) && isset($password2)) {
     		if (empty($password )) {
     			$formErrors[] = 'Sorry, Password can\'t be empty';
     		}
     		if (sha1($password) !== sha1($password2)) {

     			$formErrors[] = 'Sorry, Password does not match ';
     		}

     	}

     	if (isset($Email)) {
     		$FilteredEmail = filter_var($Email, FILTER_SANITIZE_EMAIL);

     		if (filter_var($FilteredEmail, FILTER_VALIDATE_EMAIL )!= true){

     			$formErrors[] = 'This Email is not Valid';
     		} 
     	}

     	//Check If there is no error procced the user Add

     	if (empty($formErrors)) {
     		 $Check = CheckItem("UserName","users",$username);

     		 if ($Check == 1) {
     		 	$formErrors[] = 'This User Already exist';
     		 }else{
     		 	  // Insert new info into the database
     		 	$stmt = $con->prepare("INSERT INTO users (UserName,Password,Email,RegStatus,Date) 
     		 		VALUES(:zuser,:zpass,:zemail ,0,now())");

     		 	
     		 	$stmt->execute(array(
     		 			'zuser' => $username,
     		 			'zpass' => sha1($password),
     		 			'zemail' =>$Email
     		 			
         	 	)); 
            	 	//Echo Success Message
         	 	$SuccessMsg = 'Congratulaion,Now you are Registerd. ';
     	 }
     	}
     	 else{
     	 		//Show the failure Message
     	 		

     	}
     }
 }
 
?>

	<section>
		<div class="container">
			<div class="row">
				<div class="col-lg-4 offset-lg-4 login-page" >
					<h1 class="text-center">
					<span class="selected" data-class="login"> Login </span>| 
					<span data-class="signup">SignUp </span>        
					 </h1>
					 <!--Login Form for vendor -->
					 	<form class="login" action="<?php echo $_SERVER['PHP_SELF']   ?>" method="POST">
					 		<div class="form-group">
					 			<div class="input-container">
					 				 <input
					 				 pattern = ".{4,}"
					 				  title = "Text must be 4 character"
					 				  type="text"
					 				   name="username"
					 				   class="form-control"
					 				   autocomplete = "off"
					 				   placeholder="Email or Username "
					 				    required="required"
					 				   />
					 			</div>
					 		</div>

					 		<div class="form-group">
					 			<div class="input-container">
					 				 <input
					 				 pattern = ".{4,}"
					 				  title = "Password must be 4 digit"
					 				  type="password"
					 				   name="password"
					 				   class="form-control"
					 				   autocomplete = "new-password"
					 				   placeholder="Password "
					 				    required="required"
					 				   />
					 			</div>
					 		</div>

					 		<input type="submit" name="login" value="Login" class="btn btn-success btn-block">
					 	</form>

					 	<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

					 		<div class="form-group">
					 			<div class="input-container">
					 				 <input
					 				 pattern = ".{4,}"
					 				  title = "Text must be 4 character"
					 				  type="text"
					 				   name="username"
					 				   class="form-control"
					 				   autocomplete = "off"
					 				   placeholder="Email or Username "
					 				    required="required"
					 				   />
					 			</div>
					 		</div>

					 		<div class="form-group">
					 			<div class="input-container">
					 				 <input
					 				  minlength="4"
					 				  type="password"
					 				   name="password"
					 				   class="form-control"
					 				   autocomplete = "new-password"
					 				   placeholder="Password"
					 				   required="required"
					 				   />
					 			</div>
					 		</div>

					 		<div class="form-group">
					 			<div class="input-container">
					 				 <input
					 				  minlength="4"
					 				  type="password"
					 				   name="password2"
					 				   class="form-control"
					 				   autocomplete = "new-password"
					 				   placeholder="Re-Enter Password"
					 				   required="required"
					 				   />
					 			</div>
					 		</div>

					 		<div class="form-group">
					 			<div class="input-container">
					 				 <input
					 				 
					 				  type="Email"
					 				   name="Email"
					 				   class="form-control"
					 				   autocomplete = "off"
					 				   placeholder="Email"
					 				   required="required"
					 				   />
					 			</div>
					 		</div>

					 		<input class="btn btn-primary btn-block" type="submit" name="SignUp" value="Sign-Up"> 		
					 	</form>

					 	<?php
                             if (!empty($formErrors)) {
                             	foreach ($formErrors as $Error) {
                             	     echo $Error . '</br>';
                             	}
                             }

                             if (isset($SuccessMsg)) {
                             	echo '<div class="alert alert-success">' . $SuccessMsg . '</div>';
                             }

					  ?>
				</div>
			</div>
		</div>
	</section>



<?php
		include $tpl . 'footer.php';
		ob_end_flush();
?>