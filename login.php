
<?php
session_start();
require 'conexionbd.php';
 if(isset($_POST['submit'])){
    extract($_POST);
    if(empty($email) && empty($password)){
        header("location:login.php?msg=all field required&type=danger");
    }else if(empty($email)){
        header("location:login.php?msg=email is required&type=danger");
    }
    else if(empty($password)){
        header("location:login.php?msg=password is required&type=danger");
    }else{
        $query=$db->prepare("SELECT * from candidat where email=:email");
        $query->execute(['email'=>$email]);
        $user=$query->fetch(PDO::FETCH_ASSOC);
        if($user){
            if(!password_verify($password,$user['password'])){
                header("location:login.php?msg=password or email is incorrect&type=danger");
            }else{
                $_SESSION['id']=$user['id'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username']=$user['username'];
                $_SESSION['password']=$user['password'];
                header('Location: applyment.php');
                exit();

            }
        } else{
            header("location:login.php?msg=Please create an account &type=danger");
        }   
       
    }
    
 }
 $pagename="login";
 $template = "login";
 include "layout.phtml";

?>


