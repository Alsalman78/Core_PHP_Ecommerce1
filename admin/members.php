<?php 
  
  /*===============================
  =   Use this Page For Register Member, 
  = Edit Profile, UPdate Profile 
  =   Delete Profile
  =  
  ====================================*/

// Output Buffering Start
ob_start(); 

  session_start();
  $pageTitle = 'Member\'s';

  if (isset($_SESSION['UserName'])) {

     include 'init.php';

     $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

         if ( $do == 'Manage') {
          // Manage the vendor Accounts

          // Pending Memeber Approval
           $query='';
           if (isset($_GET['page']) &&  $_GET['page'] == 'Pending') {

                 $query = 'AND RegStatus = 0';
      
              }

      // Select All Users From Users TableS
      $stmt= $con->prepare("SELECT * FROM users WHERE
        GroupID != 1 $query ORDER BY UserID");
      $stmt->execute();
      $rows = $stmt->fetchAll();


      if (!empty($rows)) {?>

      <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Manage Member's</h1>
            </div>

            <div class="table-responsive" >
              <table class="table table-border text-center">
                <tr>
                   <td>ID</td>
                   <td>Profile Picture</td>
                   <td>Username</td>
                   <td>FullName</td>
                   <td>Email</td>
                   <td>Phone</td>
                   <td>Address</td>
                   <td>Reg Date</td>
                   <td>Control</td>
                </tr>
                  <?php
                      foreach ($rows as $row){
                          echo "<tr>";

                            echo "<td>" . $row['UserID'] . "</td>";
                           echo "<td><img src='layout/images/avatar/" . $row['Avatar'] . "'alt='Profile Picture'> </td>";
                            echo "<td>" . $row['UserName'] . "</td>";
                            echo "<td>" . $row['FullName'] . "</td>";
                            echo "<td>" . $row['Email'] . "</td>";
                            echo "<td>" . $row['PhoneNumber'] . "</td>";
                            echo "<td>" . $row['PAaddress'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";

                            echo "<td>

                            <a href='members.php?do=Edit&userid=" .$row['UserID'] . "' class='btn btn-success'>Edit</a>

                            <a href='members.php?do=Delete&userid=" .$row['UserID'] . "' class='btn btn-danger'>Delete</a>";

                      if ($row['RegStatus']==0) {
                                 echo "<a href='members.php?do=Active&userid=" .$row['UserID'] . "' class='btn btn-info'>Active</a>";
                                      }

                            echo "</td>";
                          echo "</tr>";
                      }
                  ?>
              </table>
            </div>
        </div>
      </div>
        
        <?php
      }

      ?>
        <a href="members.php?do=Add" class="btn btn-primary">Add New Member</a>

      <?php
}


    else if( $do == 'Add') { 
      ?>
         <section>
           <div class="container">
            <div class="row">
              <!-- Heading Title for Add new member Page-->
              <div class="col-lg-12">
                <h1 class="text-center"> Add New Member</h1>
              </div>

              <!-- Add new member Page Registration Form--> 
              <div class="col-lg-6 offset-lg-3">
                <form action="?do=Insert" method="POST" enctype="multipart/form-data">
                  
                <!--Username Filled-->
                <div class="form-group">
                  <input 
                  type="text" 
                  name="Username" 
                  class="form-control"
                  placeholder="Username"
                  required="required"
                  autocomplete="off" 
                 />
                  </div>
                 

                <!--Password Filled-->
                <div class="form-group">
                  <input 
                  type="password" 
                  name="password" 
                  class="form-control"
                  placeholder="password"
                  required="required"
                  />
                </div>

                <!-- Full Name Filled-->
                <div class="form-group">
                  <input 
                  type="text" 
                  name="fullname" 
                  class="form-control" 
                  placeholder="Full Name"
                  required="required"
                   />
                </div>

                <!-- Email Filled-->
                <div class="form-group">
                  <input 
                  type="email" 
                  name="email" 
                  class="form-control" 
                  placeholder="Email Address"
                  required="required"
                 />
                </div>

                <!-- Phone Number Filled-->
                <div class="form-group">
                  <input 
                  type="text" 
                  name="phone" 
                  class="form-control" 
                  placeholder="Phone Number"
                  required="required"
                 />
                </div>

                <!-- Address Filled-->
                <div class="form-group">
                  <input 
                  type="text" 
                  name="address" 
                  class="form-control" 
                  placeholder="Permanent Address"
                  required="required"
                   />
                </div>

                  <!-- Avatar Filled Start-->
                <div class="form-group">
                  <input 
                  type="file" 
                  name="avatar" 
                  class="form-control" 
                  required="required"
                   />
                </div>
                <!-- Avatar Filled End-->

                <div class="form-group">
                  <input type="submit" value="Register" class="btn btn-primary">
                </div>

              </form>   
            </div>
            </div>
           </div>   
         </section>
        

    <?php
  }
  
  else if( $do == 'Insert'){//Insert function Start
  
 // echo $_POST['Username'] .' ' . $_POST['password'] . ' ' . $_POST['fullname'] .' ' . $_POST['email'] . ' ' . $_POST['phone'] . ' ' . $_POST['address'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          echo '<h1 class="text-center">New User Registerd Successfully .<h1/>';
        //Container start
        echo '<div class="container">';

        //Upload Variables

        $avatar = $_FILES['avatar'];

        $avatarName =$_FILES['avatar']['name'];
        $avatarSize =$_FILES['avatar']['size'];
        $avatarTemp =$_FILES['avatar']['tmp_name'];
        $avatarType =$_FILES['avatar']['type'];

       //Allow Extension Types 
       $avaterAllowedExtension = array("jpg","jpeg","png","gif"); 

       //Get Avtar Extension
      $avaterExtension = strtolower(end(explode('.', $avatarName)));


 
 //Get All The Variable From The Form [Add FORM]
    $user = $_POST['Username'];
    $pass = $_POST['password'];
    $fullname = $_POST['fullname'] ;
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];


    $hassedPass = sha1( $_POST['password']);

    //Validate Form
    $formErrors =  array();
    

    if (strlen($user) < 4 ) {
      $formErrors[] = '<div class="alert alert-danger">Username can\'t be Less Then 4 character</div>';
    }

    if (strlen($user) > 15) {
        $formErrors[]= '<div class="alert alert-danger">Username can\'t be  more Then 15 character</div>';
    }
    if (empty($pass)) {
        $formErrors[]= '<div class="alert alert-danger">Password can\'t be  empty .</div>';
    }

    if (empty($fullname)) {
        $formErrors[]= '<div class="alert alert-danger">Fullname can\'t be empty.</div>';
    }

    if (empty($email)) {
        $formErrors[]= '<div class="alert alert-danger">Email can\'t be empty.</div>';
    }
    if (empty($phone)) {
        $formErrors[]= '<div class="alert alert-danger">phone can\'t be empty.</div>';
    }
    if (empty($address)) {
        $formErrors[]= '<div class="alert alert-danger">address can\'t be empty.</div>';
    }

    if (!empty($avatarName) && !in_array($avaterExtension, $avaterAllowedExtension)) {
        $formErrors[]= '<div class="alert alert-danger">Image type is not allowed . Please use jpg,jpeg,png,gif. </div>';
    }
    if (empty($avatarName)) {
        $formErrors[]= '<div class="alert alert-danger">Upload your Profile Picture .</div>';
    }
    if (!empty($avatarSize > 4194304)) {
        $formErrors[]= '<div class="alert alert-danger">Avatar cant not be larger than 4 MB</div>';
    }


    foreach ( $formErrors as $error ) {
       echo '<div class="alert alert-danger">' . $error . '</div>';
    }

  //Check If There's No Error Procced The Update Operation 
    if (empty($formErrors)) {

      $avatar = rand(0,1000000) . '_' . $avatarName;

      move_uploaded_file($avatarTemp,"layout\images\avatar\\" . $avatarName);

      // Check UserInfo Exist In Database
      $Check = CheckItem("UserName","users", $user);

      if ($Check==1) {
         $theMsg = '<div class ="alert alert-danger">Sorry! User Already Exist. </div>';
         redirectHome($theMsg,'back',3);
      }

      else {
        //Insert New Memeber's Info into the Database
        //CRUD [Create]

      $stmt = $con->prepare("INSERT INTO users(UserName,  Password, FullName, Email,PhoneNumber,PAaddress, Avatar,RegStatus, Date)
       VALUES(:zuser,:zpass,:zfname,:zemail,:zphone,:zaddress ,:zavatar,0,now()) ");

      $stmt->execute(array(
        'zuser'  => $user,
        'zpass'  =>  $hassedPass,
        'zfname' => $fullname,
        'zemail' => $email ,
        'zphone' => $phone ,
        'zaddress'=> $address,
        'zavatar'=> $avatarName
      ));

      //Echo Success Message

      $theMsg="<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated</div>" ;

      redirectHome($theMsg,'back',3);


    }

    
    }


    else{
      echo "<div class='container' >";
      $theMsg="<div class='alert alert-danger'>Sorry, You Can not browse this page </div>";
      redirectHome($theMsg,'back',3);
      echo "</div>";
    }


   echo '</div>';
   //Container section End

    }
     
    }//Insert FUnction END
     
    
    

    else if ( $do == 'Edit' ){ 

      //Member's Profile Page Edit
      //Condition : TRue ? False - To Chech If THe Get Request is Numeric & Get The Integer Value of it

      $userid = isset($_GET['userid'] )&& is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

      //echo $userid;

      //Select ALL data Depend on the User ID
      $stmt= $con->prepare("SELECT * FROM users WHERE   UserID=? LIMIT 1 ");
      //Execute Query
      $stmt->execute(array($userid));
      // Fetch All The Data Depends on the ID
      $row = $stmt-> fetch();
      //Row Count
      $count = $stmt ->rowCount();

      //if ($count > 0) { ?>




    <!-- Create The Member's  Profile page design -->
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="text-center">Edit Your Profile</h1>
          </div>
          <!-- Member Edit page form Start-->
          <div class="col-lg-6 offset-lg-3">
            <form action="?do=Update" method="POST">
              <!--Hidden filed for user id-->
                  <input type="hidden" name="userid" value="<?php echo $userid;?>" >  


              <!--Username Filled-->
                <div class="form-group">
                  <input 
                  type="text" 
                  name="Username" 
                  class="form-control"
                  placeholder="Username"
                  value="<?php echo  $row['UserName'];?> " />
                  </div>

                <!--Password Filled-->
                <div class="form-group">
                  <input 
                   type="hidden" 
                   name="oldPassword" 
                    class="form-control"
                   value="<?php echo  $row['Password'];?>" 
                   />

                   <input 
                   type="password" 
                   name="newPassword" 
                   class="form-control"
                   placeholder="password"
                   autocomplete="off" 
                   />
                </div>

                <!-- Full Name Filled-->
                <div class="form-group">
                  <input 
                  type="text" 
                  name="fullname" 
                  class="form-control" 
                  placeholder="FullName"
                  autocomplete="off"
                  value="<?php echo  $row['FullName'];?> "/>
                </div>

                <!-- Email Filled-->
                <div class="form-group">
                  <input 
                  type="email" 
                  name="email" 
                  class="form-control" 
                  placeholder="Email Address"
                  autocomplete="off"
                  value="<?php echo  $row['Email'];?> " 
                 
                 />
                </div>

                <!-- Phone Number Filled-->
                <div class="form-group">
                  <input 
                  type="text" 
                  name="phone" 
                  class="form-control" 
                  placeholder="Phone number"
                  autocomplete="off"
                  value="<?php echo  $row['PhoneNumber'];?> " 
                 
                  />
                </div>

                <!-- Address Filled-->
                <div class="form-group">
                  <input 
                  type="text" 
                  name="address" 
                  class="form-control" 
                  placeholder="Permanent Address"  
                   autocomplete="off"
                  value="<?php echo  $row['PAaddress'];?> " 
                   />
                </div>

                <div class="form-group">
                  <input type="submit" value="Update Profile" class="btn btn-primary">
                </div>
                 
              
            </form>
            
          </div>

          <!-- Member Edit page form End-->

        </div>
      </div>


    <?php //}
  

    /*else{
       header('Location: 404.php');
    }*/
    }
    
    
 

    else if ( $do == 'Update' ){
      // Update user profile here

      echo '<h1>Update User Profile. </h1>';

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Get all the Variables from the form
        $id       = $_POST['userid'];
        $user     = $_POST['Username'];
        $fullname = $_POST['fullname'];
        $email    = $_POST['email'];
        $phone    = $_POST['phone'];
        $address  = $_POST['address'];

        $pass = empty($_POST['newPassword'])?($_POST['oldPassword']):sha1($_POST['newPassword']);

        //Validate The Form
         $formErrors =  array();
    

    if (strlen($user) < 4 ) {
      $formErrors[] = '<div class="alert alert-danger">Username can\'t be Less Then 4 character</div>';
    }

    if (strlen($user) > 15) {
        $formErrors[]= '<div class="alert alert-danger">Username can\'t be  more Then 15 character</div>';
    }

    if (empty($fullname)) {
        $formErrors[]= '<div class="alert alert-danger">Fullname can\'t be empty.</div>';
    }

    if (empty($email)) {
        $formErrors[]= '<div class="alert alert-danger">Email can\'t be empty.</div>';
    }
    if (empty($phone)) {
        $formErrors[]= '<div class="alert alert-danger">phone can\'t be empty.</div>';
    }
    if (empty($address)) {
        $formErrors[]= '<div class="alert alert-danger">address can\'t be empty.</div>';
    }

    foreach ( $formErrors as $error ) {
       echo '<div class="alert alert-danger">' . $error . '</div>';
    }

    // Check if there's No Error procced The update operation
    if (empty($formErrors)) {

      $stmt2 = $con->prepare("SELECT 
                                *
                              FROM
                                users
                              WHERE
                                UserName=?
                              AND 
                                UserID!=?
                                ");
      
      $stmt2->execute(array($user,$id));

      $count= $stmt2->rowCount();

      if ($count== 1) {
        echo '<div class="alert alert-danger">Sorry, This USer is already exist. </div>';
        redirectHome($theMsg,'back',3);

      }
      else {
          //Update the Database
        $stmt= $con->prepare("UPDATE 
                                users 
                              SET 
                              UserName=?,
                              Password=?,
                              FullName =?,
                              Email    =?,
                              PhoneNumber=?,
                              PAaddress=?
                              WHERE 
                               UserID=?
                            ");
        $stmt->execute(array($user,$pass,$fullname, $email,$phone,$address, $id ));

        //Print The Success Message
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated</div>";
        // Redirect the page on Home Page for Error Message
        redirectHome($theMsg,'back',3);
      }
        }
      }
  }
    
     else if ( $do == 'Delete' ){
      
      echo '<h1 class="text-center"> Delete Member </h1>';

      //Condition : TRue ? False - To Chech If THe Get Request is Numeric & Get The Integer Value of it

      $userid = isset($_GET['userid'] )&& is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

      $Check = CheckItem('userid','users',$userid);

       //Select ALL data Depend on the User ID
     // $stmt= $con->prepare("SELECT * FROM users WHERE   UserID=? LIMIT 1 ");
      //Execute Query
      //$stmt->execute(array($userid));

      // The row Count
      //$Check =$stmt->rowCount();

      if ($Check > 0) {
        
        $stmt = $con->prepare("DELETE FROM users WHERE UserID=:zuser");
        $stmt->bindParam(":zuser",$userid);
        $stmt->execute();

        $theMsg = "<div class='alert alert-danger'>" . $stmt->rowCount() . "Record Deleted</div>";
        redirectHome($theMsg,'back',5);
      }
      else{
        echo "<div class='container'>";
    $theMsg = "<div class = 'alert alert-danger'>This ID is Not Exist.</div>";
        redirectHome($theMsg,'back',5);
      echo "</div>";  
      }

     }
     else if ( $do == 'Active' ){
      // Approve  any user account

      echo '<h1 class="text-center">Active Member.  </h1>';

      //Condition : TRue ? False - To Chech If THe Get Request is Numeric & Get The Integer Value of it

      $userid = isset($_GET['userid'] )&& is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

      $Check = CheckItem('userid','users',$userid);

      if ($Check > 0) {
        
        $stmt = $con->prepare("UPDATE users SET   RegStatus=1 WHERE UserID=?");
        
        $stmt->execute(array($userid));

        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated.</div>";
        redirectHome($theMsg,'back',5);
      }
      else{
        echo "<div class='container'>";
    $theMsg = "<div class = 'alert alert-danger'>This ID is Not Exist.</div>";
        redirectHome($theMsg,'back',5);
      echo "</div>";  
      }


     }
     
      include $tpl .'footer.php';
}

  else{
 
    header('location: index.php');
    exit();
    
  }
  
  // Output Buffering End
  ob_flush();
?>
   
