<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:loginadmin.php');
    exit();
}

require 'conexionbd.php';

if (isset($_POST['submit'])) {
    $nom = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $jobrequirment = $_POST['jobrequirment'];
    $levelofstudy = $_POST['levelofstudy'];
    $date = $_POST['date'];

    if (empty($nom) || empty($description) || empty($levelofstudy) || empty($jobrequirment) || empty($location) || empty($date)) {
        header("location:addjob.php?msg=All Field Are Required");
    } else {
        $offrexiste = $db->prepare("SELECT name, description FROM job WHERE name = :nom OR description = :description");
        $offrexiste->execute(['nom' => $nom, 'description' => $description]);

        if ($offrexiste->rowCount() > 0) {
            header("location:addjob.php?msg=Offer Already Exists&type=danger");
            exit();
        } else {
            // Condition on the date: the admin cannot set an old date
            $createdDate = new DateTime($date);
            $currentDate = new DateTime();
            $dayDiff = $currentDate->diff($createdDate)->days;

            if ($dayDiff < 0) {
                header("location:addjob.php?msg=Invalid Date");
                exit();
            }

            $jobAdded = $db->prepare("INSERT INTO job(name, description, location, createdat, level, jobrequirement) VALUES (?, ?, ?, ?, ?, ?)");
            $jobAdded->execute([$nom, $description, $location, $date, $levelofstudy, $jobrequirment]);

            $_SESSION['status'] = "Job added successfully";
            $_SESSION['status_code'] = "success";
            header("location:jobtable.php");
            exit();
        }
    }
}

$pagename = "addjob";
$template = "addjob";
include "layoutadmin.phtml";
?>
