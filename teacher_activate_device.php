<?php
include './database/config.php';

$class_id = $_GET['class_id'];

$query = "UPDATE class SET `status`='1' WHERE `class_id`='$class_id'";
$query_run = mysqli_query($conn, $query);
    if ($query_run) {
      echo "<script> 
      alert('Device Activated');
      window.location.href='teacher_student_attendance.php?class_id=$class_id';
      </script>";
      
    } else {
      echo "<script>
      alert('Cannot Activate Device');
      window.location.href='teacher_course_details.php?class_id=$class_id';
      </script>";
    }
?>