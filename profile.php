<?php
ob_start();



include_once __DIR__."\app/database/config.php";
include_once __DIR__."\app/database/operations.php";
include_once __DIR__."\app/models/user.php";
include_once __DIR__."\app/middleware/guest.php";
require 'vendor/autoload.php';
include 'phpqrcode/qrlib.php';

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}


$user_object = new User();
$user_result = $user_object->read();
if($user_result->num_rows > 0){
    foreach($user_result as $user){
    }
}


// Define the variables
$image_path = "";
$user_email = $user['email'];
$errors = [];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user uploaded an image
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors['image'] = "Please upload an image";
        $image_path = "";
    } else {
        // Upload the image
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_tmp_name = $image['tmp_name'];
        $image_error = $image['error'];
        
        // Check if the image was uploaded successfully
        if ($image_error === UPLOAD_ERR_OK) {
            // Move the uploaded file to a permanent location
            $image_path = "assets/users_images/" . $image_name;
            // echo $image_path;die;
            if(move_uploaded_file($image_tmp_name, $image_path)){
                // Image uploaded successfully
            } else {
                $errors['image'] = "Error uploading image";
            }
        } else {
            $errors['image'] = "Error uploading image";
        }
    }
    
    if (isset($_POST['email'])) {
        // Set the user email variable
        $user_email = $_POST['email'];
    }
}

// Check if there are no errors and update the image in the database
if (empty($errors) && isset($_POST['update_image'])) {
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "real_project";
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Prepare and execute the SQL query
    $sql = "UPDATE users SET image = '$image_path'";
    $sql .= " WHERE email = '$user_email'";
    if ($conn->query($sql) === TRUE) {
        // echo "Susessfully";
    } else {
        echo "Error updating image: " . $conn->error;
    }
    $conn->close();
    
    // Redirect back to the same page
    header("Location: {$_SERVER['PHP_SELF']}");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="this is teba lab">
    <!-- meta description hire -->
    <title>project</title>
    <link rel="shortcut icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="Css/all.min.css">
    <link rel="stylesheet" href="Css/bootstrap.min.css">
    <link rel="stylesheet" href="Css/my_profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Frank+Ruhl+Libre:wght@700&family=Imperial+Script&display=swap"
        rel="stylesheet">
</head>

<body>
    <!-- start nav bar -->
    <nav>
        <div class="container">
            <div class="row  align-items-center content">
                <div class="col-1 pe-0 text-center ">
                    <div id="barsContent" class="text-start">
                        <i class="fa-solid fa-bars fs-5"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2 col-5 pe-0 ps-0">
                    <img src="Images/WhatsApp_Image_2023-05-02_at_00.27.08-removebg-preview.png" class="mb-3" alt="">
                </div>
                <div class="col-md-9 col-lg-5 ps-0 d-none d-md-block">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about_us.php">About Us</a></li>
                        <li><a href="contact_us.php">Contact Us</a></li>
                        <li><a href="collection.php">Collections</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- end nav bar -->
    <!-- start side bar left -->
    <aside class="left-side">
        <div id="cancel">x</div>
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="about_us.php"><i class="fa-regular fa-address-card"></i> About Us</a>
        <a href="contact_us.php"><i class="fa-regular fa-address-card"></i> Contact Us</a>
        <a href="collection.php"><i class="fa-regular fa-address-card"></i> Collections</a>
        <a href=""><i class="fa-solid fa-user"></i> Sign out</a>
    </aside>
    <!-- end side bar left -->
    <!-- start side bar right -->
    <aside class="right-side">
        <div class="row w-100 m-0">
            <div class="col-12 p-0">
                <div class="links-contact right-bar">
                    <a href="#"><i class="fa-brands fa-facebook mb-3 fs-6 pointer-event"></i></a>
                    <a href="#"><i class="fa-brands fa-whatsapp mb-3 fs-6"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram fs-6"></i></a>
                </div>
            </div>
        </div>
    </aside>
    <!-- end side bar right -->
    <div class="landing">
        <img src="Images/WhatsApp Image 2023-05-01 at 23.28.49.jpg" alt="">
    </div>
    <!-- start circle -->
    <form method="POST" enctype="multipart/form-data">
        <section class="position-relative">
            <div class="container">
                <div class="row ps-md-4 ps-lg-0 align-items-center justify-content-evenly">
                    <div class="col-6 pe-0">
                        <div class="data">
                            <p class="second-font mb-0 fs-4 text-start">Welcome to our</p>
                            <h1 class="main-font fs-1">My Profile</h1>
                            <button class="btn-tiket mb-5">
                                <a href="collection.php" class="text-decoration-none text-light">
                                    Find Tickets
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 mt-md-5">
                        <div class="photo">
                            <img src="<?=$user['image']?>" alt="" id="image" class="w-100 rounded-circle"
                                style="cursor: pointer;">
                            <input type="file" name="image" id="file" class="d-none">
                        </div>
                        <button type="submit" name="update_image" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
            <div class="circle">
                <span class="rounded-circle"></span>
                <span class="rounded-circle"></span>
                <span class="rounded-circle"></span>
                <span class="rounded-circle"></span>
            </div>
        </section>
    </form>
    <!-- end circle -->
    <!-- start profile-->
    <section class="profile">
        <div class="container text-light">
            <div class="row pt-5">
                <div class="col">
                    <h2>Personal Information</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="m-md-4 ms-md-0 me-md-0 data-user">
                        <p>First name</p>
                        <p type="text" name="mobile_number"><?=$user['first_name']?></p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="m-md-4 ms-md-0 me-md-0 data-user">
                        <p>Last name</p>
                        <p type="text" name="mobile_number"><?=$user['last_name']?></p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="email m-md-4 ms-md-0 me-md-0 data-user">
                        <p>Email address</p>
                        <p type="text" name="mobile_number"><?=$user['email']?></p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="number m-md-4 ms-md-0 me-md-0 data-user">
                        <p>Phone number</p>
                        <p type="text" name="mobile_number"><?=$user['phone']?></p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <?php
                $file = "images_2/qr1.png";
                $_SESSION['file'] = $file;
                
            $ecc = 'H';
            $pixel_size = 20;
            $frame_size = 5;

            // QRcode::png($data, $file, $ecc, $pixel_size, $frame_size);

            if (isset($_SESSION['file'])) {
                $file = $_SESSION['file'];
                if (!empty($file)) {
                    echo '<img src="' . $file . '" alt="QR Code" style="width: 50%;">';
                } else {
                    echo 'QR Code image not found.';
                }
            } else {
                echo 'QR Code image not found.';
            }
                ?>
                </div>
            </div>
        </div>
        </form>
    </section>
    <!-- end profile -->
    <!-- start footer -->
    <footer>
        <div class="container">
            <div class="row align-items-end">
                <div class="col-5 d-md-none footer-link">
                    <ul>
                        <li><a href="index_2.php">Home</a></li>
                        <li><a href="about_us.php">About Us</a></li>
                        <li><a href="contact_us.php">Contact Us</a></li>
                        <li><a href="collection.php">Collections</a></li>
                    </ul>
                </div>
                <div class="col-7 col-md-12 text-center">
                    <div class="links-contact">
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end footer -->
    <script src="js/main.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
</body>

</html>

<script>
$('#image').on('click', function() {
    $('#file').click();
});
</script>

<?php
ob_end_flush();
?>