<?php

require_once "../php/db_connect.php";
session_start();

if(isset($_SESSION['logined'])){
    header('location: ./orders.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $admin_name = $_POST['admin_name'];
    $password = $_POST['password'];

    $selectQuery = "SELECT * FROM admins where admin_name = ?";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param('s', $admin_name);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    if($result->num_rows > 0){
        $admin = $result->fetch_assoc();
        if($admin && password_verify($password ,$admin['password'])){
            $_SESSION['logined'] = true;
            header('Location: ./products.php');
            exit();
        }else{
            echo "<script>alert('Login Credentials Incorrect');</script>";
        }
    }else{
        echo "<script>alert('Login Credentials Incorrect');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container" style="background-color: #0001;">
        <form action="" method="post">
            <h1 class="text-center">Login</h1>
            <div class="row m-4 p-4">
                <div class="col">
                    <img class="img-fluid" src="../assets/images/solar5.jpg" alt="">
                </div>
                <div class="col d-flex flex-column justify-content-center">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Admin Name</span>
                        <input class="form-control" type="text" placeholder="admin username" name="admin_name" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Password</span>
                        <input class="form-control" type="password" placeholder="password" name="password" required>
                    </div>
                    <div class="button-group d-flex justify-content-center">
                        <button class="reset btn btn-danger  m-3">Reset</button>
                        <button type="submit" class="btn btn-primary m-3">Login</button>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</body>
</html>