<?php  
//Connect to database
include_once("./database/config.php");
date_default_timezone_set('Asia/Dhaka');

$class_id = $_GET['class_id'];

$d = date("Y-m-d");

$sql = "SELECT * FROM class_attendance where att_date = '$d' and class_id = '$class_id'";
$result = mysqli_query($conn, $sql);
if($result){
    while($row=mysqli_fetch_assoc($result)){
        $student_id=$row['student_id'];

            $sql3 = "SELECT * FROM students where student_id = $student_id";
            $result3 = mysqli_query($conn, $sql3);
            $row=mysqli_fetch_assoc($result3);

            $stu_uni_id=$row['stu_uni_id'];
            $student_img=$row['student_img'];
            $firstname=$row['firstname'];
            $lastname=$row['lastname'];
            $email=$row['email'];
            $gender=$row['gender'];
            $birthday=$row['birthday'];
            $contact=$row['contact'];
            $card_uid=$row['card_uid'];
            $address=$row['address']." ".$row['city']." ".$row['zip'];
    
            echo '<tr style="vertical-align:middle;">
                      <td>'.$stu_uni_id.'</td>
                      <td><img src="img/students/'.$student_img.'" style="width:80px; height:80px; object-fit:cover;" alt="profile"></td>
                      <td>'.$firstname.' '.$lastname.'</td>
                      <td>'.$gender.'</td>
                      <td>'.$birthday.'</td>
                      <td>'.$email.'</td>
                      <td>'.$contact.'</td>
                      <td>'.$address.'</td>
                      <td>'.$card_uid.'</td>
                  </tr>';
    
    }
}