<?php 
ob_start();
session_start();

$pageTitle = 'HomePage';
include 'init.php';
 ?>

 <section>
 	<div class="container">
 		<div class="row">
 			<div class="col-lg-12">
 				<h1 class="text-center">Website Home Page</h1>
 			</div>
 		</div>
 	</div>
 </section>

 <?php
  include $tpl . 'footer.php';
  ob_end_flush();

   ?>