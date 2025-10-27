<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location:loginadmin.php');
    exit();
}
require 'conexionbd.php';
$query = $db->prepare("SELECT * FROM  message");
$query->execute();
$boxs=$query->fetchAll();
$pagename="emailbox";
$template="inbox";
include 'layoutadmin.phtml';
?>