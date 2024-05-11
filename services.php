<?php
    require_once './php/db_connect.php';


?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="./styles/services.css">
</head>
<body>
    <?php include_once "./php/header.php"; ?>
    <div class="services-container">
        <div class="img-container">
            <div class="img-back-box"></div>
            <img src="./assets/images/solar2.jpg" alt="">
        </div>

        <h3>Solar Panel Solutions</h3>

        <h2>Services</h2>



        <?php
            $query = "SELECT * FROM services";
            $selectStmt = $conn->prepare($query);
            $selectStmt->execute();
            $result = $selectStmt->get_result();

            while( $row = $result->fetch_assoc() ){
                echo '<div class="service">
                    <div class="service-img-container">
                        <img src="./uploads/images/'.$row["service_img"].'" alt="">
                        <span>'.$row["service_name"].'</span>
                    </div>
                    <h4>'.$row["service_title"].'</h4>
                    <p>'.$row["service_desc"].'</p>
        
                    <a href="./order_now.php?service_id='.$row["id"].'"><button>Book Now</button></a>
                </div>';
            }
        ?>

        
    </div>
    <?php include_once "./php/footer.php";?>
</body>
</html>