<?php
include './database/config.php';

$dep_id = $_GET['dep_id'];

$query = "DELETE FROM departments WHERE dep_id='$dep_id'";
$query_run = mysqli_query($conn, $query);
    if ($query_run) {
      echo "<script> 
      alert('Department has been DELETED.');
      window.location.href='admin_departments.php';
      </script>";
      
    } else {
      echo "<script>alert('Cannot Delete Department');
      window.location.href='admin_departments.php';
      </script>";
    }
?>
