<?php

if(isset($_SESSION['user'])){
    header("Location: 404.php");
    exit;
}