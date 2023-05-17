<?php
session_start();

include_once __DIR__."../../database/config.php";
include_once __DIR__."../../database/operations.php";
include_once __DIR__."../../models/user.php";
include_once __DIR__."../../models/admin.php";

if(isset($_SESSION['user'])){
$_SESSION['user']->email;
}

if(isset($_POST['ather_people'])){
    $user_object = new User();
    $user_object->setAther_people($_POST['ather_people']);
    $user_object->setEmail($_SESSION['user']->email);
    $result = $user_object->add_ather_people();
    if($result){
        header('location: ../../sure_Tiket.php');
    }else{
        header('location: ../../number_Tikets.php');
    }
} else {
    echo 'Please select number of other people.';die;
}