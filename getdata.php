<?php  
//Connect to database
include_once("./database/config.php");
date_default_timezone_set('Asia/Dhaka');

$d = date("Y-m-d");
$t = date("H:i:sa");

if (isset($_GET['card_uid']) && isset($_GET['device_token'])) {

    $card_uid = $_GET['card_uid'];
    $device_uid = $_GET['device_token'];

    if($device_uid == "db100d76df7717dc"){
        $query = "SELECT * FROM students WHERE card_uid = '$card_uid'";
        $query_run = mysqli_query($conn, $query);
        if (!$query_run->num_rows > 0) {
            $query2 = "INSERT INTO students(card_uid) VALUES ('$card_uid')";
            $query_run2 = mysqli_query($conn, $query2);
        }
    }
    else{
        $query0 = "SELECT * FROM devices WHERE device_uid = '$device_uid'";
        $query_run0 = mysqli_query($conn, $query0);
        $row0=mysqli_fetch_assoc($query_run0);

        $device_id=$row0['device_id'];

        $query2 = "SELECT * FROM class WHERE device_id = '$device_id'";
        $query_run2 = mysqli_query($conn, $query2);
        $row2=mysqli_fetch_assoc($query_run2);

        $status=$row2['status'];
        $class_id=$row2['class_id'];

        if($status == "1"){
            $query3 = "SELECT * FROM students WHERE card_uid = '$card_uid'";
            $query_run3 = mysqli_query($conn, $query3);
            $row3=mysqli_fetch_assoc($query_run3);
    
            $student_id=$row3['student_id'];

            $query4 = "SELECT * FROM class_students WHERE student_id = '$student_id' AND class_id = '$class_id'";
            $query_run4 = mysqli_query($conn, $query4);
            if ($query_run4->num_rows > 0) {

                $query6 = "SELECT * FROM class_attendance WHERE student_id = '$student_id' AND class_id = '$class_id' AND device_id = '$device_id' AND att_date = '$d'";
                $query_run6 = mysqli_query($conn, $query6);
                if (!$query_run6->num_rows > 0) {

                    $query5 = "INSERT INTO class_attendance(class_id, student_id, device_id, card_uid, device_uid, att_date, att_time) 
                    VALUES ('$class_id','$student_id','$device_id','$card_uid','$device_uid','$d','$t')";
                    $query_run5 = mysqli_query($conn, $query5);
                }
            }
        }

    }

}