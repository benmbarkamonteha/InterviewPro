<?php
session_start();
require 'conexionbd.php';

if (!isset($_SESSION['id'])) {
    header('location:loginadmin.php');
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
$email = isset($_GET['email']) ? $_GET['email'] : '';


if (isset($_POST["submit"])) {
    $mail = new PHPMailer(true);

    // Configure SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'benmbarkamontaha2@gmail.com';
    $mail->Password = 'frgv fbsz jlqt iarh';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Set sender and recipient
    $mail->setFrom('benmbarkamontaha2@gmail.com');
    $mail->addAddress($_POST["to"]);
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['message'];
        $mail->send();
        header("location:dashboard.php");
}
$pagename="Email";
$template = "email";
include 'layoutadmin.phtml';
?>
