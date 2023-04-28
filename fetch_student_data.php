<?php  
//Connect to database
include_once("./database/config.php");
date_default_timezone_set('Asia/Dhaka');

$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);
if($result){
    while($row=mysqli_fetch_assoc($result)){
        $student_id=$row['student_id'];
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
                  <td style="font-size:14px; font-weight:600;">
                      <a href="admin_student_update.php?student_id='.$student_id.'" style="border-radius: 10px; padding:12px 14px; font-size:10px; font-weight:600" class="btn btn-success">
                          <i class="fa fa-edit" style="font-size:14px"></i>
                      </a>
                      <a href="admin_student_delete.php?student_id='.$student_id.'" style="border-radius: 10px; padding:12px 14px; font-size:10px; font-weight:600" class="btn btn-danger">
                          <i class="fa fa-trash" style="font-size:14px"></i>
                      </a>
                  </td>
              </tr>';
    }
}