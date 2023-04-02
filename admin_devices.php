<?php
include_once("./database/config.php");

session_start();
error_reporting(0);
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
    $dep_id = $_POST['dep_id'];
    $device_name = $_POST['device_name'];
    $device_date = $_POST['teacher_id'];
    $section = $_POST['section'];
    $room = $_POST['room'];

    $token = random_bytes(8);
    $device_uid = bin2hex($token);


    $query = "SELECT * FROM devices WHERE `course_id` = '$course_id' and `section` = '$section' and `room` = '$room' ";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run->num_rows > 0) {
        $query2 = "INSERT INTO devices(course_id, teacher_id, semester_id, dep_id, device_name, device_uid, device_type, section, room)
        VALUES ('$course_id','$teacher_id','$semester_id','$dep_id','$device_name','$device_uid','Faculty','$section','$room')";
        $query_run2 = mysqli_query($conn, $query2);
        if ($query_run2) {
            $cls="success";
            $error = 'Device Successfully ADDED.';
            
        } else {
            $cls="danger";
                $error = 'Cannot save Device';
            
        }
    } else {
        $cls="danger";
        $error = 'Device Already Exists';        
    }
}

if (isset($_POST['submit2'])) {
    
    $dep_id = $_POST['dep_id'];
    $device_name = $_POST['device_name'];

    $token = random_bytes(8);
    $device_uid = bin2hex($token);


    $query = "SELECT * FROM devices WHERE `dep_id` = '$dep_id'";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run->num_rows > 0) {
        $query2 = "INSERT INTO devices(course_id, teacher_id, semester_id, dep_id, device_name, device_uid, device_type, section, room)
        VALUES ('$course_id','$teacher_id','$semester_id','$dep_id','$device_name','$device_uid','Faculty','$section','$room')";
        $query_run2 = mysqli_query($conn, $query2);
        if ($query_run2) {
            $cls="success";
            $error = 'Device Successfully ADDED.';
            
        } else {
            $cls="danger";
                $error = 'Cannot save Device';
            
        }
    } else {
        $cls="danger";
        $error = 'Device Already Exists';        
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
                        <i class="fa-solid fa-user-tie" style="padding-right:12px;"></i>
                        Manage Faculty
                    </a>
                </li>
                <li>
                    <a href="admin_devices.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
                        <i class="fa-solid fa-computer" style="padding-right:18px;"></i>
                        Manage Devices
                    </a>
                </li>
                <li>
                    <a href="admin_students.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-users" style="padding-right:12px;"></i>
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
                <div class="col-md-7" style="padding-bottom:0px;">
                    <h2 style="font-weight:600">Manage Devices</h2>
                    <p><a href="admin_home.php">Dashboard</a> / Devices</p>
                </div>
                <div class="col-md-5" style="margin-top:20px">
                    <div class="d-flex justify-content-end">
                        <?php
                              $sql = "SELECT * FROM devices WHERE device_type= Administrative";
                              $result = mysqli_query($conn, $sql);
                          
                              if (!$result->num_rows > 0) {
                        ?>
                        <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2">Add
                            Administrative Device</a>
                        <?php
                              }
                        ?>
                        <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            style="margin-left:20px">Add
                            Faculty Device</a>
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
                                    <th>Device Name</th>
                                    <th>Device UID</th>
                                    <th>Semester</th>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Room No.</th>
                                    <th>Teacher Name</th>
                                    <th>Device Type</th>
                                    <th>Action</th>
                                </thead>

                                <tbody style="font-size:18px">
                                    <?php 
                                            $sql = "SELECT * FROM devices";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $device_id=$row['device_id'];
                                                    $device_name=$row['device_name'];
                                                    $course_id=$row['course_id'];
                                                    $semester_id=$row['semester_id'];
                                                    $teacher_id=$row['teacher_id'];
                                                    $device_uid=$row['device_uid'];
                                                    $device_date=$row['device_date'];
                                                    $device_type=$row['device_type'];
                                                    $section=$row['section'];
                                                    $room=$row['room'];

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
                                                    $teacher_name = $row3['firstname']." ".$row3['firstname'];
                                        ?>
                                    <tr style="vertical-align:middle;">
                                        <td><?php echo $device_name ?></td>
                                        <td><?php echo $device_uid ?></td>
                                        <td><?php echo $sem_code ?></td>
                                        <td><?php echo $course_code ?></td>
                                        <td><?php echo $section ?></td>
                                        <td><?php echo $room ?></td>
                                        <td><?php echo $teacher_name ?></td>
                                        <td><?php echo $device_type ?></td>
                                        <td style="font-size:14px; font-weight:600;"><a
                                                href="admin_device_delete.php?device_id=<?php echo $device_id?>"
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Device</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Device Name</label>
                                        <input type="text" class="form-control" name="device_name" id="device_name"
                                            placeholder="Device Name" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Department</label>
                                        <select class="form-control" id="dep_id" name="dep_id" required>
                                            <option value="">-- Select Department --</option>
                                            <?php
                                                $br_option = "SELECT * FROM departments";
                                                $br_option_run = mysqli_query($conn, $br_option);

                                                if (mysqli_num_rows($br_option_run) > 0) {
                                                    foreach ($br_option_run as $row2) {
                                            ?>
                                            <option value="<?php echo $row2['dep_id']; ?>">
                                                <?php echo $row2['dep_name']." ( ".$row2['dep_init']." )"?>
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
                            </div>

                            <div class="d-flex justify-content-end" style="padding-top:10px;">
                                <button type="submit" name="submit" class="btn btn-success"
                                    style="margin-right:10px;margin-top:20px;">Add Device</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add admin device Modal -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="margin-top:40px">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Administrative Device</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Device Name</label>
                                        <input type="text" class="form-control" name="device_name" id="device_name"
                                            placeholder="Device Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Department</label>
                                        <select class="form-control" id="dep_id" name="dep_id" required>
                                            <option value="">-- Select Department --</option>
                                            <?php
                                                $br_option = "SELECT * FROM departments";
                                                $br_option_run = mysqli_query($conn, $br_option);

                                                if (mysqli_num_rows($br_option_run) > 0) {
                                                    foreach ($br_option_run as $row2) {
                                            ?>
                                            <option value="<?php echo $row2['dep_id']; ?>">
                                                <?php echo $row2['dep_name']." ( ".$row2['dep_init']." )"?>
                                            </option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end" style="padding-top:10px;">
                                <button type="submit2" name="submit2" class="btn btn-success"
                                    style="margin-right:10px;margin-top:20px;">Add Device</button>
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