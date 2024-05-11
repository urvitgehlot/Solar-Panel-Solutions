<?php

require_once "./php/db_connect.php";

session_start();

if(
    !isset($_SESSION['location']) ||
    !isset($_SESSION['open-roof-width']) ||
    !isset($_SESSION['open-roof-height']) ||
    !isset($_SESSION['monthly-consuption']) ||
    !isset($_SESSION['unit-cost']) ||
    !isset($_SESSION['panel-type']) ||
    !isset($_SESSION['no-of-panel']) ||
    !isset($_SESSION['grid-type'])
){
    header('Location: ./cost_calculator.php');
    exit();
}

function insertSolarPlant(
    $conn,
    $location,
    $size_of_roof,
    $consumption,
    $unit_cost,
    $panel_type,
    $no_of_panel,
    $on_grid,
    $panel_price,
    $installation,
    $material_cost,
    $on_grid_cost,
    $warranty_gst,
    $total_estimation
){
    $insertQuery = 'INSERT INTO plants (location, size_of_roof, consumption, unit_cost, panel_type, no_of_panel, on_grid, panel_price, installation, material_cost, on_grid_cost, warranty_gst, total_estimation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param(
        'sdidsiidddddd',
        $location,
        $size_of_roof,
        $consumption,
        $unit_cost,
        $panel_type,
        $no_of_panel,
        $on_grid,
        $panel_price,
        $installation,
        $material_cost,
        $on_grid_cost,
        $warranty_gst,
        $total_estimation
    );
    if(!$insertStmt->execute()){
        header('Location: ./cost_calculator.php');
        exit();
    }

    return $conn->insert_id;

}


function getSunData($location){
    try {
        $date = date('Y-m-d');
        $apiKey = 'YOUR API KEY';
    
        $url = "https://api.weatherapi.com/v1/astronomy.json?key=$apiKey&q=$location&dt=$date";
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
    
        
        curl_close($ch);
        
        $result = json_decode($result,true);
        
        if(isset($result['error'])){
            header('Location: ./cost_calculator.php');
            exit();
        }
        
        $sunrise = DateTime::createFromFormat('h:i A', $result['astronomy']['astro']['sunrise']);
        $sunset = DateTime::createFromFormat('h:i A', $result['astronomy']['astro']['sunset']);
    
        $diff = $sunset->diff($sunrise);
    
        // echo json_encode(['success'=>true, 'hours'=>(int)($diff->format('%h'))-2, 'minutes'=>(int)($diff->format('%i'))]);
        return (int)($diff->format('%h'))-2;
    } catch (Exception $e) {
        header('Location: ./cost_calculator.php');
        exit();
    }
}


$areaOfRoof = $_SESSION['open-roof-width'] * $_SESSION['open-roof-height'];
$perPanelCost = 0;

$panelWatt = 0;
if($_SESSION['panel-type'] === '60 cell'){
    $panelWatt = 250;
    $perPanelCost = 8500;
}else{
    $panelWatt = 350;
    $perPanelCost = 10500;
}

$inverterCost = (100 * $_SESSION['no-of-panel'])+25000;
$materialCost = (800 * $_SESSION['no-of-panel'])+1000;
$installation = (1000 * $_SESSION['no-of-panel'])+5000;
$onGridPrice = 0;
if($_SESSION['grid-type'] === 'off-grid' ){
    $onGridPrice = (10000 * $_SESSION['no-of-panel'])+15000;
}
$panelsCost = $perPanelCost * $_SESSION['no-of-panel'];
$warrantyAndGst = ceil(($materialCost + $installation + $onGridPrice + $panelsCost + $inverterCost) * 24 / 100) + 10000;

$totalEstimation = $materialCost + $installation + $onGridPrice + $panelsCost + $inverterCost + $warrantyAndGst;

$_SESSION['total_estimation'] = $totalEstimation;

$saving = (($_SESSION['no-of-panel'] * $panelWatt * 30 * (int)(getSunData($_SESSION['location'])) )/ 1000)* $_SESSION['unit-cost'];



// $saving = $_SESSION['monthly-consuption'];

$recoveryTime = number_format(($totalEstimation / $saving)/12, 1) ;

$id = insertSolarPlant(
    $conn,
    $_SESSION['location'],
    $areaOfRoof,
    $_SESSION['monthly-consuption'],
    $_SESSION['unit-cost'],
    $_SESSION['panel-type'],
    $_SESSION['no-of-panel'],
    $_SESSION['grid-type'] === 'on-grid' ? 1: 0,
    $perPanelCost,
    $installation,
    $materialCost,
    $onGridPrice,
    $warrantyAndGst,
    $totalEstimation
);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./styles/cost_result.css">
</head>
<body>

    <?php include_once "./php/header.php"; ?>
    <div class="cost-result-container">
        <div class="header">
            <h2>Estimation</h2>
            <div class="header-img-container"></div>
        </div>

        <div class="cost-result">
            <div class="cost-calculation-result">
                <h2>Total Estimated Cost: ₹ <?php echo $totalEstimation; ?></h2>
                <div class="result-group">
                    <div class="row">
                        <ul>
                            <li><span><i class="fa-solid fa-circle"></i></span>Panel: <?php echo $_SESSION['no-of-panel']; ?> x <?php echo $perPanelCost; ?>: </li>
                            <li><span><i class="fa-solid fa-circle"></i></span>Inverter: </li>
                            <li><span><i class="fa-solid fa-circle"></i></span>Material Cost: </li>
                            <li><span><i class="fa-solid fa-circle"></i></span>Installation: </li>
                            <li><span><i class="fa-solid fa-circle"></i></span>OnGrid (Batteries): </li>
                            <li><span><i class="fa-solid fa-circle"></i></span>Warranty + GST @ 24%: </li>
                        </ul>
                        <ul>
                            <li>₹ <?php echo $panelsCost; ?></li>
                            <li>₹ <?php echo $inverterCost; ?></li>
                            <li>₹ <?php echo $materialCost; ?></li>
                            <li>₹ <?php echo $installation; ?></li>
                            <li>₹ <?php echo $onGridPrice; ?></li>
                            <li>₹ <?php echo $warrantyAndGst; ?></li>
                        </ul>
                    </div>
                </div>
                <h2>Recovery</h2>
                <div class="result-group">
                    <div class="row">
                        <ul>
                            <li><span><i class="fa-solid fa-circle"></i></span>Estimated Recovery Time: </li>
                            <li><span><i class="fa-solid fa-circle"></i></span>Saving: </li>
                        </ul>
                        <ul>
                            <li><?php echo $recoveryTime; ?> Years</li>
                            <li>₹ <?php echo $saving; ?></li>
                        </ul>
                    </div>
                </div>

                <div class="button-group-row">
                    <button onclick="print();">Print</button>
                    <a href="./order_now.php?plant=<?php echo $id; ?>">
                        <button id="order-now-btn">Order Now</button>
                    </a>
                </div>
            </div>
            <div class="call-executives-container">
                <img src="./assets/images/executives.png" alt="">
                <button onclick="window.location.href = 'tel:+911234567890';">Call Our Executives</button>
            </div>
        </div>
    </div>

    <?php include_once "./php/footer.php"; ?>
</body>
</html>