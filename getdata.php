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
        
    }

}