<?php

include_once __DIR__."\app/database/config.php";
include_once __DIR__."\app/database/operations.php";
include_once __DIR__."\app/models/user.php";

$available_pages = ['register', 'forget_password'];
if($_GET){
    if(isset($_GET['page'])){
        if(!in_array($_GET['page'], $available_pages)){
            header('location:404.php');die;
        }
    }else{
        header('location:404.php');die;
    }
}else{
    header('location:404.php');die;
}

if(isset($_POST['code'])){

    $errors = [];

    if(empty($_POST['code'])){
        $errors['required'] = "Please enter the code";
    } elseif(strlen($_POST['code']) != 5){
        $errors['digits'] = "Code must be 5 digits";
    }


    if(empty($errors)){
        $user_object = new User();
        $user_object->setCode($_POST['code']);
        $user_object->setEmail($_SESSION['user_email']);
        $result = $user_object->checkCode();
        if($result){
            $user_object->setStatus(1);
date_default_timezone_set('Africa/Cairo');
$user_object->setEmail_verified_at(date('Y-m-d H:i:s'));
$result = $user_object->make_user_verified();
            if($result){
                if($_GET['page'] == 'register'){
                    unset($_SESSION['user_email']);
                    header('location: sign.php');die;
                }elseif($_GET['page'] == 'forget_password'){
                    header('location: reset_password.php');die;
                }
            }else{
                $errors['somthinge'] = "Somthinge worng";
            }
        }else{
            $errors['wrong'] = "Wrong Code";
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
    <title>Document</title>
    <link rel="stylesheet" href="Css/check_code.css">
</head>
<body>
<div class="login-register-area ptb-100">
<div class="container">
<div class="row">
    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
        <div class="login-register-wrapper">
            <div class="login-register-tab-list nav">
                <a class="active" data-toggle="tab" href="#lg1">
                    <h4></h4>
                </a>
            </div>
            <div class="tab-content">
                <div id="lg1" class="tab-pane active">
                    <div class="login-form-container">
                        <div class="login-register-form">
                            <form method="post">
                                <input type="code" min="10000" max="99999" name="code" placeholder="Enter Verification Code">
                                <?php if(!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <?php foreach($errors as $error): ?>
                                        <p><?php echo $error; ?></p>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                                <div class="button-box">
                                    <button type="submit"><span>Verify</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</body>
</html>

<style>
    input[type="code"] {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%;
    margin-bottom: 20px;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

.alert {
    color: #a94442;
    background-color: #f2dede;
    border: 1px solid #ebccd1;
    border-radius: 4px;
    padding: 15px;
    margin-bottom: 20px;
    text-align: center;
    font-weight: 600;
}

.alert p {
    margin: 0;
    padding: 0;
}

</style>