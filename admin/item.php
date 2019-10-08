<?php 
  
  /*===============================
  =   Use this Page For Register Item, 
  = Edit product, UPdate item
  =   Delete item
  
  ====================================*/

// Output Buffering Start
ob_start(); 

  session_start();
  $pageTitle = 'Items\'s';
  if (isset($_SESSION['UserName'])) {

     include 'init.php';

     $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

         if ( $do == 'Manage') {

      // Select All Users From Items TableS
      $stmt= $con->prepare("SELECT 
                            items.*,
                            categories.Name AS category_Name, 
                              users.UserName
                            FROM 
                              items 
                              INNER JOIN 
                              categories
                              ON 
                              categories.ID = items.Cat_ID

                              INNER JOIN 
                               users 
                              ON 
                              users.UserID = items.Member_ID
                        ORDER BY
                         Item_ID");
      $stmt->execute();
      $items = $stmt->fetchAll();

          if (!empty($items)) {?>

      <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Manage Item's</h1>
            </div>

            <div class="table-responsive" >
              <table class="table table-border text-center">
                <tr>
                   <td>#ID</td>
                   <td>Name</td>
                   <td>Description</td>
                   <td>Price</td>
                   <td>Adding Date</td>
                   <td>Category</td>
                   <td>Username</td>
                   <td>Control</td>
                </tr>

                 <?php
                      foreach ($items as $item){
                          echo "<tr>";
                            echo "<td>" . $item['Item_ID'] . "</td>";
                            echo "<td>" . $item['Name'] . "</td>";
                            echo "<td>" . $item['Description'] . "</td>";
                            echo "<td>" . $item['Price'] . "</td>";
                            echo "<td>" . $item['Add_Date'] . "</td>";
                            echo "<td>" . $item['category_Name'] . "</td>";
                             echo "<td>" . $item['UserName'] . "</td>";      
                             echo "<td>
                             <a href = 'item.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class = 'fa fa-edit'></i> Edit </a>

                              <a href = 'item.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger'><i class = 'fa fa-close'></i> Delete </a>";

                              if ($item['Approve'] == 0) {
   echo "<a href='item.php?do=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-warning'><i class='fa fa-check'></i> Approve </a>";
                              
                              }


                          echo "</td>";    
                          echo "</tr>";
                      }
                  ?>
              </table>
            </div>
        </div>
              <div class="row" >
                <div class="col-lg-12" > 
                  <a href="item.php?do=Add" class="btn btn-dark"><i class="fa fa-plus"> </i> Add New Item</a>
                  
                </div>
                  
              </div>
      </div>      

             <?php
                }
           }

    else if( $do == 'Add') { ?>
            
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                   <h1 class="text-center">Add New Item</h1>
                </div>
                <div class="col-lg-6 offset-lg-3">
                  <form action="?do=Insert" method="POST">
                     <!-- Start Items Name Field-->
                    <div class="form-group">
                      <input type="text"
                       name="name"
                       class="form-control"
                       autocomplete="off"
                       placeholder="Name of the Item"
                       required="" 
                       />  
                    </div>
                    <!-- End Items Name Field-->

                    <!-- Start Items Description Field-->
                    <div class="form-group">
                      <input type="text"
                       name="Description"
                       class="form-control"
                       autocomplete="off"
                       placeholder="Description of the item"
                       required="" 
                       />  
                    </div>
                    <!-- End Items Desciption Field-->

                     <!-- Start Items price Field-->
                    <div class="form-group">
                      <input type="text"
                       name="price"
                       class="form-control"
                       autocomplete="off"
                       placeholder="Price of the item"
                       required="" 
                       />  
                    </div>
                    <!-- End Items Price Field-->

                     <!-- Start Country name Field-->
                    <div class="form-group">
                      <input type="text"
                       name="Country"
                       class="form-control"
                       autocomplete="off"
                       placeholder="Made By Country"
                       required="" 
                       />  
                    </div>
                    <!-- End Country Name Field-->

                    <!-- Start Status Field-->
                    <div class="form-group">
                        <select class="form-control" name="Status"> 
                          <option value="0">...</option>
                          <option value="1">Brand New</option>
                          <option value="2">Like New</option>
                          <option value="3">Used</option>
                          <option value="4">Very Old</option>
                        </select>
                    </div>
                    <!-- End Status Field-->

                  

                    <!-- Start Items Category Field -->
                    <div class="form-group">
                      <select class="form-control" name="category">
                        <option value="0">Select Users</option>
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
                    <!-- End Items Category Field -->

                     <!-- Start members Field-->
                    <div class="form-group">
                      <select class="form-control" name="member">
                        <option value="0">Select Users</option>
                        <?php
                            $allMembers = getAllfrom("*","users","","","UserID");
                            foreach ($allMembers  as $user ) {
                    echo "<option value='" . $user['UserID'] . "'>" .$user['UserName'] . "</option>";
                            }
                        ?>
                      </select> 
                    </div>
                    <!-- End members Field-->

                    <div class="form-group">
                      <input type="submit" value="Add new Item" class="btn btn-primary">
                      
                    </div>


                  </form>                   
                </div>
              </div>  
            </div>
  <?php
}

  
     else if( $do == 'Insert'){
          
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            echo '<h1 class="text-center">Insert New Item </h1>';

            $name    = $_POST['name'];
            $desc    = $_POST['Description'];
            $price   = $_POST['price'];
            $Country = $_POST['Country'];
            $Status  = $_POST['Status'];
            $cat     = $_POST['category'];
            $member  = $_POST['member'];
           

            //Validate Form
            $formErrors =  array();
    
    if (empty($name) ) {
      $formErrors[] = '<div class="alert alert-danger">Username can\'t be Empty </div>';
    }

    if (empty($desc)) {
        $formErrors[]= '<div class="alert alert-danger">Item Description can\'t be  Empty </div>';
    }
    if (empty($price)) {
        $formErrors[]= '<div class="alert alert-danger">price can\'t be  empty .</div>';
    }

    if (empty($Country)) {
        $formErrors[]= '<div class="alert alert-danger">$Country can\'t be empty.</div>';
    }

    if (empty($Status == 0)) {
        $formErrors[]= '<div class="alert alert-danger">You must choose the status.</div>';
    }
     if (empty($cat == 0 )) {
        $formErrors[]= '<div class="alert alert-danger">You must choose the category.</div>';
    }
    
    if (empty($member == 0)) {
        $formErrors[]= '<div class="alert alert-danger">You must choose the member.</div>';
    }

   
    //Loop into the Errors Inside the Array

    foreach ($formErrors as $error) {
       //Insert new items info into the items table inside the database 
      
      $stmt = $con->prepare("INSERT INTO items 
        (Name,Description,Price,Add_Date,Country_Made,Status,Cat_ID,Member_ID) 
        VALUES(:zname,:zdesc,:zprice,now(),:zCountry,:zStatus,:zcat,:zmember) ");

    $stmt->execute(array(


          'zname'    =>    $name,  
          'zdesc'      =>   $desc ,   
          'zprice'    =>    $price ,  
          'zCountry'  =>    $Country, 
           'zStatus'  =>  $Status , 
           'zcat'     =>   $cat,     
           'zmember'  =>  $member 
            ));

           //Echo Success Message

      $theMsg="<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated</div>" ;

      redirectHome($theMsg,'back',3);


    }

      }
      //Echo Error Message
      
      else{
              echo "<div class='container'>";
              $theMsg="<div class='alert alert-danger'>" . $stmt->rowCount() . "You can't browse this page</div>" ;

            redirectHome($theMsg,'back',3);
        echo "</div>";
      }
          
  }
     
    
    
    else if ( $do == 'Edit' ){ 
        //check the get request item is numeric & get the integer value of item

      $itemid = isset($_GET['itemid'] )&& is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

      //echo $userid;

      //Select ALL data Depend on the User ID
      $stmt= $con->prepare("SELECT * FROM items WHERE  Item_ID=?  ");
      //Execute Query
      $stmt->execute(array($itemid));
      // Fetch All The Data Depends on the ID
      $item = $stmt-> fetch();
      //Row Count
      $count = $stmt ->rowCount();

        if ($count > 0) { ?>

        <div class="container">
              <div class="row">
                <div class="col-lg-12">
                   <h1 class="text-center">Edit Item</h1>
                </div>
                <div class="col-lg-6 offset-lg-3">
                  <form action="?do=Update" method="POST">

                    <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">


                     <!-- Start Items Name Field-->
                    <div class="form-group">
                      <input type="text"
                       name="name"
                       class="form-control"
                       autocomplete="off"
                       placeholder="Name of the Item"
                      value="<?php echo $item['Name']; ?>"
                       />  
                    </div>
                    <!-- End Items Name Field-->

                    <!-- Start Items Description Field-->
                    <div class="form-group">
                      <input type="text"
                       name="Description"
                       class="form-control"
                       autocomplete="off"
                       placeholder="Description of the item"
                       value="<?php echo $item['Description']; ?>"
                       />  
                    </div>
                    <!-- End Items Desciption Field-->

                     <!-- Start Items price Field-->
                    <div class="form-group">
                      <input type="text"
                       name="price"
                       class="form-control"
                       autocomplete="off"
                       placeholder="Price of the item"
                      value="<?php echo $item['Price']; ?>" 
                       />  
                    </div>
                    <!-- End Items Price Field-->

                     <!-- Start Country name Field-->
                    <div class="form-group">
                      <input type="text"
                       name="Country"
                       class="form-control"
                       autocomplete="off"
                       placeholder="Made By Country"
                       value="<?php echo $item['Country_Made']; ?>"
                       />  
                    </div>
                    <!-- End Country Name Field-->

                    <!-- Start Status Field-->
                    <div class="form-group">
                        <select class="form-control" name="Status"> 
                          <option value="0">...</option>
                          <option value="1"<?php if ($item['Status'] == 1) {
                            echo 'Selected';
                          }   ?>>Brand New</option>
                          <option value="2"<?php if ($item['Status'] == 1) {
                            echo 'Selected';
                          }   ?>>Like New</option>

                          <option value="3"<?php if ($item['Status'] == 1) {
                            echo 'Selected';
                          }   ?>>Used</option>

                          <option value="4"<?php if ($item['Status'] == 1) {
                            echo 'Selected';
                          }   ?>>Very Old</option>  

                        </select>
                    </div>
                    <!-- End Status Field-->

                  

                    <!-- Start Items Category Field -->
                    <div class="form-group">
                      <select class="form-control" name="category">
                        <option value="0">Select Users</option>
                        <?php
                          
                          $stmt = $con->prepare("SELECT * FROM categories");
                          $stmt->execute(); 
                          $cats = $stmt->fetchAll();

                          foreach ($cats as $cat) {
                            echo "<option value='" . $cat['ID'] ."'";
                            if ($item['Cat_ID'] == $cat['ID']) {
                              echo 'Selected';
                            }
                            echo ">" . $cat['Name'] . "</option>";
                          }
                            
                        ?>
                      </select> 
                    </div>
                    <!-- End Items Category Field -->

                     <!-- Start  Item members Field-->
                    <div class="form-group">
                      <select class="form-control" name="member">
                        <option value="0">Select Users</option>
                        <?php

                          $stmt = $con->prepare("SELECT * FROM users");
                          $stmt->execute(); 
                          $users = $stmt->fetchAll();

                          foreach ($users as $user) {
                            echo "<option value='" . $user['UserID'] ."'";
                            if ($item['Member_ID'] == $user['UserID']) {
                              echo 'Selected';
                            }
                            echo ">" . $user['UserName'] . "</option>";
                          }
                            
                        ?>
                      </select> 
                    </div>
                    <!-- End members Field-->

                    <div class="form-group">
                      <input type="submit" value="Update Item" class="btn btn-primary">
                      
                    </div>


                  </form>                   
                </div>
              </div>  
            </div>


      <?php
    }
   } 
    
 

    else if ( $do == 'Update' ){

      echo '<h1 class="text-center">Update Item</h1>';
      echo '<div class = "container">';

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              
            $id      = $_POST['itemid'];
            $name    = $_POST['name'];
            $desc    = $_POST['Description'];
            $price   = $_POST['price'];
            $Country = $_POST['Country'];
            $Status  = $_POST['Status'];
            $cat     = $_POST['category'];
            $member  = $_POST['member'];
           
             //Validate Form
            $formErrors =  array();
    
    if (empty($name) ) {
      $formErrors[] = '<div class="alert alert-danger">Username can\'t be Empty </div>';
    }

    if (empty($desc)) {
        $formErrors[]= '<div class="alert alert-danger">Item Description can\'t be  Empty </div>';
    }
    if (empty($price)) {
        $formErrors[]= '<div class="alert alert-danger">price can not be  empty .</div>';
    }

    if (empty($Country)) {
        $formErrors[]= '<div class="alert alert-danger">$Country can\'t be empty.</div>';
    }

    if (empty($Status == 0)) {
        $formErrors[]= '<div class="alert alert-danger">You must choose the status.</div>';
    }
     if (empty($cat  == 0)) {
        $formErrors[]= '<div class="alert alert-danger">You must choose the category.</div>';
    }
    
    if (empty($member == 0)) {
        $formErrors[]= '<div class="alert alert-danger">You must choose the member.</div>';
    }

   
    foreach ($formErrors as $error) {

        echo '<div class = "alert alert-danger">' . $error . '</div>';

          }

          //Check if there is error then proceed the update operation

          if (empty($formErrors)) {
             $stmt = $con->prepare("
                  UPDATE  
                      items 
                   SET 
                      Name= ?,
                      Description = ?,
                      Price= ?,
                      Country_Made= ?,  
                      Status= ?,
                      Cat_ID= ?,
                      Member_ID= ?
                      WHERE 
                      Item_ID= ?
              ");

             $stmt->execute(array( $name, $desc ,$price,$Country ,$Status, $cat ,$member,$id));

             
              $theMsg="<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated</div>" ;

      redirectHome($theMsg,'back',3);
        
          }
           else{
              
              $theMsg= "<div class = 'alert alert-danger'>Sorry! You can't browse this page</div>";

            redirectHome($theMsg,'back',3);
       
      }

        }

     echo '</div>';

  }
    
     else if ( $do == 'Delete' ){

      echo '<h1 class="text-center">Delete Item</h1>';
      echo '<div class = "container">';
     
     //Delete item with all information
      $itemid = isset($_GET['itemid'] )&& is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

      //Select all the data depends on this ID
      $check =  CheckItem('Item_ID','items',$itemid);

      if ($check > 0 ) {
        
        $stmt = $con-> prepare("DELETE FROM items WHERE Item_ID = :zid");
        $stmt->bindParam(":zid",$itemid);
        
        $stmt->execute();
        
         //Echo Success Message

            $theMsg="<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated</div>" ;

            redirectHome($theMsg,'back',3);
      }else{
             $theMsg="<div class='alert alert-danger'>This ID doesnt exist. </div>";
              redirectHome($theMsg,'back', 3);
      }
      echo "</div>";

     }




     else if ( $do == 'Approve' ){
      echo '<h1 class="text-center">Approve Item</h1>';
      echo '<div class = "container">';

       //Approve item with all information
      $itemid = isset($_GET['itemid'] )&& is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

      $check = CheckItem('Item_ID','items', $itemid);

      if ($check > 0 ) {
        
        $stmt = $con-> prepare("UPDATE  items SET Approve = 1 WHERE Item_ID = ? ");

        
        $stmt->execute(array($itemid));
        
         //Echo Success Message

            $theMsg="<div class='alert alert-success'>" . $stmt->rowCount() . "Item Activated </div>" ;

            redirectHome($theMsg,'back',3);
      }else{
             $theMsg="<div class='alert alert-danger'>This ID doesnt exist. </div>";
              redirectHome($theMsg,'back', 3);
      }


      echo "</div>";
   }

}

  else{
 
    header('location: index.php');
    exit();
    
  }
  
  // Output Buffering End
  ob_flush();


?>
   
