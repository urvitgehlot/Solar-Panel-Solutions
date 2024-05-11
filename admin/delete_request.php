<?php

require_once '../php/db_connect.php';
require_once "./php/authentication.php";

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['product_id'])){
        $id = (int)$_GET['product_id'];
        $deleteQuery = 'DELETE FROM products WHERE id = ?';
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param('i',$id);
        if(!$deleteStmt->execute()){
            header('Location: ./index.php');
            exit();
        }
        header('Location: ./products.php');
        exit();
        
    }else if(isset($_GET['service_id'])){
        $id = (int)$_GET['service_id'];
        $deleteQuery = 'DELETE FROM services WHERE id = ?';
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param('i',$id);
        if(!$deleteStmt->execute()){
            header('Location: ./index.php');
            exit();
        }
        header('Location: ./services.php');
        exit();
    }
    else {
        header('Location: ./index.php');
        exit();
    }
}

?>