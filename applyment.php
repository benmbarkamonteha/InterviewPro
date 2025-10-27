<?php
session_start();
require 'conexionbd.php';
if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
}

$currentCandidateId = $_SESSION['id'];

// Fetch candidate data
$p = $db->prepare("SELECT experience, level, cv, telephonenumber FROM candidat WHERE id = ?");
$p->execute([$currentCandidateId]);
$candidateData = $p->fetch();

if (isset($_POST['apply'])) {
    $level = $_POST['level'];
    $experience = $_POST['experience'];
    $telnum = $_POST['telnum'];
    $target_dir = "C:/xampp/htdocs/files/";
    $uploadOk = 1;

    // File upload handling
    if (!isset($_FILES['fileCv']) || !is_uploaded_file($_FILES['fileCv']['tmp_name'])) {
        echo "Please choose a file to upload.";
        $uploadOk = 0;
    } else {
        $target_file = $target_dir . basename($_FILES['fileCv']['name']);

        // Check file type and size before moving
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = ['pdf'];
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        if (!in_array($fileType, $allowedTypes) || $_FILES['fileCv']['size'] > $maxFileSize) {
            echo "Invalid file type or size. Allowed types: " . implode(', ', $allowedTypes) . ", Max file size: 5MB";
            $uploadOk = 0;
        } elseif ($uploadOk == 1 && move_uploaded_file($_FILES['fileCv']['tmp_name'], $target_file)) {
            echo "The file " . basename($_FILES['fileCv']['name']) . " has been uploaded.";
            $uploadOk = 1;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    if ($uploadOk == 0 || empty($level) || empty($experience) || empty($telnum)) {
        header("location: applyment.php?msg=Please fill in all fields.&type=danger");
        exit();
    } else {
        // Check if the candidate already applied for the job
        $jobId = isset($_SESSION['jobId']) ? $_SESSION['jobId'] : null;
        $candidatecheck = $db->prepare("SELECT * FROM postulation WHERE job = :jobId AND candidat = :currentCandidateId");
        $candidatecheck->execute(['jobId' => $jobId, 'currentCandidateId' => $currentCandidateId]);

        if ($candidatecheck->rowCount() > 0) {
            header("location: applyment.php?msg=You already applied for this job&type=danger");
            exit();}
            else{
            // Insert the email of the candidate into a variable to add to the table
            $currentEmail = $_SESSION['email'];
            $postulationData = "INSERT INTO postulation (job,  candidat , email, state) VALUES (:jobId, :currentCandidateId, :currentEmail, 'applied')";
            $stmt = $db->prepare($postulationData);
            $stmt->bindParam(':jobId', $jobId);
            $stmt->bindParam(':currentCandidateId', $currentCandidateId);
            $stmt->bindParam(':currentEmail', $currentEmail);
            $stmt->execute(); }


        // Update candidate table
        $data = "UPDATE  candidat  SET experience = :experience, level = :level, cv = :target_file, telephonenumber = :telnum WHERE id = :currentCandidateId";
        $pg = $db->prepare($data);
        $pg->bindParam(':experience', $experience);
        $pg->bindParam(':level', $level);
        $pg->bindParam(':target_file', $target_file);
        $pg->bindParam(':telnum', $telnum);
        $pg->bindParam(':currentCandidateId', $currentCandidateId);
        $pg->execute();

        $_SESSION['status'] = "Applied successfully";
        $_SESSION['status_code'] = "success";
        header('location: index.php');
        exit();
    }
}

$pagename = "applyment";
$template = "applyment";
require "layout.phtml";
?>
