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
    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $credit = $_POST['credit'];
    $dep_id = $_POST['select_dep'];
    $prog_id = $_POST['select_prog'];
    $description = $_POST['description'];

    $name = $_FILES['file']['name'];
    $target_dir = "img/courses/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    $query = "SELECT * FROM courses WHERE course_name = '$course_name'";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run->num_rows > 0) {
        $query = "SELECT * FROM courses WHERE course_code = '$course_code'";
        $query_run = mysqli_query($conn, $query);
        if (!$query_run->num_rows > 0) {
            // Check extension
            if( in_array($imageFileType,$extensions_arr) ){

                // Upload file
                if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){
            
                    // Convert to base64 
                    $image_base64 = base64_encode(file_get_contents('img/courses/'.$name));
                    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

                    $query2 = "INSERT INTO courses(course_img, course_name, course_code, credit, dep_id, prog_id, `description`)
                    VALUES ('$name','$course_name','$course_code','$credit', '$dep_id','$prog_id','$description')";
                    $query_run2 = mysqli_query($conn, $query2);
                    if ($query_run2) {
                        $cls="success";
                        $error = 'Course Successfully ADDED.';
                        
                    } else {
                        $cls="danger";
                        $error = 'Cannot save Course';
                        
                    }
                }else{
                    $cls="danger";
                    $error = 'Unknown Error Occurred.';
                }
            }else{
                $cls="danger";
                $error = 'Invalid File Type';
            }
        }
        else{
            $cls="danger";
            $error = 'Course Code Already Exists';
        }

        
    } else {
        $cls="danger";
        $error = 'Course Already Exists';        
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
                    <a href="admin_courses.php" class="nav-link  active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
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
                    <a href="admin_classes.php" class="nav-link text-white" style="font-size:17px;">
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
                    <h2 style="font-weight:600">Manage Courses</h2>
                    <p><a href="admin_home.php">Dashboard</a> / Courses</p>
                </div>
                <div class="col-md-2" style="margin-top:20px">
                    <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add
                        Course</a>
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
                                    <th>Course Image</th>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Credit Hour</th>
                                    <th>Department</th>
                                    <th>Program</th>
                                    <th>Action</th>
                                </thead>

                                <tbody style="font-size:18px">
                                    <?php 
                                            $sql = "SELECT * FROM courses where course_id <> 1";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $course_id=$row['course_id'];
                                                    $course_img=$row['course_img'];
                                                    $course_name=$row['course_name'];
                                                    $course_code=$row['course_code'];
                                                    $credit=$row['credit'];
                                                    $dep_id=$row['dep_id'];
                                                    $prog_id=$row['prog_id'];

                                                    $sql1 = "SELECT * FROM departments where dep_id = $dep_id";
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    $row1=mysqli_fetch_assoc($result1);
                                                    $dep_init = $row1['dep_init'];
                                                    
                                                    $sql2 = "SELECT * FROM program where prog_id = $prog_id";
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    $row2=mysqli_fetch_assoc($result2);
                                                    $prog_init = $row2['prog_init'];
                                        ?>
                                    <tr style="vertical-align:middle;">
                                        <td><img src="./img/courses/<?php echo $course_img?>" style="width:90px;"
                                                alt="profile">
                                            <span style="padding-left:20px;"></span></td>
                                        <td><?php echo $course_code ?></td>
                                        <td><?php echo $course_name ?></td>
                                        <td><?php echo $credit ?></td>
                                        <td><?php echo $dep_init ?></td>
                                        <td><?php echo $prog_init ?></td>
                                        <td style="font-size:14px; font-weight:600;"><a
                                                href="admin_course_delete.php?course_id=<?php echo $course_id?>"
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Course</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype='multipart/form-data'>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Department</label>
                                        <select class="form-control" id="select_dep" name="select_dep" required>
                                            <option value="">-- Select Department --</option>
                                            <?php
                                                $br_option = "SELECT * FROM departments where dep_id <> 1";
                                                $br_option_run = mysqli_query($conn, $br_option);

                                                if (mysqli_num_rows($br_option_run) > 0) {
                                                    foreach ($br_option_run as $row2) {
                                            ?>
                                            <option value="<?php echo $row2['dep_id']; ?>">
                                                <?php echo $row2['dep_name']." ( ".$row2['dep_init']." )"?> </option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Program</label>
                                        <select class="form-control" id="select_prog" name="select_prog" required>
                                            <option value="">-- Select Program --</option>
                                            <?php
                                                $br_option = "SELECT * FROM program where prog_id <> 1";
                                                $br_option_run = mysqli_query($conn, $br_option);

                                                if (mysqli_num_rows($br_option_run) > 0) {
                                                    foreach ($br_option_run as $row2) {
                                            ?>
                                            <option value="<?php echo $row2['prog_id']; ?>">
                                                <?php echo $row2['prog_name']." ( ".$row2['prog_init']." )"?> </option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Course Image</label>
                                        <input type="file" name="file" class="form-control">
                                    </div>
                            
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group" style="padding:10px">
                                            <label style="padding-bottom:10px;">Course Name</label>
                                            <input type="text" class="form-control" name="course_name" id="course_name"
                                                placeholder="Course Name" required>
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Course Code</label>
                                        <input type="text" class="form-control" name="course_code" id="course_code"
                                            placeholder="Course Code" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Course Credit</label>
                                        <input type="text" class="form-control" name="credit" id="credit"
                                            placeholder="Course Credit" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Course Description</label>
                                        <textarea class="form-control" name="description" id="description"
                                            placeholder="Course Description" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end" style="padding-top:10px;">
                                <button type="submit" name="submit" class="btn btn-success"
                                    style="margin-right:10px;margin-top:20px;">Add Course</button>
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