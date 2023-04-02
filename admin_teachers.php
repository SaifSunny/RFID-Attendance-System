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
    
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $username = $_POST['username'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $nid = $_POST['nid'];
    $education = $_POST['education'];

    $p = $_POST['password'];
    $error = "";
    $cls="";

    $name = $_FILES['file']['name'];
    $target_dir = "img/teachers/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    if (strlen($p) > 5) {
    
        $query = "SELECT * FROM teachers WHERE username = '$username'";
        $query_run = mysqli_query($conn, $query);
        if (!$query_run->num_rows > 0) {

            $query = "SELECT * FROM teachers WHERE username = '$username' AND email = '$email'";
            $query_run = mysqli_query($conn, $query);
            if(!$query_run->num_rows > 0){

                // Check extension
                if( in_array($imageFileType,$extensions_arr) ){

                    // Upload file
                    if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){

                        // Convert to base64 
                        $image_base64 = base64_encode(file_get_contents('img/teachers/'.$name));
                        $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

                        // Insert record

                        $query2 = "INSERT INTO teachers(username ,email,`password`,firstname,lastname,contact,gender,birthday,teacher_img, `address`, city, zip, nid, education)
                        VALUES ('$username', '$email', '$password', '$firstname', '$lastname', '$contact', '$gender', '$birthday', '$name', '$address', '$city', '$zip', '$nid', '$education')";
                        $query_run2 = mysqli_query($conn, $query2);
            
                        if ($query_run2) {
                            $cls="success";
                            $error = "Teachers Successfully Added.";
                        } 
                        else {
                            $cls="danger";
                            $error = mysqli_error($conn);
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
                $error = "Teacher Already Exists";
            }
            
        }else{
            $cls="danger";
            $error = "username Already Exists";
        }
    }else{
        $cls="danger";
        $error = 'Password has to be minimum of 6 charecters.';
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
                    <a href="admin_teachers.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
                        <i class="fa-solid fa-user-tie" style="padding-right:12px;"></i>
                        Manage Faculty
                    </a>
                </li>
                <li>
                    <a href="admin_devices.php" class="nav-link text-white" style="font-size:17px;">
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
                <div class="col-md-10" style="padding-bottom:0px;">
                    <h2 style="font-weight:600">Manage Faculty</h2>
                    <p><a href="admin_home.php">Dashboard</a> / Faculty</p>
                </div>
                <div class="col-md-2" style="margin-top:20px">
                    <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add
                        Faculty</a>
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
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Faculty Name</th>
                                    <th>Birthday</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </thead>

                                <tbody style="font-size:18px">
                                    <?php 
                                            $sql = "SELECT * FROM teachers where teacher_id <> 1";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $faculty_id=$row['teacher_id'];
                                                    $teacher_img=$row['teacher_img'];
                                                    $firstname=$row['firstname'];
                                                    $lastname=$row['lastname'];
                                                    $email=$row['email'];
                                                    $birthday=$row['birthday'];
                                                    $contact=$row['contact'];
                                                    $address=$row['address']." ".$row['city']." ".$row['zip'];

                                        ?>
                                    <tr style="vertical-align:middle;">
                                        <td><?php echo $faculty_id ?></td>
                                        <td><img src="./img/teachers/<?php echo $teacher_img?>"
                                                style="width:60px; height:60px; object-fit:cover;" alt="profile">
                                        <td><?php echo $firstname." ".$lastname ?></td>
                                        <td><?php echo $birthday ?></td>
                                        <td><?php echo $email ?></td>
                                        <td><?php echo $contact ?></td>
                                        <td><?php echo $address ?></td>
                                        <td style="font-size:14px; font-weight:600;"><a
                                                href="admin_teacher_delete.php?teacher_id=<?php echo $teacher_id?>"
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Faculty</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype='multipart/form-data'>
                            <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Profile Image</label>
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">First Name</label>
                                        <input type="text" class="form-control" name="firstname" id="firstname"
                                            placeholder="First Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Last Name</label>
                                        <input type="text" class="form-control" name="lastname" id="lastname"
                                            placeholder="Last Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">NID Number</label>
                                        <input type="text" class="form-control" name="nid" id="nid"
                                            placeholder="NID Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Education</label>
                                        <input type="text" class="form-control" name="education" id="education"
                                            placeholder="Education" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Gender</label>
                                        <select class="form-control" name="gender" id="gender" placeholder="Gender"
                                            required>
                                            <option>-- Select Gender --</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Birthday</label>
                                        <input type="date" class="form-control" name="birthday" id="birthday"
                                            placeholder="Birthday" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Contact</label>
                                        <input type="text" class="form-control" name="contact" id="contact"
                                            placeholder="Contact" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Email</label>
                                        <input type="text" class="form-control" name="email" id="email"
                                            placeholder="Email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Address</label>
                                        <input type="text" class="form-control" name="address" id="address"
                                            placeholder="Address" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">City</label>
                                        <input type="text" class="form-control" name="city" id="city" placeholder="City"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Zip</label>
                                        <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Username</label>
                                        <input type="text" class="form-control" name="username" id="username"
                                            placeholder="Username" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Password</label>
                                        <input type="text" class="form-control" name="password" id="password"
                                            placeholder="Password" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end" style="padding-top:10px;">
                                <button type="submit" name="submit" class="btn btn-success"
                                    style="margin-right:10px;">Add Faculty</button>
                                <a href="faculty.php" class="btn btn-primary">Go Back</a>
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