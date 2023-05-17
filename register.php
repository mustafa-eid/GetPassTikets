<?php
ob_start();

include_once __DIR__."\app/database/config.php";
include_once __DIR__."\app/database/operations.php";
include_once __DIR__."\app/models/user.php";
include_once __DIR__."\app/middleware/auth.php";
include_once "app/services/email.php";
require 'vendor/autoload.php';
include 'phpqrcode/qrlib.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $errors = [];

        $user = new User();

        // Validate name
        if (empty($_POST['first_name'])) {
            $errors['first_name'] = "Please enter a first name";
        }
        if (empty($_POST['last_name'])) {
            $errors['last_name'] = "Please enter a last name";
        }

        // Validate phone
    if (empty($_POST['phone'])) {
        $errors['phone'] = "Please enter a phone number";
    } elseif (!preg_match('/^(01)[0125][0-9]{8}$/', $_POST['phone'])) {
        $errors['phone'] = "Please enter a valid 11-digit phone number in Egypt";
    }

        // Validate email
    if (empty($_POST['email'])) {
        $errors['email'] = "Please enter an email address";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address";
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['email'])) {
        $errors['email'] = "Please enter a valid email address in the correct format";
    } elseif ($user->setEmail($_POST['email'])->unique()) {
        $errors['email'] = "This email is already in used";
    }

        // Validate password
    if (empty($_POST['password'])) {
    $errors['password'] = "Password is required";
    } elseif (strlen($_POST['password']) < 8) {
        $errors['password'] = "Password must be at least 8 characters long";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!])(?=.{8,})/", $_POST['password'])) {
        $errors['password'] = "Password must include at least one uppercase letter,
        one lowercase letter, one number, and one special character (@#$%^&+=!)";
    }
    
        // Validate confirm_password
    if (empty($_POST['confirm_password'])) {
        $errors['confirm_password'] = "Please confirm your password";
    } elseif (strcmp($_POST['password'], $_POST['confirm_password']) !== 0) {
        $errors['confirm_password'] = "Passwords do not match";
    }


    if (empty($errors)) {

    $user->setFirst_name($_POST['first_name']);
    $user->setLast_name($_POST['last_name']);
    $user->setEmail($_POST['email']);
    $user->setPhone($_POST['phone']);
    $user->setPassword($_POST['password']);
    $code = rand(10000, 99999);
    $user->setCode($code);

    $data = 'fk2qglmR1iyNxSuwLPs83HVzOs8D7z4I7OhyZbdujyU=' . $_POST['email'];
    $user->setQr_code($data);

    $file = "images_2/qr1.png";
    $_SESSION['file'] = $file;

    $ecc = 'H';
    $pixel_size = 20;
    $frame_size = 5;

    QRcode::png($data, $file, $ecc, $pixel_size, $frame_size);



        if ($user->create()) {

            $subject = "Verification Code";
            $body = "Hello {$_POST['first_name']} {$_POST['last_name']}. Your Verification Code is:<br>$code<br>Thank you.";

            $email = new mail($_POST['email'], $subject, $body);

            // Attach the QR image to the email befor user payment_status = 1
            // $email->attachFile($file);

            $mail_result = $email->send();
            
            if ($mail_result) {
                $_SESSION['user_email'] = $_POST['email'];
                header('location:check_code.php?page=register');
            } else {
                $errors['mail_error'] = "Try again later";
            }

            $_SESSION['success_msg'] = "User created successfully";
        } else {
            $errors['error_create_user'] = "Error creating user";
        }
    }
}
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
    <link rel="stylesheet" href="Css/nav&footer.css">
    <link rel="stylesheet" href="Css/style-register.css">
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
        <div id="cancel">x</div>
        <a href="sign.php"><i class="fa-solid fa-user"></i> Sign in</a>
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="about_us.php"><i class="fa-regular fa-address-card"></i> About Us</a>
        <a href="contact_us.php"><i class="fa-regular fa-address-card"></i> Contact Us</a>
        <a href="collection.php"><i class="fa-regular fa-address-card"></i> Collections</a>
    </aside>
    <section class="register text-center">
        <div class="container">
            <div class="row mt-5">
                <div class="col-12">
                    <h1 class="pt-4">Register to your account</h1>
                    <p class="mb-5 opacity-75">Fill in all the required fields</p>
                    <img class="mb-3" src="Images/WhatsApp_Image_2023-05-02_at_00.27.08-removebg-preview (1).png"
                        alt="">
                    <h2 class="mb-4">Welcome to GetPassTickets</h2>
                    <h3>Contact Information</h3>
                    <p>Make sure you provide your personal mobile number and email address.</p>
                    <div class="row mt-5 ms-md-5 ms-1">
                        <div class="col-8 col-md-6 ps-0 text-end">
                            <p>Already have an account?</p>
                        </div>
                        <div class="col-3 p-0 text-start btn-login">
                            <a href="sign.php">Sign in</a>
                        </div>
                    </div>
                    <p class="oR-bar">OR</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form method="POST">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-3 pe-lg-0">
                                <div class="form-group">
                                    <label for="firstName">First name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name"
                                        placeholder="Enter your first name" required
                                        value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>">
                                    <?php if(isset($errors['first_name'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo $errors['first_name']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 ">
                                <div class="form-group">
                                    <label for="lastName">Last name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name"
                                        placeholder="Enter your last name" required
                                        value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>">
                                    <?php if(isset($errors['last_name'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo $errors['last_name']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="email">Phone</label>
                                    <input type="phone" class="form-control" id="phone" name="phone"
                                        placeholder="Enter your phone" required
                                        value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                                    <?php if(isset($errors['phone'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo $errors['phone']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter your email" required
                                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                    <?php if(isset($errors['email'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo $errors['email']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter your password" required>
                                    <?php if(isset($errors['password'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo $errors['password']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="repeatPassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="repeatPassword"
                                        name="confirm_password" placeholder="Enter your password again" required>
                                    <?php if(isset($errors['confirm_password'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo $errors['confirm_password']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6">
                                <div class="btn-register">
                                    <button type="submit" class="">Submet</button>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
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