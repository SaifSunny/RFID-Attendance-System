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

if (isset($_POST['submit'])) {
    $stu_uni_id = $_POST['student_uni_id'];

    $query = "SELECT * FROM students WHERE stu_uni_id = '$stu_uni_id'";
    $query_run = mysqli_query($conn, $query);
    $row10=mysqli_fetch_assoc($query_run);
    $student_id = $row10['student_id'];

    $query8 = "SELECT * FROM class_students WHERE class_id = '$class_id' AND student_id = '$student_id'";
    $query_run8 = mysqli_query($conn, $query8);
    if (!$query_run8->num_rows > 0) {

            $query2 = "INSERT INTO class_students(class_id, student_id)
            VALUES ('$class_id','$student_id')";
            $query_run2 = mysqli_query($conn, $query2);
            if ($query_run2) {
                $cls="success";
                $error = 'Student Successfully ADDED.';
                
            } else {
                $cls="danger";
                $error = 'Cannot Add Student';
            }

    } else {
        $cls="danger";
        $error = 'Student Already Exists';
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
                    <h2 style="font-weight:600">Student List</h2>
                    <p><a href="teacher_home.php">Dashboard</a> / <a href="teacher_courses.php">My Courses</a> / <a
                            href="teacher_course_details.php?class_id=<?php echo $class_id?>">Course Details</a> /
                        Student List</p>
                </div>
                <div class="col-md-2" style="margin-top:20px">
                    <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add
                        Student</a>
                </div>
            </div>

            <div class="row" style="margin-bottom:0px;">
                <div class="col-md-12">
                    <div style="text-align:center;padding:0px 0px; height:500px;">

                        <div style="padding:20px; text-align:center;font-size:18px;">
                            <table class="table" style="font-size: 14px;color:#222;">
                                <thead>
                                    <th>Student ID</th>
                                    <th>Image</th>
                                    <th>Student Name</th>
                                    <th>Gender</th>
                                    <th>Birthday</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </thead>

                                <tbody style="font-size:18px">
                                    <?php 
                                            $sql = "SELECT * FROM class_students where class_id=$class_id";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $student_id=$row['student_id'];

                                                    $sql1 = "SELECT * FROM students where student_id=$student_id";
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    $row1=mysqli_fetch_assoc($result1);

                                                    $stu_uni_id=$row1['stu_uni_id'];
                                                    $student_img=$row1['student_img'];
                                                    $firstname=$row1['firstname'];
                                                    $lastname=$row1['lastname'];
                                                    $email=$row1['email'];
                                                    $gender=$row1['gender'];
                                                    $birthday=$row1['birthday'];
                                                    $contact=$row1['contact'];
                                                    $card_uid=$row1['card_uid'];
                                                    $address=$row1['address']." ".$row1['city']." ".$row1['zip'];

                                        ?>
                                    <tr style="vertical-align:middle;">
                                        <td><?php echo $stu_uni_id ?></td>
                                        <td><img src="./img/students/<?php echo $student_img?>"
                                                style="width:80px; height:80px; object-fit:cover;" alt="profile">
                                        <td><?php echo $firstname." ".$lastname ?></td>
                                        <td><?php echo $gender ?></td>
                                        <td><?php echo $birthday ?></td>
                                        <td><?php echo $email ?></td>
                                        <td><?php echo $contact ?></td>
                                        <td><?php echo $address ?></td>
                                        <td style="font-size:14px; font-weight:600;"><a
                                                href="teacher_student_delete.php?student_id=<?php echo $student_id?>"
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


        <!-- Add Semester Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="margin-top:10%">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Student</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="margin: 10px 0">
                        <form action="" method="POST" enctype='multipart/form-data'>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Sudent ID</label>
                                        <input type="text" class="form-control" name="student_uni_id" id="student_uni_id"
                                            placeholder="Sudent ID" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end" style="padding-top:20px;">
                                <button type="submit" name="submit" class="btn btn-success"
                                    style="margin-right:10px;">Add Student</button>
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