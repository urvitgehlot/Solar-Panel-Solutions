<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(
        isset($_POST['location']) &&
        isset($_POST['open-roof-width']) &&
        isset($_POST['open-roof-height']) &&
        isset($_POST['monthly-consuption']) &&
        isset($_POST['unit-cost']) &&
        isset($_POST['panel-type']) &&
        isset($_POST['no-of-panel']) &&
        isset($_POST['grid-type'])
    ){
        session_start();
        $_SESSION['location'] = $_POST['location'];
        $_SESSION['open-roof-width'] = $_POST['open-roof-width'];
        $_SESSION['open-roof-height'] = $_POST['open-roof-height'];
        $_SESSION['monthly-consuption'] = $_POST['monthly-consuption'];
        $_SESSION['unit-cost'] = $_POST['unit-cost'];
        $_SESSION['panel-type'] = $_POST['panel-type'];
        $_SESSION['no-of-panel'] = $_POST['no-of-panel'];
        $_SESSION['grid-type'] = $_POST['grid-type'];

        header('Location: ./cost_result.php');
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost Calculator</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./styles/cost_calculator.css">
</head>
<body>
    <?php include_once "./php/header.php";?>
    <div class="cost-calculator-container">
        <div class="header">
            <h2>Cost Calculator</h2>
            <div class="header-img-container"></div>
        </div>

        <form action="cost_calculator.php" method="post" onsubmit="return submitForm();">
            <div class="input-group location-group">
                <label for="location">Location</label>
                <div class="input-row">
                    <div class="input-box-container">
                        <div class="input-box-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <input type="text" id="location" name="location" placeholder="Shastri Nagar, Jodhpur (Raj.)" required>
                    </div>
                    <div class="verified-icon">
                        <i class="fa-solid"></i>
                    </div>
                </div>
            </div>
    
            <div class="input-group open-roof-group">
                <label for="">Size of Open Roof</label>
                <div class="input-row">
                    <div class="input-box-container open-roof-width">
                        <div class="input-box-icon">
                            <i class="fa-solid fa-w"></i>
                        </div>
                        <input type="number" name="open-roof-width" placeholder="30" required>
                    </div>
                    <div style="margin-left: 40px;" class="input-box-container open-roof-height">
                        <div class="input-box-icon">
                            <i class="fa-solid fa-h"></i>
                        </div>
                        <input type="number" name="open-roof-height" placeholder="60" required>
                    </div>
                    <div class="verified-icon"></div>
                </div>
                <div class="input-description">
                    <p><i class="fa-solid fa-circle-info"></i>: Enter Size in Feets</p>
                </div>
            </div>
    
            <div class="input-group monthly-consuption-group">
                <label for="">Monthly Average Unit Consumption</label>
                <div class="input-row">
                    <div class="input-box-container">
                        <div class="input-box-icon">
                            <i class="fa-solid fa-chart-area"></i>
                        </div>
                        <input type="number" name="monthly-consuption" placeholder="550" required>
                    </div>
                    <div class="verified-icon"></div>
                </div>
            </div>
    
            <div class="input-group unit-cost-group">
                <label for="">Per Unit Cost</label>
                <div class="input-row">
                    <div class="input-box-container">
                        <div class="input-box-icon">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <input type="text" name="unit-cost" placeholder="₹ 11" required>
                    </div>
                    <div class="verified-icon"></div>
                </div>
            </div>
            
            <div class="input-group panel-type-group">
                <label for="">Panel Type</label>
                <div class="input-row">
                    <div class="input-column-container">
                        <div class="input-radio-group">
                            <input type="radio" name="panel-type" value="60 cell" id="60-cell" class="custom-radio panel-type-input" checked>
                            <label for="60-cell">60 Cells</label>
                        </div>
                        <div class="input-radio-group">
                            <input type="radio" name="panel-type" value="72 cell" id="72-cell" class="custom-radio panel-type-input">
                            <label for="72-cell">72 Cells</label>
                        </div>
                    </div>
                    <div class="verified-icon"></div>
                </div>
                <div class="input-description">
                    <p><i class="fa-solid fa-circle-info"></i>: Size of Panels</p>
                </div>
            </div>
    
            <div class="input-group">
                <label for="">Number of Panels</label>
                <div class="input-row">
                    <div class="slider-container">
                        <input type="range" class="no-of-panel-slider" min="0" max="100" name="no-of-panel" id="">
                        <span id="slider-value">8</span>
                    </div>
                    <div class="verified-icon"></div>
                </div>
                <div class="input-description">
                    <p><i class="fa-solid fa-circle-info"></i>: Recommended: <span id="recommended-panels">8</span></p>
                </div>
            </div>
    
            <div class="input-group">
                <label for="">Electricity Option</label>
                <div class="input-row">
                    <div class="input-column-container">
                        <div class="input-radio-group">
                            <input type="radio" name="grid-type" value="on-grid" id="on-grid" class="custom-radio" checked>
                            <label for="on-grid">On Grid</label>
                        </div>
                        <div class="input-radio-group">
                            <input type="radio" name="grid-type" value="off-grid" id="off-grid" class="custom-radio">
                            <label for="off-grid">Off Grid</label>
                        </div>
                    </div>
                    <div class="verified-icon"></div>
                </div>
                <div class="input-description">
                    <p><i class="fa-solid fa-circle-info"></i>: OnGrid (Without Battery) | OffGrid (With Battery)</p>
                </div>
            </div>
    
            <center>
                <button type="submit" class="sub-btn-cost-cal">Submit</button>
            </center>
        </form>

    </div>

    <script>
        var styles = [],
        style_el = document.createElement('style'),
        track_sel = ['::-webkit-slider-runnable-track'];

        window.onload = function() {
            var input = document.querySelector('.no-of-panel-slider');
            document.body.appendChild(style_el);

            styles.push('');

            input.addEventListener('input', function() {
                console.log(this.value);
                var min = this.min || 0,
                max = this.max || 100,
                c_style, u, edge_w, val, str = '';

                // this.setAttribute('value', this.value);
                this.setAttribute('value', this.value);

                // val = this.value + '% 100%';
                let calculatedPer = (this.value - min) * 100 / (max - min);
                val = calculatedPer + '% 100%';
                str += '.no-of-panel-slider' + track_sel[0] + '{background-size:' + val + '}';

                styles[0] = str;
                style_el.textContent = styles.join('');
                document.getElementById('slider-value').style.left = calculatedPer+'%';
                document.getElementById('slider-value').style.transform = "translateX(-"+ (calculatedPer) +"%)";
                document.getElementById('slider-value').textContent = this.value;
            }, false);
        }
    </script>

    <script src="./scripts/cost.js"></script>
</body>
</html>