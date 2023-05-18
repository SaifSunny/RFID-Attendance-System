<?php
include_once("./database/config.php");

session_start();

$username = $_SESSION['adminname'];

if (!isset($_SESSION['adminname'])) {
    header("Location: admin_login.php");
}

$sql = "SELECT * FROM admin WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$admin_img=$row['admin_img'];

$_SESSION['admin_img'] = $admin_img;
$_SESSION['admin_id'] = $row['admin_id'];
$_SESSION['username'] = $row['username'];

if (isset($_POST['submit'])) {
    
    $course_id = $_POST['course_id'];
    $semester_id = $_POST['semester_id'];
    $teacher_id = $_POST['teacher_id'];
    $device_id = $_POST['device_id'];

    $section = $_POST['section'];
    $room = $_POST['room'];
    $schedule_day = $_POST['schedule_day'];
    $schedule_time = $_POST['schedule_time'];
    $start_date = $_POST['start_date'];

    $date=date("d F Y");

    $query = "SELECT * FROM class WHERE `teacher_id` = '$teacher_id' and `schedule_day` = '$schedule_day' and `schedule_time` = '$schedule_time' and semester_id='$semester_id'";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run->num_rows > 0) {
        $query = "SELECT * FROM class WHERE `room_no` = '$room' and `schedule_day` = '$schedule_day' and `schedule_time` = '$schedule_time' and semester_id='$semester_id'";
        $query_run = mysqli_query($conn, $query);
    
        if (!$query_run->num_rows > 0) {
            $query = "SELECT * FROM class WHERE `device_id` = '$device_id' and semester_id='$semester_id' AND `schedule_day` = '$schedule_day' and `schedule_time` = '$schedule_time' ";
            $query_run = mysqli_query($conn, $query);
        
            if (!$query_run->num_rows > 0) {
                $query = "SELECT * FROM class WHERE `course_id` = '$course_id' and `section` = '$section' and semester_id='$semester_id'";
                $query_run = mysqli_query($conn, $query);
            
                if (!$query_run->num_rows > 0) {
                    $query2 = "INSERT INTO class(course_id, device_id, teacher_id, semester_id, section, room_no, `start_date`, `schedule_day`, `schedule_time`)
                    VALUES ('$course_id','$device_id','$teacher_id','$semester_id','$section','$room','$start_date','$schedule_day','$schedule_time')";
                    $query_run2 = mysqli_query($conn, $query2);
                    if ($query_run2) {
                        $cls="success";
                        $error = 'Class Successfully ADDED.';
                        
                    } else {
                        $cls="danger";
                        $error = mysqli_error($conn);
                        
                    }
                } else {
                    $cls="danger";
                    $error = 'Course Already Exist';        
                }
            } else {
                $cls="danger";
                $error = 'Device Not Avalable';        
            }
            
        } else {
            $cls="danger";
            $error = 'Room Not Avalable';        
        }
    } else {
        $cls="danger";
        $error = 'Teacher Not Avalable';        
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RFID Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sidebars.css">

</head>

<body>


    <section class="d-flex">
        <div class="header d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none"
                style="padding:5px 30px;font-family: 'rubik'; font-size:22px; font-weight:600; padding-top:20px">
                RFID Attendance
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="admin_home.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-house" style="padding-right:16px;"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="admin_departments.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-building-ngo" style="padding-right:22px;"></i>
                        Manage Departments
                    </a>
                </li>
                <li>
                    <a href="admin_programs.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-certificate" style="padding-right:18px;"></i>
                        Manage Programs
                    </a>
                </li>
                <li>
                    <a href="admin_courses.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-book" style="padding-right:18px;"></i>
                        Manage Courses
                    </a>
                </li>

                <li>
                    <a href="admin_teachers.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-user-tie" style="padding-right:18px;"></i>
                        Manage Faculty
                    </a>
                </li>
                <li>
                    <a href="admin_devices.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-computer" style="padding-right:12px;"></i>
                        Manage Devices
                    </a>
                </li>
                <li>
                    <a href="admin_classes.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
                        <i class="fa-solid fa-hourglass-half" style="padding-right:18px;"></i>
                        Manage Classes
                    </a>
                </li>
                <li>
                    <a href="admin_students.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-users" style="padding-right:10px;"></i>
                        Manage Students
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="img/admin/<?php echo $admin_img?>" alt="" width="40" height="40"
                        class="rounded-circle me-2">
                    <strong><?php echo $username?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1"
                    style="width:200px;padding:10px;">
                    <li><a class="dropdown-item" href="admin_profile.php">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>

        <div class="main">
            <div class="row">
                <div class="col-md-10" style="padding-bottom:0px;">
                    <h2 style="font-weight:600">Manage Classes</h2>
                    <p><a href="admin_home.php">Dashboard</a> / Classes</p>
                </div>
                <div class="col-md-2" style="margin-top:20px">
                    <div class="d-flex justify-content-end">
                        <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            style="margin-left:20px">Add Class</a>
                    </div>

                </div>
            </div>

            <div class="alert alert-<?php echo $cls;?>">
                <?php 
                    if (isset($_POST['submit'])){
                        echo $error;
                    }
                ?>
            </div>
            <div class="row" style="margin-bottom:0px;">
                <div class="col-md-12">
                    <div style="text-align:center;padding:0px 0px; height:500px;">

                        <div style="padding:20px; text-align:center;font-size:18px;">
                            <table class="table" style="font-size: 14px;color:#222;">
                                <thead>
                                    <th>sl</th>
                                    <th>Course Name</th>
                                    <th>Course Code</th>
                                    <th>Section</th>
                                    <th>Room No.</th>
                                    <th>Schedule</th>
                                    <th>Assigned Teacher</th>
                                    <th>Semester</th>
                                    <th>Device UID</th>
                                    <th>Action</th>
                                </thead>

                                <tbody style="font-size:18px">
                                    <?php 
                                            $sl=0;
                                            $sql = "SELECT * FROM class";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $class_id=$row['class_id'];
                                                    $device_id=$row['device_id'];
                                                    $semester_id=$row['semester_id'];
                                                    $course_id=$row['course_id'];
                                                    $teacher_id=$row['teacher_id'];
                                                    $section=$row['section'];
                                                    $room_no=$row['room_no'];
                                                    $schedule_day=$row['schedule_day'];
                                                    $schedule_time=$row['schedule_time'];
       
                                                    $sql1 = "SELECT * FROM courses where course_id = $course_id";
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    $row1=mysqli_fetch_assoc($result1);
                                                    $course_name = $row1['course_name'];
                                                    $course_code = $row1['course_code'];

                                                    $sql2 = "SELECT * FROM semester where sem_id = $semester_id";
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    $row2=mysqli_fetch_assoc($result2);
                                                    $sem_code = $row2['sem_code'];

                                                    $sql3 = "SELECT * FROM teachers where teacher_id = $teacher_id";
                                                    $result3 = mysqli_query($conn, $sql3);
                                                    $row3=mysqli_fetch_assoc($result3);
                                                    $teacher_name = $row3['firstname']." ".$row3['lastname'];


                                                    $sql4 = "SELECT * FROM devices where device_id = $device_id";
                                                    $result4 = mysqli_query($conn, $sql4);
                                                    $row4=mysqli_fetch_assoc($result4);
                                                    $device_uid = $row4['device_uid'];
                                                    $sl++;
                                        ?>
                                    <tr style="vertical-align:middle;">
                                        <td><?php echo $sl?></td>
                                        <td><?php echo $course_name ?></td>
                                        <td><?php echo $course_code ?></td>
                                        <td><?php echo $section ?></td>
                                        <td><?php echo $room_no ?></td>
                                        <td><?php echo $schedule_day." - ". $schedule_time ?></td>
                                        <td><?php echo $teacher_name ?></td>
                                        <td><?php echo $sem_code ?></td>

                                        <td style="font-size:15px;font-weight:600"><?php echo $device_uid ?></td>

                                        <td style="font-size:14px; font-weight:600;"><a
                                                href="admin_class_delete.php?class_id=<?php echo $class_id?>"
                                                style="border-radius: 10px; padding:12px 14px; font-size:10px; font-weight:600"
                                                class="btn btn-danger"><i class="fa fa-trash"
                                                    style="font-size:14px"></i></a></td>
                                    </tr>
                                    <?php 
                                                }
                                            }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add faculty device Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Class</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Semester</label>
                                        <select class="form-control" id="semester_id" name="semester_id" required>
                                            <option value="">-- Select Semester --</option>
                                            <?php
                                                $br_option = "SELECT * FROM semester";
                                                $br_option_run = mysqli_query($conn, $br_option);

                                                if (mysqli_num_rows($br_option_run) > 0) {
                                                    foreach ($br_option_run as $row2) {
                                            ?>
                                            <option value="<?php echo $row2['sem_id']; ?>">
                                                <?php echo $row2['sem_code']?> </option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Device</label>
                                        <select class="form-control" id="device_id" name="device_id" required>
                                            <option value="">-- Select Device --</option>
                                            <?php
                                                $br_option = "SELECT * FROM devices";
                                                $br_option_run = mysqli_query($conn, $br_option);

                                                if (mysqli_num_rows($br_option_run) > 0) {
                                                    foreach ($br_option_run as $row2) {
                                            ?>
                                            <option value="<?php echo $row2['device_id']; ?>">
                                                <?php echo $row2['device_name']." ( ".$row2['device_uid']." )"?>
                                            </option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Teacher</label>
                                        <select class="form-control" id="teacher_id" name="teacher_id" required>
                                            <option value="">-- Select Teacher --</option>
                                            <?php
                                                $br_option = "SELECT * FROM teachers";
                                                $br_option_run = mysqli_query($conn, $br_option);

                                                if (mysqli_num_rows($br_option_run) > 0) {
                                                    foreach ($br_option_run as $row2) {
                                            ?>
                                            <option value="<?php echo $row2['teacher_id']; ?>">
                                                <?php echo $row2['firstname']." ".$row2['lastname']?> </option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Course</label>
                                        <select class="form-control" id="course_id" name="course_id" required>
                                            <option value="">-- Select Course --</option>
                                            <?php
                                                $br_option = "SELECT * FROM courses";
                                                $br_option_run = mysqli_query($conn, $br_option);

                                                if (mysqli_num_rows($br_option_run) > 0) {
                                                    foreach ($br_option_run as $row2) {
                                            ?>
                                            <option value="<?php echo $row2['course_id']; ?>">
                                                <?php echo $row2['course_name']." ( ".$row2['course_code']." )"?>
                                            </option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Section</label>
                                        <input type="text" class="form-control" name="section" id="section"
                                            placeholder="Section" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Room No.</label>
                                        <input type="text" class="form-control" name="room" id="room"
                                            placeholder="Room No." required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Class Start Date</label>
                                        <input type="date" class="form-control" name="start_date" id="start_date"
                                            placeholder="Class Start Date" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Schedule Day</label>
                                        <select  class="form-control" name="schedule_day" id="schedule_day" required>
                                                <option value="">-- Select Day --</option>
                                                <option value="Mon/Wed">Mon/Wed</option>
                                                <option value="Sun/Tue">Sun/Tue</option>
                                                <option value="Thus">Thus</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Schedule Time</label>
                                        <select  class="form-control" name="schedule_time" id="schedule_time" required>
                                                <option value="">-- Select Time --</option>
                                                <option value="8:30 AM">8:30 AM</option>
                                                <option value="10:00 AM">10:00 AM</option>
                                                <option value="11:30 AM">11:30 AM</option>
                                                <option value="1:10 PM">1:10 PM</option>
                                                <option value="2:40 PM">2:40 PM</option>
                                                <option value="4:10 PM">4:10 PM</option>
                                            </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end" style="padding-top:10px;">
                                <button type="submit" name="submit" class="btn btn-success"
                                    style="margin-right:10px;margin-top:20px;">Create Class</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="js/sidebars.js"></script>
</body>

</html>