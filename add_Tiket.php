<?php
ob_start();
include_once __DIR__."\app/middleware/guest.php";



// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
        $errors = [];
        $success = false;

        // Validate name
    if (empty($_POST['name'])) {
        $errors['name'] = "Please enter a name";
    }

    
    if (empty($_POST['date'])) {
        $errors['date'] = "Please enter a date";
    }

    if (empty($_POST['time'])) {
        $errors['time'] = "Please enter a time";
    }else{

    }

    if (empty($_POST['location'])) {
        $errors['location'] = "Please enter a location";
    }

    if (empty($_POST['price'])) {
        $errors['price'] = "Please enter a price";
    }
    if (empty($_POST['description'])) {
        $errors['description'] = "Please enter a description";
    }

    if(empty($errors)){

        $name = $_POST['name'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $success = true;


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
        $image_path = "assets/parties_images/" . $image_name;
        move_uploaded_file($image_tmp_name, $image_path);
    } else {
        $errors['image'] = "Error uploading image";
        $image_path = "";
    }
}

// Insert the party data into the database
$db_host = 'localhost';
$db_name = 'real_project';
$db_user = 'root';
$db_pass = '';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

$sql = "INSERT INTO parties (name, date, time, location, price, description, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssdsss', $name, $date, $time, $location, $price, $description, $image_path, $status);
$stmt->execute(); 

if (empty($errors)) {
    // your code for database insertion here

    if ($stmt->affected_rows > 0) {
        $errors['party'] = '
        <div class="alert alert-success" role="alert">
        The ticket has been added successfully.!
        </div>';

        // clear input fields after successful insertion
        $_POST['name'] = '';
        $_POST['date'] = '';
        $_POST['time'] = '';
        $_POST['location'] = '';
        $_POST['price'] = '';
        $_POST['description'] = '';
    } else {
        echo "<div id='errorMsg'>Error creating party.</div>";
    }
}

$stmt->close();
$conn->close();


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
    <link rel="stylesheet" href="Css/AddTiket.css">
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
                        <li><a href="admin.php">Home</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <aside class="left-side">
        <div id="cancel">x</div>
        <a href="admin.php"><i class="fa-solid fa-house"></i>Home</a>
    </aside>
    <section class="modify-tiket text-center pb-5">
        <div class="container">
            <div class="row mt-5">
                <div class="col-12">
                    <img class="mb-4 mt-5" src="Images/WhatsApp_Image_2023-05-02_at_00.27.08-removebg-preview (1).png"
                        alt="">
                    <h2 class="mb-4">Welcome to GetPass Tickets</h2>
                </div>
            </div>

<?php if(isset($errors['party'])): ?>
    <div class="alert alert-success" role="alert" id="party-alert">
        <?php echo $errors['party']; ?>
    </div>
    <script>
        setTimeout(function(){
            document.getElementById('party-alert').style.display = 'none';
        }, 3000); 
    </script>
<?php endif; ?>

            <form method="POST" class="my-form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-6">
                        <div class="first">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                                <?php if(isset($errors['name'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo $errors['name']; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="last">
                            <div class="form-group">
                                <label for="date">Date:</label>
                                <input type="date" name="date" id="date" class="form-control"
                                    value="<?php echo isset($_POST['date']) ? htmlspecialchars($_POST['date']) : ''; ?>">
                                <?php if(isset($errors['date'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo $errors['date']; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="email">
                            <div class="form-group">
                                <label for="time">Time:</label>
                                <input type="time" name="time" id="time" class="form-control"
                                    value="<?php echo isset($_POST['time']) ? htmlspecialchars($_POST['time']) : ''; ?>">
                                <?php if(isset($errors['time'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo $errors['time']; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="email">
                            <div class="form-group">
                                <label for="location">Location:</label>
                                <input type="text" name="location" id="location" class="form-control"
                                    value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>">
                                <?php if(isset($errors['location'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo $errors['location']; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="email">
                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="number" name="price" id="price" step="0.01" class="form-control"
                                    value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">
                                <?php if(isset($errors['price'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo $errors['price']; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                    <div class="email">
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" class="form-control"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                            <?php if(isset($errors['description'])): ?>
                            <div class="invalid-feedback d-block">
                                <?php echo $errors['description']; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="email">
                                <div class="form-check">
                                    <label for="image">Image:</label>
                                    <input type="file" name="image" id="image" class="form-control"
                                        value="<?php echo isset($_POST['image']) ? htmlspecialchars($_POST['image']) : ''; ?>">
                                    <?php if(isset($errors['image'])): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo $errors['image']; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="email">
                            <div class="form-group">
                            <select name="status">
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="btn-register">
                            <button type="submit" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
    </section>
    <footer>
        <div class="container">
            <div class="row align-items-end">
                <div class="col-5 d-md-none footer-link">
                    <ul>
                        <li><a href="admin.php">Home</a></li>
                        <li><a href="about_us">About Us</a></li>
                        <li><a href="contact_us">Contact Us</a></li>
                        <li><a href="collection">Collections</a></li>
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