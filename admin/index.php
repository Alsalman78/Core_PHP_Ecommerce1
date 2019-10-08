<?php 
  session_start();
  
  $pageTitle = 'Login';
  $noNavbar = '';
  
  if(isset($_SESSION['UserName'])){
    header('Location: dashboard.php');
  }

   include 'init.php';
  

    // Check if the user coming from HTTP Request
   if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
     $username = $_POST['user'];
     $password = $_POST['pass'];
     $hassedPass = sha1($password);

    // Check the username,password,hassedpass working or not.
     //echo $username . ' '.$password.' '.$hassedPass;

     $stmt = $con -> prepare (
      "SELECT
     UserID,UserName,Password 
     FROM users
     WHERE UserName = ?
     AND Password = ?
     AND  GroupID =1  /* Admin Approval = Make GroupID '1' in db */ 
     Limit 1
     ");

     $stmt -> execute(array($username, $hassedPass));
     $row = $stmt -> fetch();
     $count= $stmt -> rowCount();

     if ($count > 0) {
      //print_r($row);
        //Check the user registerd or not.
        //echo 'Welcome '. $username;

      $_SESSION['UserName'] = $username; //Reg UserNmae for session
      $_SESSION['UserID'] = $row['UserID'];//reg UserID for session


     header('Location: dashboard.php');
      exit();
     }
     
   }
?>

<!-- Admin login section Start-->
<section>
 
  <div class="container">
    <div class="row">
      <div class="col-lg-4 offset-lg-3">
        <h2>Admin Login</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
          <div class="form-group">
            <input type="text" name="user" class="form-control" placeholder="username"
            required="required" 
            >
          </div>
           <div class="form-group">
            <input type="password" name="pass" class="form-control" placeholder="password"
            required="required"
            >
          </div>
            <button type="submit" class="btn btn-primary"> Login </button>
        </form>

      </div>
      
    </div>
  </div>
</section>
<!--Admin login Section End -->
 
   <?php 
  include $tpl .'footer.php';
?>
