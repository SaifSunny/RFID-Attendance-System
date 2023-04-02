<?php
include './database/config.php';

$course_id = $_GET['course_id'];

$query = "DELETE FROM courses WHERE course_id='$course_id'";
$query_run = mysqli_query($conn, $query);
    if ($query_run) {
      echo "<script> 
      alert('Course has been DELETED.');
      window.location.href='admin_courses.php';
      </script>";
      
    } else {
      echo "<script>alert('Cannot Delete Course');
      window.location.href='admin_courses.php';
      </script>";
    }
?>
