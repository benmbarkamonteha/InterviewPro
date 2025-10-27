<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location:loginadmin.php');
    exit();
}
require 'conexionbd.php';
$query = $db->prepare("SELECT * FROM  job");
$query->execute();

$jobs=$query->fetchAll();
$pagename="jobliste";
$template="jobtable";
include 'layoutadmin.phtml';
?>