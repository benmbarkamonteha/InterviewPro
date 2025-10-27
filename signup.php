<?php
session_start();
require 'conexionbd.php';

if (isset($_POST['signup'])) {
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmedpassword = $_POST['confirm_password'];
    $username=$_POST['username'];
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirmedpassword)||empty($username)) {
         header("location:signup.php?msg=All filed are required.&type=danger");
         exit(); // Prevent further execution
    } elseif ($password !== $confirmedpassword) {
         header("location:signup.php?msg=Passwords do not match.&type=danger");
         exit();
    } else {
          $usernamecheck=$db->prepare("SELECT username from candidat where username=:username");
          $usernamecheck->bindParam(':username', $username);
          $usernamecheck->execute();
          $resultusername = $usernamecheck->fetch(PDO::FETCH_ASSOC);
          $email_check = $db->prepare("SELECT email from candidat where email =:email");
        //binParm bind a parameter to a variable
         $email_check->bindParam(':email', $email);
         $email_check->execute();
        //fetch for the row 
         $result = $email_check->fetch(PDO::FETCH_ASSOC);
        if ((!$result )&&(!$resultusername)){
        // Password hashing
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $condidateadded = $db->prepare("INSERT INTO candidat (firstname, lastname, email, password,username) VALUES (?, ?, ?, ?,?)");
            $condidateadded->execute(
                [$firstname,$lastname,$email,$hashedPassword,$username]);
               header('Location: login.php');
               $_SESSION['status']="Account created successfully";
            exit();
        }
      else{

        header("location:signup.php?msg=  Email  or Username Already Exist.&type=danger");


      }
    }
}
$template = "signup";
$pagename="signup";
include "layout.phtml";
?>
