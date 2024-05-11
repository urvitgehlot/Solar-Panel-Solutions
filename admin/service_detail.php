<?php
    require_once '../php/db_connect.php';
    require_once './php/authentication.php';

    session_start();

    function updateServiceDetail(
        $conn,
        $service_name,
        $service_title,
        $service_desc,
        $service_img=null
    ) {
        $service_id = $_SESSION['admin_service_id'];
        if($service_img != null){
            $updateQuery = 'UPDATE services SET service_name = ?, service_img = ?, service_title = ?, service_desc = ? WHERE id = ?';
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('ssssi', $service_name, $service_img, $service_title, $service_desc, $service_id);
            if(!$updateStmt->execute()){
                echo "<script>alert('Database Error');</script>";
                return;
                // exit();
            }
        }else {
            $updateQuery = 'UPDATE services SET service_name = ?, service_title = ?, service_desc = ? WHERE id = ?';
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('sssi', $service_name, $service_title, $service_desc, $service_id);
            if(!$updateStmt->execute()){
                echo "<script>alert('Database Error');</script>";
                return;
                // exit();
            }
        }
        echo "<script>alert('Service Updated');</script>";

    }
    
    function insertService(
        $conn,
        $service_name,
        $service_title,
        $service_desc,
        $service_img=null
    ) {
        $insertQuery = 'INSERT INTO services (service_name, service_img, service_title, service_desc) VALUES (?, ? , ? , ?)';
        $updateStmt = $conn->prepare($insertQuery);
        $updateStmt->bind_param('ssss', $service_name, $service_img, $service_title, $service_desc);
        if(!$updateStmt->execute()){
            echo "<script>alert('Database Error');</script>";
            return;
            // exit();
        }
        echo "<script>alert('Service Updated');</script>";

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(isset($_SESSION['admin_new_service'])){
            $service_name = $_POST['service-name'];
            $service_title = $_POST['service-title'];
            $service_desc = $_POST['service-desc'];
            
            $target_dir = "../uploads/images/";
            $target_file_name = basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $target_file_name;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo( basename($_FILES["image"]["name"]) ,PATHINFO_EXTENSION));
    
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check!== false){
                echo "File is an Image - " . $check["mime"] . ".";
                $uploadOk = 1;
            }else{
                echo "File is not an Image.";
                $uploadOk = 0;
            }
    
            // if(file_exists($target_file)){
            //     echo "Sorry, file already exists.";
            //     $uploadOk = 0;
            // }

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    insertservice(
                        $conn,
                        $service_name,
                        $service_title,
                        $service_desc,
                        $target_file_name
                    );
                    echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }


        }else{
            $service_name = $_POST['service-name'];
            $service_title = $_POST['service-title'];
            $service_desc = $_POST['service-desc'];
    
            if(isset($_FILES['image']["name"]) && !empty($_FILES['image']["name"])){
                $target_dir = "../uploads/images/";
                $target_file_name = basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $target_file_name;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo( basename($_FILES["image"]["name"]) ,PATHINFO_EXTENSION));
        
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check!== false){
                    echo "File is an Image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                }else{
                    echo "File is not an Image.";
                    $uploadOk = 0;
                }
        
                // if(file_exists($target_file)){
                //     echo "Sorry, file already exists.";
                //     $uploadOk = 0;
                // }
    
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                    echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                    $uploadOk = 0;
                }
    
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                } else {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        updateServiceDetail(
                            $conn,
                            $service_name,
                            $service_title,
                            $service_desc,
                            $target_file_name
                        );
                        echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
            else {
                updateServiceDetail(
                    $conn,
                    $service_name,
                    $service_title,
                    $service_desc
                );
            }

        }        


    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['id'])){
            $_SESSION['admin_service_id'] = $_GET['id'];
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $service = [];
            
            $selectQuery = 'SELECT * FROM services WHERE id = ?';
            $selectStmt = $conn->prepare($selectQuery);
            $selectStmt->bind_param('i', $id);
            $selectStmt->execute();
            $result = $selectStmt->get_result();
            if($result->num_rows > 0){
                $service = $result->fetch_assoc();
            }
            else{
                unset($_SESSION['admin_service_id']);
                unset($_SESSION['admin_new_service']);
                header('Location: ./services.php');
                exit();
            }
        }
        else if(isset($_GET['new_service'])){
            $_SESSION['admin_new_service'] = true;
            
        }
        else{
            unset($_SESSION['admin_service_id']);
            unset($_SESSION['admin_new_service']);
            header('Location: ./services.php');
            exit();
        }
    }
    else{
        unset($_SESSION['admin_service_id']);
        unset($_SESSION['admin_new_service']);
        header('Location: ./services.php');
        exit();
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Detail</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./styles/service_detail.css">
</head>
<body>
    
    <?php require_once "./php/nav_bar.php"; ?>
    <div class="container mt-5">
        <form action="" method="POST" id="service-form" enctype="multipart/form-data">
            <h1 class="text-center">Service Detail</h1>
            <div class="row">
                <div class="col-6 mx-auto">
                    <label for="" class="form-label">Service Image</label>
                    <img class="img-thumbnail" <?php echo isset($service["service_img"]) ? 'src="../uploads/images/' . $service["service_img"]. '"' : ''; ?> alt="Image Preview">
                    <input type="file" accept="image/png, image/jpg" name="image" id="image-input" class="form-control" <?php echo isset($service["service_img"]) ? '' : 'required' ?> >
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="" class="form-label">Service Name</label>
                    <input type="text" name="service-name" class="form-control" value="<?php echo isset($service['service_name']) ? $service['service_name'] : ''; ?>" required>
                </div>
                <div class="col">
                    <label for="" class="form-label">Service Title</label>
                    <input type="text" name="service-title" class="form-control" value="<?php echo isset($service['service_title']) ? $service['service_title'] : ''; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="" class="form-label">Service Discription</label>
                    <input type="text" name="service-desc" class="form-control" value="<?php echo isset($service['service_desc']) ? $service['service_desc'] : ''; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php 
                    if(isset($service['id'])){
                        echo '<a href="./delete_request.php?service_id='. $service["id"].'" class="btn btn-danger">
                        Delete
                    </a>';
                    }
                    ?>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        
        document.getElementById('image-input').addEventListener('change', function (event) {
            document.querySelector('#service-form img').src = URL.createObjectURL(this.files[0]);
        });
    </script>
</body>
</html>