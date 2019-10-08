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
          
                }


    else if( $do == 'Add') { 
      
  }

  
     else if( $do == 'Insert'){
     
    }
     
    
    

    else if ( $do == 'Edit' ){ 

      
    }
    
    
 

    else if ( $do == 'Update' ){
      
  }
    
     else if ( $do == 'Delete' ){
      
     
     }

     else if ( $do == 'Active' ){
      
   }

}

  else{
 
    header('location: index.php');
    exit();
    
  }
  
  // Output Buffering End
  ob_flush();


?>
   
