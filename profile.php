<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
    exit();
}

$currentCandidateId = $_SESSION['id'];
require 'conexionbd.php';

$query = $db->prepare("SELECT * FROM candidat WHERE id = ?");
$query->execute([$currentCandidateId]);
$applications = $query->fetch();

if (isset($_POST['update'])) {
    $level = $_POST['level'];
    $experience = $_POST['experience'];
    $telnum = $_POST['telnum'];
    $target_dir = "C:/xampp/htdocs/files/";
    $uploadOk = 1;

    // File upload handling
    if (!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
        echo "Please choose a file to upload.";
        $uploadOk = 0;
    } else {
        $target_file = $target_dir . basename($_FILES['file']['name']);
        if ($uploadOk == 0) {
            header("location:profile.php?msg=Sorry, your file was not uploaded.&type=danger");

        } else {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                echo "The file " . basename($_FILES['file']['name']) . " has been uploaded.";
                $uploadOk = 1;
            } else {
                header("location:profile.php?msg=Sorry, there was an error uploading your file.&type=danger");
            }
        }
    }

    if ($uploadOk == 0 || empty($level) || empty($experience) || empty($telnum)) {
        header("location:profile.php?msg=Please fill in all fields.&type=danger");
        exit();
    } else {
        // Update candidate data
        $update = "UPDATE candidat SET experience = ?, level = ?, cv = ?, telephonenumber = ? WHERE id = ?";
        $p = $db->prepare($update);
        $p->execute([$experience, $level, $target_file, $telnum, $currentCandidateId]);
        header("location:profile.php?msg=Information updated successfully.&type=success");
        exit();
    }
}

$pagename = "profile";
$template = "profile";
include "layout.phtml";
?>
