
<?php
session_start();
require 'conexionbd.php';
 if(isset($_POST['submit'])){
    extract($_POST);
    if(empty($email) || empty($password)){
        header("location:loginadmin.php?msg=all field required&type=danger");
   }
   else{
        $query=$db->prepare("SELECT * from admin where email=:email");
        $query->execute(['email'=>$email]);
        $user=$query->fetch(PDO::FETCH_ASSOC);
        if($user){
            if(!password_verify($password,$user['password'])){
                header("location:loginadmin.php?msg=password or email is incorrect&type=danger");
            }else{
                $_SESSION['id']=$user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['password']=$user['password'];
                header('Location: dashbord.php');
                exit();

            }
        } else{
            header("location:loginadmin.php?msg=Please create an account &type=danger");
        }   
       
    }
    
 }
 $pagename="loginadmin";
 $template = "loginadmin";
 include "layout.phtml";

?>


