<?php
session_start();
require 'conexionbd.php';
$query = $db->prepare("SELECT * FROM  job");
$query->execute();
$jobs=$query->fetchAll();
$pagename="joboffers";
$template="index";
include 'layouthome.phtml';

?>
