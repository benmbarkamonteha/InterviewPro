<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location:loginadmin.php');
    exit();
}
require 'conexionbd.php';
$query = $db->prepare("SELECT * FROM  postulation");
$query->execute();
$postulations=$query->fetchAll();

$template="postulationtable";
include 'layoutadmin.phtml';
?>