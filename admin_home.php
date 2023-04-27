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
    $sem_name = $_POST['sem_name'];
    $sem_code = $_POST['sem_code'];
    $sem_year = $_POST['sem_year'];

    $query = "SELECT * FROM semester WHERE sem_name = '$sem_name' AND sem_year='$sem_year'";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run->num_rows > 0) {
        $query = "SELECT * FROM semester WHERE sem_code = '$sem_code'";
        $query_run = mysqli_query($conn, $query);
        if (!$query_run->num_rows > 0) {
            $query2 = "INSERT INTO semester(sem_name, sem_code, sem_year)
            VALUES ('$sem_name','$sem_code','$sem_year')";
            $query_run2 = mysqli_query($conn, $query2);
            if ($query_run2) {
                $cls="success";
                $error = 'Semester Successfully ADDED.';
                
            } else {
                $cls="danger";
                $error = 'Cannot save Semester';
            }
        }
        else{
            $cls="danger";
            $error = 'Semester Code Already Exists';
        }

    } else {
        $cls="danger";
        $error = 'Semester Already Exists';
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
                    <a href="admin_home.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
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
                <div class="col-md-12" style="padding-bottom:30px;">
                    <h2 style="font-weight:600">Dashboard</h2>
                    <p>Admin Dashboard</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:18px">Departments</h5>
                        <div class="card-body" style="text-align:center; font-size:15px;">
                            <?php
                                    $sql = "SELECT * from departments";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:20px">Courses</h5>
                        <div class="card-body" style="text-align:center; font-size:18px;">
                            <?php
                                    $sql = "SELECT * from courses";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:20px">Teachers
                        </h5>
                        <div class="card-body" style="text-align:center; font-size:18px;">
                            <?php
                                    $sql = "SELECT * from teachers";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:20px">Students
                        </h5>
                        <div class="card-body" style="text-align:center; font-size:18px;">
                            <?php
                                    $sql = "SELECT * from students";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="padding-top:50px;margin-bottom:0px;">
                <div class="col-md-12">
                    <div style="text-align:center;padding:30px 0px; height:500px;">
                        <div class="d-flex justify-content-between" style="padding: 0 50px">
                            <div>
                                <h3 style="font-size:24px;padding-bottom:20px">Manage Semester</h3>
                            </div>
                            <div>
                                <a href="" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Add Semester</a>
                            </div>
                        </div>

                        <div class="alert alert-<?php echo $cls;?>" style="margin: 20px 100px;margin-bottom:40px">
                            <?php 
                                if (isset($_POST['submit'])){
                                    echo $error;
                                }
                            ?>
                        </div>

                        <div style="padding:10px 20px 20px 20px; text-align:center;font-size:18px;">
                            <table class="table" style="font-size: 14px;color:#222;">
                                <thead>
                                    <th>Sl</th>
                                    <th>Semester Code</th>
                                    <th>Semester Name</th>
                                    <th>Year</th>
                                    <th>Action</th>
                                </thead>

                                <tbody style="font-size:18px">
                                    <?php 
                                    $sl=0;
                                            $sql = "SELECT * FROM semester where sem_id <>1";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $sem_id=$row['sem_id'];
                                                    $sem_name=$row['sem_name'];
                                                    $sem_year=$row['sem_year'];
                                                    $sem_code=$row['sem_code'];

                                                    $sl++;

                                        ?>
                                    <tr style="vertical-align:middle;">
                                        <td><?php echo $sl ?></td>
                                        <td><?php echo $sem_code ?></td>
                                        <td><?php echo $sem_name ?></td>
                                        <td><?php echo $sem_year ?></td>
                                        <td style="font-size:14px; font-weight:600;"><a href="admin_semester_delete.php?sem_id=<?php echo $sem_id?>"
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Semester</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Semester Name</label>
                                        <select class="form-control" name="sem_name" id="sem_name" required>
                                            <option value="">-- Select Name --</option>
                                            <option value="Spring">Spring</option>
                                            <option value="Summer">Summer</option>
                                            <option value="Fall">Fall</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Year</label>
                                        <input type="number" class="form-control" name="sem_year" id="sem_year"
                                            min="2020" max="2099" value="<?php echo date('Y');?>" placeholder="Year"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Semester Code</label>
                                        <input type="text" class="form-control" name="sem_code" id="sem_code"
                                            placeholder="Semester Code" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end" style="padding-top:10px;">
                                <button type="submit" name="submit" class="btn btn-success"
                                    style="margin-right:10px;margin-top:20px;">Add Semester</button>
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