
<?php
session_start();
require 'conexionbd.php';
$template="search";
$pagename="search";
include 'layout.phtml';
try {
  if (isset($_POST['submit'])) {
    if (!empty($_POST['submit'])) {

      //strip tags :to remove any HTML tags from these values 
      $search = strip_tags($_POST['search']); 
      if (empty($search)){
        header("location:index.php?msg=filed is  required.&type=danger");
      }
     
      $count=0;
      $stmt = $db->prepare("SELECT name, id,createdat FROM job WHERE name ILIKE ?");
      $stmt->execute(['%' . $search . '%']); // Use prepared statement with placeholder
      echo '<div class="container px-5 py-5">';
      echo'<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <h3 class="title px-3 py-3"style="text-align:center;"><i class="bi bi-search"></i> The result of your search :</h3>';
      echo '</div>';
      //fetch the row of the data of the table as an object
      while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        echo '<div class="container px-2 py-2">';
        echo '<br>';
        echo '<div class="row">';
        echo '<div class="col-md-4">';
        echo '<div class="card" style="width: 18rem;">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row->name . '</h5>';
        echo '<h5 class="card-title">' . $row->createdat . '</h5>';
        echo '<a class="btn btn-primary" href="jobdetails.php?id=' . $row->id . '" role="button"><i class="bi bi-info-circle-fill"></i>Details</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        $count++;
      }
      echo '<p class="count" style="margin-left:600px;margin-top:400px;font-weight: bold; color :3498DB">' . $count . ' job offer(s) found</p>'; // Display the count 

    }else {
      echo'<h3 class="title px-3 py-3"style="text-align:center;"><i class="bi bi-search"></i> The result of your search :job is not exist</h3>';
    }
  }
} catch (PDOException $e) {
  // Display error message for debugging
  echo 'Error: ' . $e->getMessage();
}


?>