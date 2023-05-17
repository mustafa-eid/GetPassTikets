<?php
ob_start();
include_once __DIR__."\app/models/user.php";
include_once __DIR__."\app/middleware/auth.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="this is teba lab">
    <title>project</title>
    <link rel="shortcut icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="Css/all.min.css">
    <link rel="stylesheet" href="Css/bootstrap.min.css">
    <link rel="stylesheet" href="Css/style-sign.css">
    <link rel="stylesheet" href="Css/nav&footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Frank+Ruhl+Libre:wght@700&family=Imperial+Script&display=swap"
        rel="stylesheet">
</head>

<body>
    <nav>
        <div class="container">
            <div class="row  align-items-center content">
                <div class="col-1 pe-0 text-center ">
                    <div id="barsContent">
                        <i class="fa-solid fa-bars fs-5"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-5 pe-0 ps-0">
                    <img src="Images/WhatsApp_Image_2023-05-02_at_00.27.08-removebg-preview.png" alt="">
                </div>
                <div class="col-md-8 ps-0">
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
    <aside class="left-side">
        <button id="cancel">x</button>
        <a href="register.php"><i class="fa-solid fa-user"></i> Register</a>
        <a href="insex.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="about_us.php"><i class="fa-regular fa-address-card"></i> About Us</a>
        <a href="contact_us.php"><i class="fa-regular fa-address-card"></i> Contact Us</a>
        <a href="collection.php"><i class="fa-regular fa-address-card"></i> Collections</a>
    </aside>
    <section class="sign text-center">
        <div class="container">
            <div class="row mt-5">
                <div class="col-12">
                    <h1 class="pt-4">Sign in to your account</h1>
                    <p class="mb-5 opacity-75">Fill in all the required fields</p>
                    <img class="mb-3" src="Images/WhatsApp_Image_2023-05-02_at_00.27.08-removebg-preview (1).png"
                        alt="">
                    <h2 class="mb-4">Welcome to GetPassTickets</h2>
                </div>
                <div class="col-12">
        <?php
        $error_message = "";
        if(!empty($_SESSION['error_message'])){
            $error_message = $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }
        ?>

        <?php if(!empty($error_message)): ?>
            <div class="error-message" style="color: red;"><?php echo $error_message; ?></div>
        <?php endif; ?>

<form action ="app/post/sign.php" method="POST">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="user">
                <i class="fa-solid fa-user"></i>
                <input name="email" type="text" placeholder="Enter your email" required>
            </div>
        </div>
    </div>
    <div class="row row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="pass">
                <i class="fa-solid fa-lock"></i>
                <input name="password" type="password" placeholder="Enter your password" required>
            </div>
        </div>
    </div>
    <div class="row row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5 ">
            <div class="forget">
                <div class="check">
                    <input name="remember_me" type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <a href="forgot_password.php">Forgot your password ?</a>
            </div>
        </div>
    </div>
    <div class="row row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <button name="login">login</button>
        </div>
    </div>
    <?php if(!empty($error_message)){ ?>
    <div class="row row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5 text-danger">
            <?php echo $error_message; ?>
        </div>
    </div>
    <?php } ?>
</form>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="row align-items-center h-100">
                <div class="col-12 text-center">
                    <div class="links">
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="js/main.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
</body>

</html>

<?php
ob_end_flush();
?>