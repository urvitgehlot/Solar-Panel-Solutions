<?php

require_once "./php/send_email.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(
        isset($_POST['name']) &&
        isset($_POST['email']) &&
        isset($_POST['number']) &&
        isset($_POST['message'])
    ){

        $message = '<h1>Cotact Us</h1>
        <p style="font-weight: bold;">Name: <span style="font-weight: normal;">'.$_POST['name'].'</span></p>
        <p style="font-weight: bold;">Email: <span style="font-weight: normal;">'.$_POST['email'].'</span></p>
        <p style="font-weight: bold;">Phone Number: <span style="font-weight: normal;">'.$_POST['number'].'</span></p>
        <p style="font-weight: bold;">Message: <span style="font-weight: normal;">'.$_POST['message'].'</span></p>';

        if(
            !sendEmail(
                'urvitgehlot@gmail.com',
                'Contact Us',
                $message,
            ) || 
            !sendEmail(
                $_POST['email'],
                'Contact Us',
                $message,
            )
        ){
            echo '<script>alert("Email is not Correct");</script>';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./styles/contact_us.css">
</head>
<body>
    <?php include_once "./php/header.php"; ?>
    <div class="contact-us-container">
        <div class="get-in-touch-container">
            <form action="" id="contact-us-form" method="post">
                <div>
                    <h3>Get in Touch</h3>
                    <h2>Let's Chat, Reach Out to Us</h2>
                </div>
                
                <div class="input-group">
                    <label for="">Full Name</label>
                    <input type="text" name="name" placeholder="Exmaple Example" required>
                </div>

                <div class="input-group">
                    <label for="">E-Mail Address</label>
                    <input type="email" name="email" placeholder="example@email.com" required>
                </div>
                
                <div class="input-group">
                    <label for="">Phone Number</label>
                    <input type="number" name="number" placeholder="1010102345" required>
                </div>
                
                <div class="input-group">
                    <label for="">Message</label>
                    <textarea id="" name="message" placeholder="Message" required></textarea>
                </div>

                <center>
                    <button type="submit">Submit</button>
                </center>
            </form>
        </div>
        <div class="contact-and-img-container">
            <div class="contact-us-img-container">
                <img src="./assets/images/contact_us_image.png" alt="">
            </div>
            <hr>
            <div class="contact-us-info-container">
                <div class="contact-us-info-item">
                    <div class="avatar">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="item-info">
                        <h3>Email</h3>
                        <a href="mailto: info@solarpanelsolution.com">
                            <p>info@solarpanelsolution.com</p>
                        </a>
                    </div>
                </div>
                <div class="contact-us-info-item">
                    <div class="avatar">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="item-info">
                        <h3>Phone</h3>
                        <a href="tel:+0291-1234567">
                            <p>0291-1234567</p>
                        </a>
                    </div>
                </div>
                <div class="contact-us-info-item">
                    <div class="avatar">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div class="item-info">
                        <h3>Address</h3>
                        <a href="https://maps.app.goo.gl/iQagmEhS8peQ8hP1A">
                            <p>B-45 Sastri Nagar, Jodhpur(Raj.)</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "./php/footer.php"; ?>
</body>
</html>