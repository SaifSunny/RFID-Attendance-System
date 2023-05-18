<?php
include_once("./database/config.php");

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

$sql2= "SELECT * FROM class where class_id=$class_id";
$result2 = mysqli_query($conn, $sql2);
$row2=mysqli_fetch_assoc($result2);

$course_id=$row2['course_id'];

$sql1 = "SELECT * FROM courses where course_id=$course_id";
$result1 = mysqli_query($conn, $sql1);
$row1=mysqli_fetch_assoc($result1);

$course_img=$row1['course_img'];
$course_name=$row1['course_name'];
$course_code=$row1['course_code'];
$dep_id=$row1['dep_id'];
$description=$row1['description'];

$sql2 = "SELECT * FROM departments where dep_id=$dep_id";
$result2 = mysqli_query($conn, $sql2);
$row2=mysqli_fetch_assoc($result2);
$dep_name=$row2['dep_name'];

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
                <div class="col-md-12" style="padding-bottom:30px;">
                    <h2 style="font-weight:600">Course Details</h2>
                    <p><a href="teacher_home.php">Dashboard</a> / <a href="teacher_courses.php">My Courses</a> / Courses
                        Details</p>
                </div>
            </div>
            <div class="row py-3">

                <div class="col-md-12">
                    <img src="img/courses/<?php echo $course_img?>" class="card-img-top" alt="Cause" height="312"
                        style="object-fit: cover;">
                </div>

                <div class="col-lg-12">
                    <div class="card-body d-flex" style="margin: 20px">
                        <div style="width:100%">

                            <span class="badge text-bg-success"
                                style="margin-right:10px; padding: 6px 15px;font-size:14px;"><?php echo $dep_name?></span>
                            <span class="badge text-bg-success"
                                style="padding: 6px 15px;font-size:14px;"><?php echo $course_code?></span>

                            <h4 class="card-title"><?php echo $course_name?></h4>
                            <hr>
                            <div>
                                <p class="card-text"><?php echo $description?></p>
                            </div>
                            <div class="py-3">
                                <a href="teacher_course_students.php?class_id=<?php echo $class_id?>"
                                    class="btn btn-primary">Student
                                    List</a>
                                <a href="teacher_activate_device.php?class_id=<?php echo $class_id?>"
                                    class="btn btn-success">Take
                                    Attandance</a>
                                <a href="teacher_archive.php?class_id=<?php echo $class_id?>"
                                    class="btn btn-warning">Archive
                                    Course</a>
                            </div>
                            <hr>
                            <div>
                                <div class="row" style="padding-top:30px">
                                    <div class="col-md-6 pt-2">
                                        <h5 style="">Class Attendance</h5>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                    </div>
                                </div>
                                <hr>
                                <div class="row" style="margin-bottom:0px;">
                                    <div class="col-md-12">
                                        <div style="padding:0px 0px; height:500px;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Student ID</th>
                                                        <th>Student Name</th>
                                                        <?php 
                                                        $sql1 = "SELECT DISTINCT att_date from class_attendance";
                                                        $result1 = mysqli_query($conn, $sql1);
                                                        if($result1){
                                                            while($row1=mysqli_fetch_assoc($result1)){

                                                                $att_date=$row1['att_date'];

                                                    ?>
                                                        <th
                                                            style="color:#222;writing-mode: vertical-rl;text-orientation: mixed;">
                                                            <?php echo $att_date?></th>
                                                        <?php
                                                            }
                                                        }
                                                    ?>
                                                        <th
                                                            style="color:#222;writing-mode: vertical-rl;text-orientation: mixed;">
                                                            Total Class</th>
                                                            <th
                                                            style="color:#222;writing-mode: vertical-rl;text-orientation: mixed;">
                                                            Present</th>
                                                            <th
                                                            style="color:#222;writing-mode: vertical-rl;text-orientation: mixed;">
                                                            Percentage</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $sql2 = "SELECT * FROM class_students where class_id=$class_id";
                                                        $result2 = mysqli_query($conn, $sql2);
                                                        if($result2){
                                                            while($row2=mysqli_fetch_assoc($result2)){

                                                                $student_id=$row2['student_id'];

                                                                $sql3 = "SELECT * FROM students WHERE student_id='$student_id'";
                                                                $result3 = mysqli_query($conn, $sql3);
                                                                $row3=mysqli_fetch_assoc($result3);

                                                                $firstname=$row3['firstname'];
                                                                $lastname=$row3['lastname'];
                                                                $stu_uni_id=$row3['stu_uni_id'];

                                                                $days_present = 0; 
                                                                $total_days = 0; 
                                                    ?>
                                                    <tr style="color:#222;">
                                                        <td><?php echo $stu_uni_id?></td>
                                                        <td><?php echo $firstname." ".$lastname?></td>

                                                        <?php 
                                                            $sql_attendance = "SELECT * FROM class_attendance WHERE class_id=$class_id AND student_id=$student_id";
                                                            $result_attendance = mysqli_query($conn, $sql_attendance);
                                                            $attendance = array();
                                                            while($row_attendance = mysqli_fetch_assoc($result_attendance)) {
                                                                $attendance[$row_attendance['att_date']] = $row_attendance;
                                                                $days_present++;
                                                            }

                                                            $sql_dates = "SELECT DISTINCT att_date FROM class_attendance WHERE class_id=$class_id";
                                                            $result_dates = mysqli_query($conn, $sql_dates);
                                                            while($row_dates=mysqli_fetch_assoc($result_dates)){
                                                                $att_date = $row_dates['att_date'];
                                                                $total_days++;
                                                                if (isset($attendance[$att_date])) {
                                                        ?>
                                                        <td>P</td>
                                                        <?php
                                                                } else {
                                                        ?>
                                                        <td>A</td>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                        <td><?php echo $total_days?></td>
                                                        <td><?php echo $days_present?></td>
                                                        <td><?php echo number_format(($days_present / $total_days) * 100, 2)?>%
                                                        </td>
                                                    </tr>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </tbody>

                                        </div>
                                    </div>
                                </div>

                            </div>


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