<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: loginadmin.php');
    exit();
}

require 'conexionbd.php';

$currentJob = array_key_exists("id", $_GET) ? intval($_GET['id']) : intval($_POST['id']);

$p = $db->prepare("SELECT id, name, description, location, createdat, level, jobrequirement FROM job WHERE id = ?");
$p->execute([$currentJob]);
$jobData = $p->fetch();
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $jobrequirement = $_POST['jobrequirement'];
    $levelofstudy = $_POST['levelofstudy'];
    $date = $_POST['date'];

    $pg = $db->prepare("UPDATE job SET name = ?, description = ?, location = ?, createdat = ?, level = ?, jobrequirement = ? WHERE id = ?");
    $pg->execute([$name, $description, $location, $date, $levelofstudy, $jobrequirement, $currentJob]);

    $_SESSION['status'] = "Job updated successfully";
    $_SESSION['status_code'] = "success";
    header('location: jobtable.php');
    exit();
}
$pagename="updatejob";
$template = "updatejob";
include "layoutadmin.phtml";
?>
