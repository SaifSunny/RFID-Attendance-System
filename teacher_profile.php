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


$teacher_img = $row['teacher_img'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$gender=$row['gender'];
$birthday=$row['birthday'];
$contact=$row['contact'];
$address=$row['address'];
$city=$row['city'];
$zip=$row['zip'];
$email=$row['email'];


if (isset($_POST['submit'])) {

    $error = "";
    $cls="";

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender=$_POST['gender'];
    $birthday=$_POST['birthday'];
    $contact=$_POST['contact'];
    $address=$_POST['address'];
    $city=$_POST['city'];
    $zip=$_POST['zip'];
    $email=$_POST['email'];


 
    $name = $_FILES['file']['name'];
    $target_dir = "img/teachers/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){

        // Upload file
        if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){

            // Convert to base64 
            $image_base64 = base64_encode(file_get_contents('img/teachers/'.$name));
            $image = 'data:img/'.$imageFileType.';base64,'.$image_base64;

            // Update Record

            $query2 = "UPDATE `teachers` SET firstname='$firstname',lastname='$lastname',
            birthday='$birthday', gender='$gender', contact='$contact',`teacher_img`='$name',
            `address`='$address', city='$city', zip='$zip' WHERE username='$username'";
            $query_run2 = mysqli_query($conn, $query2);

            if ($query_run2) {
                echo "<script> alert('Profile Image Successfully Updated.');
                window.location.href='teacher_home.php';</script>";
            } 
            else {
                $cls="danger";
                $error = "Cannot Update Profile Image";
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
                    <a href="teacher_courses.php" class="nav-link text-white" style="font-size:17px;">
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
                <div class="col-md-10" style="padding-bottom:0px;">
                    <h2 style="font-weight:600">My Profile</h2>
                    <p><a href="teacher_home.php">Dashboard</a> / My Profile</p>
                </div>
                <div class="col-md-2" style="margin-top:20px">

                </div>
            </div>

            <form action="" method="POST" enctype='multipart/form-data'>
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-md-12">
                        <div style="text-align:center;">
                            <div class="card-body" style="padding:0 20px;">
                                <div class="alert alert-<?php echo $cls;?>">
                                    <?php 
                                            if (isset($_POST['submit'])){
                                                echo $error;
                                            }
                                        ?>
                                </div>
                                <div class="row" style="padding-bottom:30px;">
                                    <div class="col-md-3">
                                        <div class="" style="width: 200px; height: 200px;">
                                            <img src="./img/teachers/<?php echo $teacher_img?>" width="100%"
                                                height="100%" style="text-align:center; margin-left:60px;">
                                            <input type="file" name="file" id="file" style="padding:30px 0px 0 42px;">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:15px">
                                                    <label style="padding-bottom:10px;">First Name</label>
                                                    <input type="text" class="form-control" name="firstname"
                                                        id="firstname" value="<?php echo $firstname ?>"
                                                        placeholder="Firstname" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:15px">
                                                    <label style="padding-bottom:10px;">Last Name</label>
                                                    <input type="text" class="form-control" name="lastname"
                                                        id="lastname" value="<?php echo $lastname ?>"
                                                        placeholder="Lastname" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:10px">
                                                    <label style="padding-bottom:10px;">Gender</label>
                                                    <input type="text" class="form-control" name="gender" id="gender"
                                                        value="<?php echo $gender ?>" placeholder="Gender" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:15px">
                                                    <label style="padding-bottom:10px;">Date of Birth</label>
                                                    <input type="date" class="form-control" name="birthday"
                                                        id="birthday" value="<?php echo $brithday?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:10px">
                                                    <label style="padding-bottom:10px;">Contact</label>
                                                    <input type="text" class="form-control" name="contact" id="contact"
                                                        value="<?php echo $contact ?>" placeholder="Contact" required>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:10px">
                                                    <label style="padding-bottom:10px;">Email</label>
                                                    <input type="text" class="form-control" name="email" id="email"
                                                        value="<?php echo $email ?>" placeholder="Email" required>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="padding:20px">
                                            <label style="padding-bottom:10px;">Address</label>
                                            <input type="text" class="form-control" name="address" id="address"
                                                value="<?php echo $address ?>" placeholder="Address" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" style="padding:20px">
                                            <label style="padding-bottom:10px;">City</label>
                                            <input type="text" class="form-control" name="city" id="city"
                                                value="<?php echo $city ?>" placeholder="City" required>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" style="padding:20px">
                                            <label style="padding-bottom:10px;">Zip</label>
                                            <input type="text" class="form-control" name="zip" id="zip"
                                                value="<?php echo $zip ?>" placeholder="Zip" required>

                                        </div>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-end" style="padding-top:20px;">
                                    <button type="submit" name="submit" class="btn btn-success"
                                        style="margin-right:10px;"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Update
                                        Profile</button>
                                </div>


                            </div>
                        </div>
                    </div>


                </div>

            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="js/sidebars.js"></script>
</body>

</html>