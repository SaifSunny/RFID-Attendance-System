<?php
include_once("./database/config.php");
date_default_timezone_set('Asia/Dhaka');

session_start();
$username = $_SESSION['teachername'];

if (!isset($_SESSION['teachername'])) {
    header("Location: teacher_login.php");
}

$sql = "SELECT * FROM teachers WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$teacher_img=$row['teacher_img'];

$_SESSION['teacher_img'] = $teacher_img;
$_SESSION['teacher_id'] = $row['teacher_id'];
$_SESSION['username'] = $row['username'];

$teacher_id= $row['teacher_id'];
$class_id = $_GET['class_id'];

$d = date("Y-m-d");

$newDate = date("d-m-Y", strtotime($d));  
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function fetchStudentData() {
            $.ajax({
                url: 'fetch_student_attendance.php?class_id=<?php echo $class_id?>',
                success: function (data) {
                    $('#student-attendance').html(data);
                }
            });
        }
        $(document).ready(function () {
            fetchStudentData();
            setInterval(fetchStudentData, 2000);
        });
    </script>
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
                    <a href="teacher_home.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-house" style="padding-right:16px;"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="teacher_courses.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
                        <i class="fa-solid fa-book" style="padding-right:22px;"></i>
                        My Courses
                    </a>
                </li>
                <li>
                    <a href="teacher_archieved.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-graduation-cap" style="padding-right:18px;"></i>
                        Archieved Courses
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="img/teachers/<?php echo $teacher_img?>" alt="" width="40" height="40"
                        class="rounded-circle me-2">
                    <strong><?php echo $username?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1"
                    style="width:200px;padding:10px;">
                    <li><a class="dropdown-item" href="teacher_profile.php">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>

        <div class="main">
            <div class="row">
                <div class="col-md-10" style="padding-bottom:30px;">
                    <h2 style="font-weight:600">Student Attendance</h2>
                    <p><a href="teacher_home.php">Dashboard</a> / <a href="teacher_courses.php">My Courses</a> / <a
                            href="teacher_course_details.php?class_id=<?php echo $class_id?>">Course Details</a> /
                        Student Attendance</p>
                </div>
                <div class="col-md-2" style="margin-top:20px">
                    <a href="teacher_deactivate_device.php?class_id=<?php echo $class_id?>" class="btn btn-danger">Deactivate
                        Device</a>
                </div>
            </div>

            <div class="row" style="margin-bottom:0px;">
                <div class="col-md-12">
                   <h4>Date: <?php echo $newDate?></h4>
                </div>
                <div class="col-md-12">
                    <div style="text-align:center;padding:0px 0px; height:500px;">

                        <div style="padding:20px; text-align:center;font-size:18px;">
                            <table class="table" style="font-size: 14px;color:#222;">
                                <thead>
                                    <th>Student ID</th>
                                    <th>Image</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Card UID</th>
                                    <th>Attendance Time</th>
                                </thead>

                                <tbody id="student-attendance" style="font-size:18px"></tbody>
                            </table>
                        </div>
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