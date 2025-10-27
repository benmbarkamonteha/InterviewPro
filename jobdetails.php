<?php
session_start();
require 'conexionbd.php';
// Check for valid 
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid job ID");
}
// Prepare and execute query with parameterized input
$query = $db->prepare('SELECT * FROM job WHERE id = :id');
$query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$query->execute();
    $jobdetail = $query->fetch(PDO::FETCH_ASSOC);
    $_SESSION['jobId']= $jobdetail['id'];
    $pagename = "jobdetails";
    $template = 'jobdetails';
    include 'layouthome.phtml';
   
?>
