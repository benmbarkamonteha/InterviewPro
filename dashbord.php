<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location:login.php');
    exit();
}
$pagename="Admin Dashbord";
include 'conexionbd.php';
$template="dashbord";
include"layoutadmin.phtml";

?>