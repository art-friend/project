<?php 

session_start();

if(!isset($_SESSION['username'])) {

      $message = $_SESSION['message'];
      $loggedin = false;
      header("location: login.php");

} else {
    $loggedin = true;
}
$message = "";
   //check for any message
   if(isset($_SESSION['message'])) {

      $message = $_SESSION['message'];
      unset($_SESSION['message']);
   }
   if(isset($_REQUEST['logout'])) {
      
      session_destroy();
      header("location: login.php");
   }
   
$permission = array();
   



