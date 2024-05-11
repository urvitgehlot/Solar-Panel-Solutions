<?php
    require_once './php/db_connect.php';


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./styles/products.css">

</head>
<body>

    <?php include_once "./php/header.php"; ?>

    <div class="products-container">
        <div class="hero-section">
            <div class="hero-container-1 hero-container">
                <div class="feature-container">
                    <h1>Best and Affordable<br>Solar Panels</h1>
                    <p>A good example of a paragraph contains a topic sentence, details and a conclusion. 'There are many different kinds of animals that live in China. Tigers and leopards are animals that live in China's forests in the north. In the jungles, monkeys swing in the trees and elephants walk through the brush.</p>
                </div>
                <img src="./assets/images/product-hero-1.png" alt="">
            </div>

            <div class="hero-container-2 hero-container">
                <div class="feature-container">
                    <h1>Best and Affordable<br>Solar Equipments</h1>
                    <p>A good example of a paragraph contains a topic sentence, details and a conclusion. 'There are many different kinds of animals that live in China. Tigers and leopards are animals that live in China's forests in the north. In the jungles, monkeys swing in the trees and elephants walk through the brush.</p>
                </div>
                <img src="./assets/images/product-hero-2.png" alt="">
            </div>
        </div>

        <div class="products">
            <div class="product-cat">
                <h2>Panels</h2>
                <div class="scrolling-container">

                    <i class="scrolling-arrow-left fa-solid fa-chevron-left"></i>
                    <div class="scrolling-product-list" style="transform: translateX(0px);">

                        <?php
                            $query = "SELECT * FROM products WHERE product_cat = 'panels'";
                            $selectStmt = $conn->prepare($query);
                            $selectStmt->execute();
                            $result = $selectStmt->get_result();

                            while( $row = $result->fetch_assoc() ){
                                echo '<div class="product">
                                    <img src="./uploads/images/'.$row['product_img'].'" alt="">
                                    <h3>'.$row["product_name"].'</h3>
                                    <span>₹ '.$row["price"].'</span>
                                    <div class="rating">';

                                for( $i = 1; $i <= 5; $i++){
                                    if($i <= $row['rating']){
                                        echo '<div class="star">
                                                <img src="./assets/images/star.png" alt="">
                                            </div>';
                                    }else{
                                        echo '<div class="star"></div>';
                                    }
                                }
                                echo '</div>
                                <a href="./order_now.php?product_id='.$row["id"].'">
                                    <button class="buy-button">BUY</button>
                                </a>
                            </div>';
                            }
                        ?>
                    </div>
                    <i class="scrolling-arrow-right fa-solid fa-chevron-right"></i>
                </div>
            </div>

            <div class="product-cat">
                <h2>Equipments</h2>
                <div class="scrolling-container">
                    <i class="scrolling-arrow-left fa-solid fa-chevron-left"></i>
                    <div class="scrolling-product-list" style="transform: translateX(0px);">
                        <?php
                            $query = "SELECT * FROM products WHERE product_cat = 'equipment'";
                            $selectStmt = $conn->prepare($query);
                            $selectStmt->execute();
                            $result = $selectStmt->get_result();

                            while( $row = $result->fetch_assoc() ){
                                echo '<div class="product">
                                    <img src="./uploads/images/'.$row['product_img'].'" alt="">
                                    <h3>'.$row["product_name"].'</h3>
                                    <span>₹ '.$row["price"].'</span>
                                    <div class="rating">';

                                for( $i = 1; $i <= 5; $i++){
                                    if($i <= $row['rating']){
                                        echo '<div class="star">
                                                <img src="./assets/images/star.png" alt="">
                                            </div>';
                                    }else{
                                        echo '<div class="star"></div>';
                                    }
                                }
                                echo '</div>
                                <a href="./order_now.php?product_id='.$row["id"].'">
                                    <button class="buy-button">BUY</button>
                                </a>
                            </div>';
                            }
                        ?>
                    </div>
                    <i class="scrolling-arrow-right fa-solid fa-chevron-right"></i>
                </div>
            </div>

        </div>

    </div>
    <?php include_once "./php/footer.php";?>

    <script src="./scripts/products.js"></script>
</body>
</html>