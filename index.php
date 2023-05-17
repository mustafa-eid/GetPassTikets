<?php
ob_start();

// session_start();

include_once __DIR__."\app/database/config.php";
include_once __DIR__."\app/database/operations.php";
include_once __DIR__."\app/models/party.php";
include_once __DIR__."\app/models/user.php";


if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}


if(isset($_COOKIE['remember_me'])){
    $user_object = new User();
    $user_object->setEmail($_COOKIE['remember_me']);

    $result = $user_object->get_user_by_email();
    $user = $result->fetch_object();
    $_SESSION['user'] = $user;
}


$party = new Party();
$parties_result = $party->read();

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
    <link rel="stylesheet" href="Css/style.css">
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
                <div class="col-md-5 ps-0 d-none d-md-block">
                    <ul>
                        <li><a href="index.php" class="active">Home</a></li>
                        <li><a href="about_us.php">About Us</a></li>
                        <li><a href="contact_us.php">Contact Us</a></li>
                        <li><a href="collection.php">Collections</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3 btns">
                    <div class="row justify-content-lg-evenly justify-content-end">
                        <div class="col-6 text-end">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="col-6 d-none d-md-block">
                        <?php
                            if(isset($user)){
                                ?>
                                <span class="digit">Hello <?=$user->first_name?><i class="ti-angle-down"></i></span>
                                <div class="dollar-submenu">
                                    <ul>
                                        <li><a href="profile.php">Profile/</a></li>
                                        <li><a href="app/post/sign_out.php">Sign out</a></li>
                                    </ul>
                                <?php
                            }else{
                                ?>
                                <div class="btn-register-login position-relative">
                                <a href="register.php" class="text-decoration-none text-light">Rgister/</a>
                                <a href="sign.php" class="text-decoration-none text-light">Sign in</a>
                            </div>
                                <?php
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- end nav bar -->
    <!-- start side bar left -->
    <aside class="left-side">
        <div id="cancel">x</div>
    <?php
                if(isset($user)){
                ?>
            <a href="profile.php"><i class="fa-solid fa-user"></i>Profile</a>
            <a href="app/post/sign_out.php"><i class="fa-solid fa-user"></i> Sign out</a>
            <?php
                }else{
                ?>
                <a href="register.php"><i class="fa-solid fa-user"></i>Register</a>
            <a href="sign.php"><i class="fa-solid fa-user"></i>Sign in</a>
    <?php
    }
    ?>
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="about_us.php"><i class="fa-regular fa-address-card"></i> About Us</a>
        <a href="contact_us.php"><i class="fa-regular fa-address-card"></i> Contact Us</a>
        <a href="collection.php"><i class="fa-regular fa-address-card"></i> Collections</a>
    </aside>
    <!-- end side bar left -->
    <!-- start side bar right -->
    <aside class="right-side">
        <div class="row w-100 me-0">
            <div class="col-10">
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
    <section class="position-relative">
        <div class="container">
            <div class="row ps-md-4 ps-lg-0">
                <div class="col-12 col-md-6">
                    <div class="data">
                        <p class="second-font mb-0 fs-4">Welcome to our</p>
                        <h1 class="main-font fs-1">Get Pass Tickets</h1>
                        <p class="">Greetings from GetPass!One of the top service providers, GetPass, offers seamless
                            networking
                            options
                            to a
                            cutting-edge ticketing application. </p>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn-tiket mb-5">
                        <p>
                            Find Tickets
                        </p>
                    </button>
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
    <!-- end circle -->
    <!-- start button up -->
    <button class="up" id="up"><i class="fa-solid fa-arrow-up"></i></button>
    <!-- end button up -->
    <!-- start cards tikets -->
<section class="cards-tikets mt-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 col-md-6 offset-md-3 text-center ticketsCardTitle mb-5 mt-5 fs-1">
                    <p class="mb-0 second-font mt-3">Join The Club</p>
                    <h1 class="text-light main-font">Get Pass Tickets</h1>
                    <svg width="88" height="62" viewBox="0 0 88 62" fill="none" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="88" height="61" fill="url(#pattern0)" />
                        <defs>
                            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_110_1306" transform="scale(0.02 0.0285714)" />
                            </pattern>
                            <image id="image0_110_1306" width="50" height="35"
                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAjCAMAAADha6m9AAABEVBMVEX/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pkb/pka+6kvkAAAAWnRSTlMAAQMEBgcICgwXGSAhIiQlJikqLS8wMTM0Njc4Oj4/QUJDREhSVVZcYmVmb3Fyc3h5ent8fX6Ag4SHiImPkpOUlZacnZ6sr7S1t7q8vb7A1NbY3ODh8Pf4+v4ZMifGAAABF0lEQVR42tXUazcCURQG4B0llRBRVCqXkEuaCBWiQia5lOL9/z/EMrsZnbksnQ/Wqv1tv2eeNWvW2bOJ9KoekLViUMixltGxSffQciar6NqS50kli/GhJFINMKl9+LUghAvjcOdtgckLor/kDmdM3pG2vPIROSb6oVZ1FJ2JiuI/k0zBRNylrT9IHwGRbOgzIpBwxcfNUZa+MC+SNNpEnimBpOgKx1rjBuzJOvImcjNoZpzICZ5kiQJ1XIn0t2ziXJZY7+UaOYN8IiiSpD58wu0n7oPclE/psG6asdnG7lgM/081ociS/d4Kk1fERvz3jQ2ztj2UJNUlfuoBc7xycDvqHvN4B513ejIWbFieuJolmzSFS0v2Db6Qtr1HCpQJAAAAAElFTkSuQmCC" />
                        </defs>
                    </svg>
                </div>
            </div>
            <div class="row">
            <?php
            if(!empty($parties_result)) {
                $parties = $parties_result->fetch_all(MYSQLI_ASSOC);
                foreach($parties as $party){
            ?>
    <div class="col-md-4">
        <div class="card border-0">
        <a href="Tiket.php?party_id=<?= $party['id'] ?>" class="text-decoration-none">
            <img class="card-img-top" src="<?= $party['image'] ?>" alt="Card image cap">
            <div class="card-body p-2">
                <h5 class="card-title text-light"><?= $party['name'] ?></h5>

                <?php
                $_SESSION['party_id'] = $party['id'];
                ?>

                <p class="card-text m-0"><strong>Date:</strong> <?= $party['date'] ?></p>
                <p class="card-text m-0"><strong>Time:</strong> <?= $party['time'] ?></p>
                <p class="card-text m-0"><strong>Price:</strong> <?= $party['price'] ?>LE</p>
                <p class="card-text m-0"><strong>Location:</strong> <?= $party['location'] ?></p>
                <p class="card-text m-0"><strong>Description:</strong> <?= $party['description'] ?></p>
            </div>
        </div>
        </a>
    </div>
    <?php
        }
    } else {
        echo '<div style="text-align:center; color:#EF6C08; padding: 20px;">';
        echo '<p>No parties found.</p>';
        echo '</div>';
    }
    ?>
</div>
    </div>
    </div>
    </section>
    <!-- end cards tikets -->
    <!-- start footer -->
    <footer>
        <div class="container">
            <div class="row align-items-end">
                <div class="col-5 d-md-none footer-link">
                    <ul>
                        <li><a href="index.php">Home</a></li>
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

<?php
ob_end_flush();
?>