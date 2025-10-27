<?php 
    session_start();
    require "conexionbd.php";
    $id=$_GET['id'];
    $res=$db->prepare("DELETE from job where id=?");
    $res->execute([
        $id
    ]);

    $_SESSION['status'] = "Job Deleted successfully";
     $_SESSION['status_code'] = "success";
        header('location: jobtable.php');
        exit();
?>