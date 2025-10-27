<?php
session_start();
require 'conexionbd.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $message = $_POST['message'];
    $name = $_POST['fullname'];

    if (empty($email) || empty($subject) || empty($date) || empty($message) || empty($name)) {
        header("location:contactus.php?msg=All fields are required.&type=danger");
        exit();
    }
 //create an anstence  phpmailer
    $mail = new PHPMailer(true);
    //phpmailer use the smtp (simple mail transform protocol)
   
    $mail->isSMTP();
     //specify the smtp server 
    $mail->Host = 'smtp.gmail.com';
    //This line enables SMTP authentication, which requires a username and password to connect to the mail server.
    $mail->SMTPAuth = true;

    $mail->Username = 'benmbarkamontaha2@gmail.com';
    $mail->Password = 'frgv fbsz jlqt iarh';
    //This line configures the type of encryption to use with the SMTP connection.
    $mail->SMTPSecure = 'ssl';

    $mail->Port = 465;
    $mail->addAddress($_POST["email"]);
    //This line specifies that the email body will be sent in HTML format.
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['message'];

    try {
        $mail->send();
        $contactadd = $db->prepare("INSERT INTO message(email,subject, message,date,fullname) VALUES (?,?,?,?,?)");
        $contactadd->execute([$email, $subject, $message, $date, $name]);
        $_SESSION['email_sent_success'] = true;
        header("location:contactus.php");
        exit();
    } catch (Exception $e) {
        header("location:contactus.php?msg=Message could not be sent. Please try again later.&type=danger");
        exit();
    }
}

$pagename = "contactus";
$template = "contactus";
include "layouthome.phtml";
?>
