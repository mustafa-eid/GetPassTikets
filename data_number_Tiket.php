<?php
include_once __DIR__."\app/database/config.php";
include_once __DIR__."\app/database/operations.php";
include_once __DIR__."\app/models/student.php";
include_once __DIR__."\app/models/user.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];

    $user = new User();

    if (empty($_POST['name'])) {
        $errors['name'] = "Please enter a name";
    }


        // Validate phone
    if (empty($_POST['phone'])) {
        $errors['phone'] = "Please enter a phone number";
    } elseif (!preg_match('/^(01)[0125][0-9]{8}$/', $_POST['phone'])) {
        $errors['phone'] = "Please enter a valid 11-digit phone number in Egypt";
    } elseif ($user->setPhone($_POST['phone'])->unique_admine()) {
        $errors['phone'] = "This phone is already in used";
    }

        // Validate email
    if (empty($_POST['email'])) {
        $errors['email'] = "Please enter an email address";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter correct email,  valid email address";
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['email'])) {
        $errors['email'] = "Please enter a valid email address in the correct format";
    } elseif ($user->setEmail($_POST['email'])->unique_admine()) {
        $errors['email'] = "This email is already in used";
    }
    
    if(empty($errors)){
        $admin_object = new Student();
        $admin_object->setName($_POST['name']);
        $admin_object->setEmail($_POST['email']);
        $admin_object->setPhone($_POST['phone']);
        $result = $admin_object->create();
        if($result){
            header('location: sure_Tiket.php');
        }
    }else {
        $errors['error_create_user'] = "Error creating user";
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
    <link rel="stylesheet" href="Css/Tiket.css">
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
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="about_us.php"><i class="fa-solid fa-house"></i> About us</a>
        <a href="contact_us.php"><i class="fa-solid fa-house"></i> Contact us</a>
        <a href="collection.php"><i class="fa-regular fa-address-card"></i> Collections</a>
    </aside>

    <section class="Tiket-data text-center pb-md-5">
        <div class="container">
            <div class="row mt-5">
                <div class="col-12">
                    <img class="mb-4 mt-5" src="Images/WhatsApp_Image_2023-05-02_at_00.27.08-removebg-preview (1).png"
                        alt="">
                    <h2 class="mb-0">Welcome to GetPass Tickets</h2>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-md-6 col-lg-5 student-data m-md-auto">
                    <div class="d-flex">
                        <span class="rounded-circle ms-md-4 me-2"></span>
                        <h3 class="text-light">Student Data</h3>
                    </div>
                    <form method="POST">
                        <div class="mt-2 mb-2 text-start">
                            <div class="inputs">
                                <input type="text" name="name" placeholder="Enter the name of student" required
                                    value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                                <?php if(isset($errors['name'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo $errors['name']; ?>
                                </div>
                                <?php endif; ?>

                                <input type="email" name="email" placeholder="Enter the email of student" required
                                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                <?php if(isset($errors['email'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo $errors['email']; ?>
                                </div>
                                <?php endif; ?>
                                <input type="tel" name="phone" placeholder="Enter the phone number of student" required
                                    value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                                <?php if(isset($errors['phone'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo $errors['phone']; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn-back float-start mt-3 mb-3">
                                <a href="number_Tikets.php" class="text-decoration-none text-light">
                                    Back
                                </a>
                            </button>
                            <button type="submit" class="btn mt-3 ms-1 p-0 pt-1">Proceed</button>
                        </div>
                    </form>
                </div>
            </div>
    </section>
    <footer>
        <div class="container">
            <div class="row align-items-end">
                <div class="col-5 d-md-none footer-link">
                    <ul>
                        <li><a href="admin.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
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
    <script src="js/main.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
</body>

</html>