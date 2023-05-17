<?php
include_once __DIR__."../../database/config.php";
include_once __DIR__."../../database/operations.php";
include_once __DIR__."../../models/user.php";
include_once __DIR__."../../models/admin.php";



if(isset($_POST['login'])){



$email = $_POST['email'];
$password = $_POST['password'];

if ($email === 'Ahmed3bdo011@icloud.com' && $password === 'Ahmedabdo010') {
    $_SESSION['admin'] = $admin;
    header('Location: ../../admin.php');
    exit();
}


$user = new User();
$user->setEmail($_POST['email']);
$user->setPassword($_POST['password']);
$result = $user->login();
if($result){

    if(isset($_POST['remember_me'])){
        setcookie('remember_me', $_POST['email'], time() + (24*60*60) * 30 * 12, '/');
    }

    $user = $result->fetch_object();
    $_SESSION['user'] = $user;

    if(($_SESSION['user']->status) == 1){
        header('location: ../../index.php');
    }else{
        echo header('location: ../../check_code.php');
    }
} else {
    $_SESSION['error_message'] = "Invalid email or password";
    header('location: ../../sign.php');
    exit();
}
}
?>