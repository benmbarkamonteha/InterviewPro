<?php 
 session_start();
 session_destroy();
 unset($_SESSION['firstname']);
 unset($_SESSION['lastname']);
 unset($_SESSION['email']);
 unset($_SESSION['password']);
 header("location:home.php") ;

?>