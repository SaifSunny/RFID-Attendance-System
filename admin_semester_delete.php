<?php
include './database/config.php';

$sem_id = $_GET['sem_id'];

$query = "DELETE FROM semester WHERE sem_id='$sem_id'";
$query_run = mysqli_query($conn, $query);
    if ($query_run) {
      echo "<script> 
      alert('Semester has been DELETED.');
      window.location.href='admin_home.php';
      </script>";
      
    } else {
      echo "<script>alert('Cannot Delete Semester');
      window.location.href='admin_home.php';
      </script>";
    }
?>
