<?php
include './database/config.php';

$teacher_id = $_GET['teacher_id'];

$query = "DELETE FROM teachers WHERE teacher_id='$teacher_id'";
$query_run = mysqli_query($conn, $query);
    if ($query_run) {
      echo "<script> 
      alert('Teacher has been DELETED.');
      window.location.href='admin_teachers.php';
      </script>";
      
    } else {
      echo "<script>alert('Cannot Delete Teacher');
      window.location.href='admin_teachers.php';
      </script>";
    }
?>
