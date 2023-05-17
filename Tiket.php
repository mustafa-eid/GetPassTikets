<?php
ob_start();
session_start();
include_once __DIR__."\app/database/config.php";
include_once __DIR__."\app/database/operations.php";
include_once __DIR__."\app/models/party.php";

$party = new Party();
$parties_result = $party->read();
$all_id = [];

if(!empty($parties_result)) {
    $parties = $parties_result->fetch_all(MYSQLI_ASSOC);
    foreach ($parties as $party) {
        array_push($all_id, $party['id']);
    }
}


if (!isset($_GET['party_id'])) {
    header('location: 404.php');
    die;
}elseif (!in_array($_GET['party_id'], $all_id)) {
    header('location: 404.php');
    die;
}elseif (!ctype_digit($_GET['party_id'])){
    header('location: 404.php');
    die;
}

$party_id = $_GET['party_id'];
$_SESSION['party_id'] = $party_id;


if(isset($_POST['book_tiket'])){
    if(isset($_SESSION['user'])){
        header('location:number_Tikets.php');die;
    }else{
        header('location:register.php');die;
    }
}

$party = new Party();
$parties_result = $party->read_party_by_id();


if(!empty($parties_result)) {
    $parties = $parties_result->fetch_all(MYSQLI_ASSOC);
    foreach($parties as $party){
        
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
        <a href="admin.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="collection.php"><i class="fa-regular fa-address-card"></i> Collections</a>
        <a href=""><i class="fa-solid fa-user"></i> Sign out</a>
    </aside>
    <section class="Tiket-data text-center">
        <div class="container">
            <div class="row mt-5">
                <div class="col-12">
                    <img class="mb-4 mt-5" src="Images/WhatsApp_Image_2023-05-02_at_00.27.08-removebg-preview (1).png"
                        alt="">
                    <h2 class="mb-0">Welcome to GetPass Tickets</h2>
                </div>
            </div>
            
            <div class="row text-center mt-4 gy-5 align-items-center">
                <div class="col-12 col-md-4 offset-md-2  ps-md-0">
                    <div class="imgMask">
                        <div class="img">
                            <img src="<?= $party['image'] ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5 data-tiket text-start text-light">
                    <label for="">Party Name</label>
                    <p class="fs-4 pb-4 name-party mb-0"><?= $party['name'] ?></p>
                    <div class="time d-flex justify-content-between align-items-center pt-3 ">
                        <p class="border border-0 mb-0"><?= $party['date'] ?></p>
                        <p><?= $party['time'] ?></p>
                    </div>
                    <p class="fs-4 pb-4 name-party mb-0"><?= $party['location'] ?></p>
                    <p class="fs-4 pb-4 name-party mb-0"><?= $party['description'] ?></p>

                    <div class="price d-flex justify-content-between align-items-center">
                        <p class="border border-0 text-light pt-3 pb-0 fs-4">price</p>
                        <p class="border border-1 mt-3 ps-3 pe-3 pt-1 pb-1"><?= $party['price'] ?>LE</p>
                    </div>
                </div>
                <div class="offset-md-2 col-md-9 col-11 ps-md-0 mt-4">
                    <h3 class="text-light text-start">Book your tickets</h3>
                </div>
                <div class="offset-md-2 col-md-9 col-11 pt-3 pb-3 mb-5 mt-0 box-submit">
                    <div class="d-flex justify-content-between align-items-center flex-wrap ">
                        <p class="mb-md-0 text-light fs-4 partyname"><i class="fa-solid fa-user fs-5 icon"></i> 
                        <?= $party['name'] ?>
                        </p>
                        <p class="text-light mb-md-0 date"><?= $party['date'] ?> - <?= $party['time'] ?></p>
                        <form method="POST">
                        <button name="book_tiket" class="btn float-end p-0" class="text-decoration-none text-light p-md-4 pt-2 pb-2">
                                Book Tiket</button>
                        </form>
                    </div>
                </div>
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

<?php
ob_end_flush();
?>