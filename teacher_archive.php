<?php
include './database/config.php';

$class_id = $_GET['class_id'];

$query = "UPDATE class SET `archieved`='1' WHERE `class_id`='$class_id'";
$query_run = mysqli_query($conn, $query);
    if ($query_run) {
      echo "<script> 
      alert('Course Archieved');
      window.location.href='teacher_archieved.php?class_id=$class_id';
      </script>";
      
    } else {
      echo "<script>
      alert('Cannot Archieved Course');
      window.location.href='teacher_archieved.php?class_id=$class_id';
      </script>";
    }
?>