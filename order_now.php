<?php
require_once "./php/db_connect.php";

session_start();

function orderNow(
    $conn,
    $name,
    $email,
    $mobile_number,
    $address_1,
    $address_2,
    $order_type,
    $order_id
){
    $insertQuery = 'INSERT INTO orders (user_name, email, mobile_number, location1, location2, order_type, order_type_id) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param('ssssssi', $name, $email, $mobile_number, $address_1, $address_2, $order_type, $order_id);
    if($insertStmt->execute()){
        echo "<script>alert('Order Placed');</script>";
        header('Location: ./products.php');
        exit();
    }
    header('Location: ./products.php');
    exit();

}

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(
        isset($_POST['name']) &&
        isset($_POST['email']) &&
        isset($_POST['mobile-number']) &&
        isset($_POST['address-1']) &&
        isset($_POST['address-2']) &&
        isset($_POST['order_now_type']) &&
        isset($_POST['order_now_id'])
    ){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile_number = $_POST['mobile-number'];
        $address_1 = $_POST['address-1'];
        $address_2 = $_POST['address-2'];
        $orderNowType = $_POST['order_now_type'];
        $orderNowId = $_POST['order_now_id'];
        
        orderNow(
            $conn,
            $name,
            $email,
            $mobile_number,
            $address_1,
            $address_2,
            $orderNowType,
            $orderNowId
        );
    }
    else {
        header('Location: ./products.php');
        exit();
    }
}


if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $order_type = 'product';
    if(isset($_GET['product_id'])){
        $_SESSION['order_now_type'] = 'product';
        $_SESSION['order_now_id'] = (int)$_GET['product_id'];
        $product_id = (int)$_GET['product_id'];

        $selectQuery = 'SELECT * FROM products WHERE id = ?';
        $selectStmt = $conn->prepare($selectQuery);
        $selectStmt->bind_param('i', $product_id);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        if($result && $result->num_rows > 0){
            $product = $result->fetch_assoc();
            $result->close();
        }
    }else if(isset($_GET['service_id'])){
        $_SESSION['order_now_type'] = 'service';
        $_SESSION['order_now_id'] = $_GET['service_id'];
        $service_id = (int)$_GET['service_id'];

        $selectQuery = 'SELECT * FROM services WHERE id = ?';
        $selectStmt = $conn->prepare($selectQuery);
        $selectStmt->bind_param('i', $service_id);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        if($result && $result->num_rows > 0){
            $service = $result->fetch_assoc();
            $result->close();
        }    
    }else if(isset($_GET['plant'])){
        $_SESSION['order_now_type'] = 'plant';
        $_SESSION['order_now_id'] = $_GET['plant'];
        if(
            !isset($_SESSION['total_estimation']) ||
            !isset($_SESSION['no-of-panel']) ||
            !isset($_SESSION['grid-type'])
        ){
            header('Location: ./cost_calculator.php');
            exit();
        }
    }else{
        // header('Location: ./products.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Now</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./styles/order_now.css">
</head>
<body>

    <?php require_once "./php/header.php"; ?>
    <div class="order-now-container">
        <form id="order-now-form" method="post">
            <h1 class="order-now-header"><img src="./assets/images/order_now_header.png" alt="">Place Order</h1>
    
            <!-- <div class="input-container">
    
            </div> -->

            <input type="text" name="order_now_type" style="display: none;" value="<?php echo $_SESSION['order_now_type']; ?>">
            <input type="number" name="order_now_id" style="display: none;" value="<?php echo $_SESSION['order_now_id']; ?>">
    
            <div class="input-group">
                <label for="">Name</label>
                <div class="row">
                    <div class="input-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <input type="text" name="name" placeholder="Name" required>
                </div>
            </div>
            
    
            <div class="input-group">
                <label for="">Email</label>
                <div class="row">
                    <div class="input-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
            </div>
    
            <div class="input-group">
                <label for="">Phone Number</label>
                <div class="row">
                    <div class="input-icon">
                        <i class="fa-solid fa-square-phone"></i>
                    </div>
                    <input type="number" name="mobile-number" placeholder="Phone Number" required>
                </div>
            </div>
    
            <div class="input-group">
                <label for="">Address 1</label>
                <div class="row">
                    <div class="input-icon">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <input type="text" name="address-1" placeholder="Address" required>
                </div>
            </div>
    
            <div class="input-group">
                <label for="">Address 2</label>
                <div class="row">
                    <div class="input-icon">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <input type="text" name="address-2" placeholder="Address 1" required>
                </div>
            </div>
    
    
            <div class="order-detail-container">
                <div class="order-detail-heading">Order Details</div>
                <?php
                if(isset($_GET['product_id'])){
                    echo "<script>let productPrice = ".$product['price'].";</script>";
                    echo '<div class="product-item">
                        <img class="product-img" src="./uploads/images/'.$product['product_img'].'">
                        <div class="product-info">
                            <div class="product-name">'.$product['product_name'].'</div>
                            <div class="product-cost">Total Cost '.$product["price"].'</div>
                            <div class="product-qty-container">
                                <div id="qty-decrease"><</div>
                                <div id="qty-container"><span>1</span>x</div>
                                <div id="qty-increase">></div>
                            </div>
                        </div>
                    </div>';
                }
                else if(isset($_GET['service_id'])){
                    echo '<div class="service-item">
                        <img class="service-img" src="./uploads/images/'.$service['service_img'].'">
                        <div class="service-info">
                            <p>'.$service['service_title'].'</p>
                        </div>
                    </div>';
                }
                else if(isset($_GET['plant'])){
                    echo '<div class="solar-plant-item">
                            <div class="solar-plant-info">
                                <p>'.$_SESSION['no-of-panel'].'x panel</p>
                                <p>Material Cost</p>
                                <p>Installation</p>
                                <p>Warranty</p>
                                '.($_SESSION["grid-type"]==='off-grid' ? "<p>OffGrid (Battery)</p>" : "" ).'
                            </div>
                            <div class="solar-plant-cost">
                                <p>Total Estimated Cost: ₹ '.$_SESSION['total_estimation'].'</p>
                                <p class="solar-plant-gst">GST @18%</p>
                            </div>
                        </div>';
                        // echo $_SESSION["grid-type"];
                }
                ?>
            </div>
            
            <button type="submit" id="place-order">Place Order</button>
        </form>

    </div>
    
    <?php require_once "./php/footer.php"; ?>

    <script>
        var qty_container = document.querySelector('#qty-container span');
        var qty_decrease = document.getElementById('qty-decrease');
        var qty_increase = document.getElementById('qty-increase');
        var product_cost = document.querySelector('.product-cost');

        qty_decrease.addEventListener('click', function (event){
            if(parseInt(qty_container.innerText) > 1){
                qty_container.innerText = parseInt(qty_container.innerText) - 1;
                product_cost.textContent = 'Total Cost '+(parseInt(qty_container.innerText) * productPrice);
            }
        });

        qty_increase.addEventListener('click', function (event){
            qty_container.innerText = parseInt(qty_container.innerText) + 1;
            product_cost.textContent = 'Total Cost '+(parseInt(qty_container.innerText) * productPrice);
        });

        document.addEventListener("DOMContentLoaded", (event) => {
            <?php
                if(isset($_SESSION['error'])){
                    echo "<script>alert(error);</script>";
                }
            ?>
        });

    </script>

    <script src="./scripts/order_now.js"></script>
</body>
</html>