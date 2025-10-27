<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location:loginadmin.php');
    exit();
}
require 'conexionbd.php';
$currentState = array_key_exists("id", $_GET) ? intval($_GET['id']) : intval($_POST['id']);

$p = $db->prepare("SELECT id, state FROM postulation WHERE id = ?");
$p->execute([$currentState]);
$stateData = $p->fetch();
if (isset($_POST['updatestate'])) {
    $state = $_POST['state'];
   

    if (empty($state)) {
        header("location: postulationtable.php?id=$currentState&msg= The state filed is required");
        exit();
    }

    $pg = $db->prepare("UPDATE postulation SET state = ? WHERE id = ?");
    $pg->execute([$state, $currentState]);
    $_SESSION['status']="state updated successfully";
    $_SESSION['status_code']="success";
    header('location: condidateliste.php');
    exit();
}
$template='updatestate';
include 'layoutadmin.phtml';

?>