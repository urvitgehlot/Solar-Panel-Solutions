<?php

session_start();

if(!isset($_SESSION['logined'])){
    unset($_SESSION['logined']);
    session_unset();
    session_destroy();
    header('Location: ./index.php');
    exit();
}



?>