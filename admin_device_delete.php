<?php
include './database/config.php';

$device_id = $_GET['device_id'];

$query = "DELETE FROM devices WHERE device_id='$device_id'";
$query_run = mysqli_query($conn, $query);
    if ($query_run) {
      echo "<script> 
      alert('Device has been DELETED.');
      window.location.href='admin_devices.php';
      </script>";
      
    } else {
      echo "<script>alert('Cannot Delete Device');
      window.location.href='admin_devices.php';
      </script>";
    }
?>
