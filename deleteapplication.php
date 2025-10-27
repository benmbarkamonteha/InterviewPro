<?php 
   session_start();
    require "conexionbd.php";
    $id=$_GET['id'];
    $res=$db->prepare("DELETE from postulation where id=?");
    $res->execute([
        $id
    ]);

    $_SESSION['status'] = "Application  Deleted successfully";
    $_SESSION['status_code'] = "success";
       header('location: condidateliste.php');
       exit();

?>