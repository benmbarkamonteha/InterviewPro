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
    // Input validation
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirmedpassword)||empty($username)) {
        header("location:signupadmin.php?msg=Please fill in all fields.&type=danger");
        exit(); // Prevent further execution
    } elseif ($password !== $confirmedpassword) {
        header("location:signupadmin.php?msg=Passwords do not match.&type=danger");
        exit();
    } else {
         $usernamecheck=$db->prepare("SELECT username from admin where username=:username");
         $usernamecheck->bindParam(':username', $username);
         $usernamecheck->execute();

         $resultusername = $usernamecheck->fetch(PDO::FETCH_ASSOC);
         $email_check = $db->prepare("SELECT email from admin where email =:email");
         //binParm bind a parameter to a variable
         $email_check->bindParam(':email', $email);
         $email_check->execute();
        //fetch for the row 
         $result = $email_check->fetch(PDO::FETCH_ASSOC);

         if ((!$result) && (!$resultusername)){
        // Password hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Prepared statement with parameterized input
            $adminadded = $db->prepare("INSERT INTO admin (firstname, lastname, email, password,username) VALUES (?, ?, ?, ?,?)");
            $adminadded->execute(
                [$firstname,$lastname,$email,$hashedPassword,$username]);
                header('Location: loginadmin.php');
                $_SESSION['status']="Account created successfully";

            exit();
        }
        else{

            header("location:signupadmin.php?msg=  Email or Username Already Exist.&type=danger");
    
    
          }}
}
$template = "signupadmin";
$pagename="signupadmin";
include "layout.phtml";
?>
