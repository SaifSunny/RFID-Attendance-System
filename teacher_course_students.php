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
                    <a href="teacher_students.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-users" style="padding-right:18px;"></i>
                        My Students
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
                    <img src="img/admin/<?php echo $teacher_img?>" alt="" width="40" height="40"
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
                <div class="col-md-12" style="padding-bottom:30px;">
                    <h2 style="font-weight:600">Course Students</h2>
                    <p><a href="teacher_home.php">Dashboard</a> / <a href="teacher_home.php">My Courses</a> / Course Students</p>
                </div>
            </div>

            <div class="row" style="padding-top:0px;margin-bottom:40px;">
                <div class="col-md-12">
                    <div style="text-align:center;padding:0px 0px; height:500px;">
                        <div class="row align-items-start py-2">
                            <div class="col-lg-12">
                                <div class="row">
                                    <?php 
                                        $sql = "SELECT * FROM devices where teacher_id=$teacher_id";
                                        $result = mysqli_query($conn, $sql);
                                        if($result){
                                        while($row=mysqli_fetch_assoc($result)){
                                            $course_id=$row['course_id'];
                                            
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
                                    <div class="col-md-4">
                                        <div class="card">
                                            <a href="teacher_student_list.php?course_id=<?php echo $id?>"><img
                                                    src="img/courses/<?php echo $course_img?>" class="card-img-top"
                                                    alt="..." style="height:200px; object-fit:cover"></a>
                                            <div class="card-body" style="padding:30px">
                                                <p style="font-size:15px"><i
                                                        class="fa fa-book text-success"></i>&nbsp;&nbsp;
                                                    <?php echo $dep_name?>



                                                    <h5 class="card-title"><a
                                                            href="ngo_blog_details.php?blog_id=<?php echo $id?>"
                                                            style="color:black"><?php echo $course_name." (".$course_code.")"?></a>
                                                    </h5>
                                                    <p class="card-text"><?php echo substr($description, 0, 100)?></p>
                                                    <a href="ngo_blog_details.php?blog_id=<?php echo $id?>"
                                                        class="btn btn-success">View Student List</a>
                                            </div>
                                        </div>

                                    </div>
                                    <?php 
                                            }
                                        }
                                    ?>
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