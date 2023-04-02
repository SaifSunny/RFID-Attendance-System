<?php
include './database/config.php';

$prog_id = $_GET['prog_id'];

$query = "DELETE FROM program WHERE prog_id='$prog_id'";
$query_run = mysqli_query($conn, $query);
    if ($query_run) {
      echo "<script> 
      alert('Program has been DELETED.');
      window.location.href='admin_programs.php';
      </script>";
      
    } else {
      echo "<script>alert('Cannot Delete Program');
      window.location.href='admin_programs.php';
      </script>";
    }
?>
