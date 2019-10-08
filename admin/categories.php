<?php 
  
  /*===============================
  =   Use this Page For Register Member, 
  = Edit Profile, UPdate Profile 
  =   Delete Profile
  =  -> Super Admin Can
  ====================================*/

// Output Buffering Start
ob_start(); 

  session_start();
  $pageTitle = 'categorie\'s';

  if (isset($_SESSION['UserName'])) {

     include 'init.php';

     $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

         if ( $do == 'Manage') {
          
              $sort = 'ASC';
              $sort_array = array('ASC','DESC');

              if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array )) {

                $sort = $_GET['sort'];  
              }

              $stmt2 = $con->prepare("SELECT * FROM categories WHERE Parent=0 ORDER BY Ordering $sort");

              $stmt2->execute();

              $cats = $stmt2->fetchAll();

              if (!empty($cats)) { ?>
              
              <div class="container">
                 <div class="row">
                      <div class="col-lg-12">
                        <h1 class="text-center">Manage Categories</h1>
                        <div class="card">
                          <div class="card-header">
                            Manage Categories
                            <div class="pull-right">
                              Ordering : 
                                [<a class="<?php if($sort== 'ASC'){ echo 'active'; } ?>" href="?sort=ASC">ASC</a> |  <a class="<?php if($sort== 'DESC'){ echo 'active'; } ?>" href="?sort=DESC">DSC</a>]                                
                            </div>
                          </div>

                          <div class="card-body">
                            
                            <?php
                            foreach ($cats as $cat) {
                             
                            echo "<div>";

                            echo '<div class="pull-right">';
                          echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-primary' >Edit</a>";

                          echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='btn btn-danger' >Delete</a>"; 
                           echo '</div>'; 

                             echo "<h1>" . $cat['Name'] . "</h1>";
                             echo "<p>" . $cat['Description'] . "</p>";

                             if ($cat['Visibility'] == 1) {
                                    echo "<span class='visibility'><i class='fa fa-close'></i>Hidden</span>"; 
                             }

                             if ($cat['Allow_Comments'] == 1) {
                                    echo "<span class='commenting'><i class='fa fa-close'></i>Hidden</span>"; 
                             }
                     
                              if ($cat['Allow_Ads'] == 1) {
                                    echo "<span class='allowad'><i class='fa fa-close'></i>Hidden</span>"; 
                           }
                            
                           //Get child Category 
                            $childCats =  getAllFrom("*","categories","where Parent = {$cat['ID']}","","ID");

                              if (!empty($childCats)) {
                                    echo "<h4 class=''>Child Category </h4>";
                                    echo "<ul class='list-unstyled'>";
                                    foreach ($childCats  as $C) {
      echo "<li><a href='categories.php?do=Edit&catid" . $C['ID'] . "' class='child-class'>" . $C['Name'] . "</a>";
                                     
                              }
                              
                      echo "</ul>";

                  }
           
                              echo "<div>";
                            }
                           ?>
                          </div>
                        </div>
                      </div>
                        <div class="col-lg-12">
                          <a href="categories.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Category</a>     
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
            <h1 class="text-center">Add New Catagory </h1>
          </div>
            <div class="col-lg-6 offset-lg-3">
              <form action="?do=Insert" method="POST">
                <!-- Start Catagory Name Field -->
                <div class="form-group">
                  <input type="text"
                   name="name" 
                   class="form-control" placeholder="Name of The Catagory" 
                   required="required"
                   autocomplete="off" 
                   >
                </div>
                <!-- End Catagory Name Field -->

                <!-- Start Catagory Description Field -->
                <div class="form-group">
                  <input type="text"
                   name="Description" 
                   class="form-control" placeholder="Description" 
                   required="required"
                   autocomplete="off" 
                   >
                </div>
                <!-- End Catagory Description Field -->


                 <!-- Start Sub-Catagory Parent Field -->

                 <div class="form-group" >
                    <select name="Parent" class="form-control">
                      <option value="0">None</option>
                     <?php
                      $allCats = getAllFrom("*","categories","where Parent = 0","","ID","ASC");

                      foreach ($allCats  as $Cat) {
                    echo "<option value='" . $Cat['ID'] . "'>" .$Cat['Name'] . "</option>";
                  }
                       ?>  
                    </select>
                  </div>

                 <!-- End Sub-Catagory Parent Field -->

                <!-- Start Catagory Ordering Field -->
                <div class="form-group">
                  <input type="text"
                   name="Ordering" 
                   class="form-control" placeholder="Number to arrange the catagory" 
                   required="required"
                   autocomplete="off" 
                   >
                </div>
                <!-- End Catagory Ordering Field -->

                <!-- Start Catagory Visibility Field -->
                <div class="form-group">
                  <label>Visibility</label>
                  <div class="input-group">
                    <div>
                      <input id="visibility-yes" type="radio" name="visibility" value="0" checked>
                    <label for="">Yes</label>
                    </div>
                  </div>

                  <div class="input-group">
                    <div>
                      <input id="visibility-no" type="radio" name="visibility" value="1" checked>
                    <label for="">No</label>
                    </div>
                  </div>

                </div>
                <!-- End Catagory Visibility Field -->

                  <!-- Start Catagory Comment Field -->
                <div class="form-group">
                  <label>Allow Comment</label>
                  <div class="input-group">
                    <div>
                      <input id="com-yes" type="radio" name="Commenting" value="0" checked>
                    <label for="">Yes</label>
                    </div>
                  </div>

                  <div class="input-group">
                    <div>
                      <input id="com-no" type="radio" name="Commenting" value="1" >
                    <label for="">No</label>
                    </div>
                  </div>

                </div>
                <!-- End Catagory Comment Field -->


                 <!-- Start Catagory ads  Field -->
                <div class="form-group">
                  <label>Allow Ads</label>
                  <div class="input-group">
                    <div>
                      <input id="ads-yes" type="radio" name="ads" value="0" checked>
                    <label for="">Yes</label>
                    </div>
                  </div>

                  <div class="input-group">
                    <div>
                      <input id="ads-no" type="radio" name="ads" value="1" >
                    <label for="">No</label>
                    </div>
                  </div>

                </div>
                <!-- End Catagory ads Field -->

                <!-- Add Catagory Button -->
                <div class="form-group">
                  <input type="submit" value="Add Catagory" class="btn btn-primary" >

                </div>
              </form>
            </div>
        </div>
      </div>
        
      <?php
  }

  
     else if( $do == 'Insert'){

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          echo '<h1 class="text-center">Insert New Catagory <h1/>';

          // Get all the variable from the form

          $name        =$_POST['name'];
          $description =$_POST['Description'];
          $Parent      =$_POST['Parent'];
          $Order       =$_POST['Ordering'];
          $visible     =$_POST['visibility'];
          $comment     =$_POST['Commenting'];
          $ads         =$_POST['ads'];
         

          $check = CheckItem("Name","categories",$name);

        if ($check==1) {
          $theMsg = '<div class="alert alert-danger">Sorry! This Catagory is Already Exist</div>';
          redirectHome($theMsg,'back',5);
        }
        else{

          $stmt = $con->prepare("INSERT INTO categories 
            (Name,Description,Parent, Ordering,Visibility,Allow_Comments,Allow_Ads) 
            VALUES( :zname,:zdesc,:zparent,:zorder,:zvisible,:zcomment,:zads)
            ");

          $stmt->execute(array(

            ':zname'    =>  $name ,
            ':zdesc'    =>  $description,
            ':zparent'  =>  $Parent,
            ':zorder'   =>  $Order,
            ':zvisible' =>  $visible ,
            ':zcomment' =>  $comment,
            ':zads'     =>  $ads
            
          ));

          //Echo Success Message
          $theMsg = "<div class ='alert alert-success'>" . $stmt->rowCount() . "Recored Updated</div>";

          redirectHome($theMsg,'back',5);

           }
        }
        else{
              echo "<div class='container'>";

              $theMsg = '<div class="alert-danger">Sorry! You Can\'t browse this page </div>';

              redirectHome($theMsg,'back',5);

              echo "</div>";
        }

    }
     
    
    

    else if ( $do == 'Edit' ){ 

        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']): 0;

        //Select All Data depend on this Category ID

        $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
        $stmt->execute(array($catid));
        $cat=$stmt->fetch();
        $count=$stmt->rowCount();
      
      if ($count > 0) {?>

      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="text-center">Edit Category </h1>
          </div>

          <div class="col-lg-12">
            
            <form action="?do=Update" method="POST">
              <input type="hidden" name="catid" value="<?php echo $catid; ?>">


                 <!-- Start Catagory Name Field -->
                <div class="form-group">
                  <input type="text"
                   name="name" 
                   class="form-control" placeholder="Name of The Catagory" 
                   value="<?php echo $cat['Name']; ?>" 
                   >
                </div>
                <!-- End Catagory Name Field -->

                <!-- Start Catagory Description Field -->
                <div class="form-group">
                  <input type="text"
                   name="Description" 
                   class="form-control" placeholder="Description" 
                  value="<?php echo $cat['Description']; ?>"
                   >
                </div>
                <!-- End Catagory Description Field -->


                 <!-- Start Sub-Catagory Parent Field -->

                 <div class="form-group" >
                    <select name="Parent" class="form-control">
                      <option value="0">None</option>
                      <?php
                         /* A new function which can call All the parent Catagory - we will set that on function.php file soon 
                          $allcats = getALLForm("*","categories","where Parent = 0","","ID","ASC");
                          foreach ($allcats as $c) {
                            
                          }*/
                      ?>
                    </select>
                  </div>

                 <!-- End Sub-Catagory Parent Field -->

                <!-- Start Catagory Ordering Field -->
                <div class="form-group">
                  <input type="text"
                   name="Ordering" 
                   class="form-control" placeholder="Number to arrange the catagory" 
                value="<?php echo $cat['Ordering']; ?>"
                   >
                </div>
                <!-- End Catagory Ordering Field -->

                <!-- Start Catagory Visibility Field -->
                <div class="form-group">
                  <label>Visibility</label>
                  <div class="input-group">
                    <div>
                      <input id="visibility-yes" type="radio" name="visibility" value="0" <?php if ($cat['Visibility']==0) {
                       echo 'checked';
                      } ?>  >
                    <label for="">Yes</label>
                    </div>
                  </div>

                  <div class="input-group">
                    <div>
                      <input id="visibility-no" type="radio" name="visibility" <?php if ($cat['Visibility']==1) {
                       echo 'checked';
                      } ?> >
                    <label for="">No</label>
                    </div>
                  </div>

                </div>
                <!-- End Catagory Visibility Field -->

                  <!-- Start Catagory Comment Field -->
                <div class="form-group">
                  <label>Allow Comment</label>
                  <div class="input-group">
                    <div>
                      <input id="com-yes" type="radio" name="Commenting" <?php if ($cat['Allow_Comments']==0) {
                       echo 'checked';
                      } ?> >
                    <label for="">Yes</label>
                    </div>
                  </div>

                  <div class="input-group">
                    <div>
                      <input id="com-no" type="radio" name="Commenting" value="0"> <?php if ($cat['Allow_Comments']==1) {
                       echo 'checked';
                      } ?> 
                    <label for="">No</label>
                    </div>
                  </div>

                </div>
                <!-- End Catagory Comment Field -->


                 <!-- Start Catagory ads  Field -->
                <div class="form-group">
                  <label>Allow Ads</label>
                  <div class="input-group">
                    <div>
                      <input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads']==0) {
                       echo 'checked';
                      } ?>>
                    <label for="">Yes</label>
                    </div>
                  </div>

                  <div class="input-group">
                    <div>
                      <input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads']==1) {
                       echo 'checked';
                      } ?> >
                    <label for="">No</label>
                    </div>
                  </div>

                </div>
                <!-- End Catagory ads Field -->

                  <div class="form-group">

                    <input type="submit" value="Update catagory" class="btn btn-primary">
                    
                  </div>

            </form>
          </div>
        </div>
      </div>
      
      <?php
      }  else{
         echo "<div class ='container'>";
              $theMsg = '<div class="alert alert-danger">There is no such ID.  </div>';
          echo "</div>";
      }
    }

    else if ( $do == 'Update' ){?>
      
          <div class="container">
             <div class="row">
                <div class="col-lg-12">
                   <h1 class="text-center">Update Category</h1>
                </div>
                    <div class="col-lg-12">
                        <?php
                            if ($_SERVER['REQUEST_METHOD']== 'POST') {
                              // GET all The variables from the Form
                                $id          =$_POST['catid'];
                                $name        =$_POST['name'];
                                $description =$_POST['Description'];
                                $Parent      =$_POST['Parent'];
                                $Order       =$_POST['Ordering'];
                                $visible     =$_POST['visibility'];
                                $comment     =$_POST['Commenting'];
                                $ads         =$_POST['ads']; 
                                 

                                // Check if there is no error on proceeding the update operation

                                if (empty($formErrors)) {
                                  # Update the database
                                  $stmt=$con->prepare("UPDATE categories SET 
                                            Name = ?,
                                            Description=?,
                                            Parent=?,
                                            Ordering=?,
                                            Visibility=?,
                                            Allow_Comments=?,
                                            Allow_Ads=? WHERE 
                                            ID =? 
                                  "); 

                                  $stmt ->execute(array($name,$description,$Parent,$Order,$visible,$comment,$ads,$id));
                                  $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated</div>";
                                  redirectHome($theMsg,'back',3);

                                }

                            }
                        ?>
                    </div>
             </div>
          </div>
          
  <?php }
    
     else if ( $do == 'Delete' ){
         ?> 
                <div class="container">
                  <div class="row">
                    <div class="col-lg-12">
                       <?php 
                              echo "<h1 class='text-center'>Delete Catagory</h1>";

                               $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']): 0;
                               // select all the data from database

                               $check = CheckItem('ID','categories',$catid);
                               if ($check > 0) {
                                 $stmt = $con->prepare("DELETE FROM categories WHERE ID =:zid");
                                 $stmt->bindParam(":zid",$catid);
                                 $stmt->execute();

                                  $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Deleted</div>";
                                  redirectHome($theMsg,'back',3);
                               }
                               else{
                                    $theMsg = "<div class='alert alert-danger'> There is no such ID </div>";
                                  redirectHome($theMsg,'back',3);
                               }
                          ?>
                    </div>
                  </div>
                </div>  

       <?php
     }

}

  else{
 
    header('location: index.php');
    exit();
    
  }
  
  // Output Buffering End
  ob_flush();
?>
   
