<?php

error_reporting(E_ALL);

if(isset($_SESSION) AND isset($_SESSION['crisdaSession'])){
    header('Location: products.php');
}else{
    header('Location: login.php');
}