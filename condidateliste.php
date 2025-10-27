<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:loginadmin.php');
    exit();
}
require 'conexionbd.php';

$query = $db->prepare("SELECT c.*,j.name as job_name,p.id as postulation_id,p.state as postulation_state,
                        p.email as condidate_email
                      FROM candidat c
                      JOIN postulation p ON c.id = p.candidat
                      JOIN job j ON j.id = p.job
                      ");
$query->execute();
$condidates = $query->fetchAll();
$pagename="condidateliste";
$template = "condidateliste";
include 'layoutadmin.phtml';
?>
