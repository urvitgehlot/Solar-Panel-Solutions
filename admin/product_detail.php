<?php
    require_once '../php/db_connect.php';
    require_once './php/authentication.php';

    session_start();

    function updateProductDetail(
        $conn,
        $product_name,
        $product_cat,
        $price,
        $rating,
        $product_img=null
    ) {
        $product_id = $_SESSION['admin_product_id'];
        if($product_img != null){
            $updateQuery = 'UPDATE products SET product_name = ?, product_img = ?, product_cat = ?, price = ?, rating = ? WHERE id = ?';
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('sssdii', $product_name, $product_img, $product_cat, $price, $rating, $product_id);
            if(!$updateStmt->execute()){
                echo "<script>alert('Database Error');</script>";
                return;
                // exit();
            }
        }else {
            $updateQuery = 'UPDATE products SET product_name = ?, product_cat = ?, price = ?, rating = ? WHERE id = ?';
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('ssdii', $product_name, $product_cat, $price, $rating, $product_id);
            if(!$updateStmt->execute()){
                echo "<script>alert('Database Error');</script>";
                return;
                // exit();
            }
        }
        echo "<script>alert('Product Updated');</script>";

    }
    
    function insertProduct(
        $conn,
        $product_name,
        $product_cat,
        $price,
        $rating,
        $product_img=null
    ) {
        $insertQuery = 'INSERT INTO products (product_name, product_img, product_cat, price, rating) VALUES (?, ? , ? , ?, ?)';
        $updateStmt = $conn->prepare($insertQuery);
        $updateStmt->bind_param('sssdi', $product_name, $product_img, $product_cat, $price, $rating);
        if(!$updateStmt->execute()){
            echo "<script>alert('Database Error');</script>";
            return;
            // exit();
        }
        echo "<script>alert('Product Updated');</script>";

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(isset($_SESSION['admin_new_product'])){
            $product_name = $_POST['product-name'];
            $product_cat = $_POST['product-cat'];
            $product_rating = $_POST['rating'];
            $product_price = $_POST['price'];

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
                    insertProduct(
                        $conn,
                        $product_name,
                        $product_cat,
                        $product_price,
                        $product_rating,
                        $target_file_name
                    );
                    echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }


        }else{

            $product_name = $_POST['product-name'];
            $product_cat = $_POST['product-cat'];
            $product_rating = $_POST['rating'];
            $product_price = $_POST['price'];
    
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
                        updateProductDetail(
                            $conn,
                            $product_name,
                            $product_cat,
                            $product_price,
                            $product_rating,
                            $target_file_name
                        );
                        echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
            else {
                updateProductDetail(
                    $conn,
                    $product_name,
                    $product_cat,
                    $product_price,
                    $product_rating
                );
            }

        }        


    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['id'])){
            $_SESSION['admin_product_id'] = $_GET['id'];
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $product = [];
            
            $selectQuery = 'SELECT * FROM products WHERE id = ?';
            $selectStmt = $conn->prepare($selectQuery);
            $selectStmt->bind_param('i', $id);
            $selectStmt->execute();
            $result = $selectStmt->get_result();
            if($result->num_rows > 0){
                $product = $result->fetch_assoc();
            }
            else{
                unset($_SESSION['admin_product_id']);
                unset($_SESSION['admin_new_product']);
                header('Location: ./products.php');
                exit();
            }
        }
        else if(isset($_GET['new_product'])){
            $_SESSION['admin_new_product'] = true;
            
        }
        else{
            unset($_SESSION['admin_product_id']);
            unset($_SESSION['admin_new_product']);
            header('Location: ./products.php');
            exit();
        }
    }
    else{
        unset($_SESSION['admin_product_id']);
        unset($_SESSION['admin_new_product']);
        header('Location: ./products.php');
        exit();
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./styles/product_detail.css">
</head>
<body>
    
    <?php require_once "./php/nav_bar.php"; ?>
    <div class="container mt-5">
        <form action="" method="POST" id="product-form" enctype="multipart/form-data">
            <h1 class="text-center">Product Detail</h1>
            <div class="row">
                <div class="col-6 mx-auto">
                    <label for="" class="form-label">Product Image</label>
                    <img class="img-thumbnail" <?php echo isset($product["product_img"]) ? 'src="../uploads/images/' . $product["product_img"]. '"' : ''; ?> alt="Image Preview">
                    <input type="file" accept="image/png, image/jpg" name="image" id="image-input" class="form-control" <?php echo isset($product["product_img"]) ? '' : 'required' ?> >
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="" class="form-label">Product Name</label>
                    <input type="text" name="product-name" class="form-control" value="<?php echo isset($product['product_name']) ? $product['product_name'] : ''; ?>" required>
                </div>
                <div class="col">
                    <label for="" class="form-label">Product Cat</label>
                    <select class="form-select" name="product-cat" aria-label="Default select example" required>
                        <option value="equipment" <?php echo isset($product['product_cat']) ? ($product['product_cat'] === 'equipment' ? 'selected': '' ): 'selected'; ?>>Equipment</option>
                        <option value="panels" <?php echo isset($product['product_cat']) ? ($product['product_cat'] === 'panels' ? 'selected': '' ): ''; ?>>Panels</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="" class="form-label">Product Rating</label>
                    <div class="rating-container">
                        <div class="star">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="star">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="star">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="star">
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <div class="star">
                            <i class="fa-regular fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <label for="" class="form-label">Product Price</label>
                    <input type="number" name="price" class="form-control" value="<?php echo isset($product['price']) ? $product['price'] : ''; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <?php 
                    if(isset($product['id'])){
                        echo '<a href="./delete_request.php?product_id='. $product["id"].'" class="btn btn-danger">
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
        var ratingStars = document.querySelectorAll('.star i');

        function resetRating(i){
            var rating = document.getElementById('rating');

            if(rating){
                rating.value = i+1;
            }
            else {
                var rating = document.createElement('input');
                rating.type = 'text';
                rating.name = 'rating';
                rating.id = 'rating';
                rating.value = i+1;
                document.getElementById('product-form').appendChild(rating);
            }
            
            for (let index = 0; index < ratingStars.length; index++) {
                if(index <= i){
                    ratingStars[index].classList.replace('fa-regular', 'fa-solid');
                }else{
                    ratingStars[index].classList.replace('fa-solid', 'fa-regular');
                }
            }
        }

        for (let index = 0; index < ratingStars.length; index++) {
            ratingStars[index].addEventListener('click', function (event){
                resetRating(index);
            });
            
        }

        resetRating(<?php echo( isset($product['rating']) ? $product['rating'] : 0) -1; ?>);

        document.getElementById('image-input').addEventListener('change', function (event) {
            document.querySelector('#product-form img').src = URL.createObjectURL(this.files[0]);
        });
    </script>
</body>
</html>