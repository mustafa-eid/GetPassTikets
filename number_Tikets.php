<?php
ob_start();

include_once __DIR__."\app/database/config.php";
include_once __DIR__."\app/database/operations.php";
include_once __DIR__."\app/middleware/guest.php";
include_once __DIR__."\app/models/party.php";
include_once __DIR__."\app/models/user.php";



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
        <a href="admin.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="collection.php"><i class="fa-regular fa-address-card"></i> Collections</a>
        <a href=""><i class="fa-solid fa-user"></i> Sign out</a>
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
            <?php
            if(!empty($parties_result)) {
                $parties = $parties_result->fetch_all(MYSQLI_ASSOC);
                foreach($parties as $party){
                }
            }
            ?>
            <div class="row mt-4">
                <div class="col-md-8 col-12 pt-3 m-md-auto content-card">
                    <div class="text-start borderbottom ">
                        <img src="<?= $party['image'] ?>" alt="" width="300px">
                        <p class="text-light mt-3"><?= $party['name'] ?></p>
                        <p class="text-light"><?= $party['date'] ?> - <?= $party['time'] ?></p>
                    </div>
                    <div class="select d-flex justify-content-between align-items-center borderbottom p-3 ps-0 pe-0">
                        <span class="rounded-circle ms-md-4"></span>
                        <h3 class="text-light">Price per student</h3>
                        <div class="form-select w-50 " aria-label="Default select example">
                            <option selected> <?= $party['price'] ?>LE</option>
                        </div>
                    </div>
                    <form method="POST" action="app/post/number_Tikets.php">
                    <div class="select d-flex justify-content-between align-items-center  borderbottom p-3 ps-0 pe-0">
                        <span class="rounded-circle ms-md-4"></span>
                        <h3 class="text-light">other people</h3>
                        <select name="ather_people" class="form-select w-50" aria-label="Default select example" id="num-people">
                            <option selected>Select Number Other people</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <button class="btn-back float-start mt-3 mb-3">
                        <a href="Tiket.php" class="text-decoration-none text-light">
                            Back
                        </a>
                    </button>
                    <button class="btn float-end mt-3"><a href="sure_Tiket.php"
                    class="text-decoration-none text-light">Proceed</a></button>
                </div>
            </form>
            </div>
    </section>


    <footer>
        <div class="container">
            <div class="row align-items-end">
                <div class="col-5 d-md-none footer-link">
                    <ul>
                        <li><a href="admin.php">Home</a></li>
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
    <script src="js/main.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
</body>

</html>