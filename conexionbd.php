<?php
$host = "localhost";
$port = "5432";
$dbname = "mms"; 
$user = "postgres";
$password = "monta123";
$dsn = "pgsql:host=$host;dbname=$dbname;user=$user;password=$password";

try {
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $jobs = $db->prepare('SELECT COUNT(*) FROM job');
    $jobs->execute();
    $row = $jobs->fetch(PDO::FETCH_ASSOC);
    $jobCount = $row['count'];
    $candidates = $db->prepare('SELECT COUNT(*) FROM candidat');
    $candidates->execute();
    $row = $candidates->fetch(PDO::FETCH_ASSOC);
    $candidateCount = $row['count'];
    $inbox= $db->prepare('SELECT COUNT(*) FROM message');
    $inbox->execute();
    $row = $inbox->fetch(PDO::FETCH_ASSOC);
    $inboxCount = $row['count'];
  } catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
  }
?>






