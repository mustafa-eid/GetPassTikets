<?php

session_start();

unset($_SESSION['user']);
session_destroy();

unset($_SESSION['file']);
session_destroy();

if(isset($_COOKIE['remember_me'])){
    setcookie('remember_me', '', time() - 100, '/');
}

header('location: ../../sign.php');

?>