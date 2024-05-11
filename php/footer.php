<style>
    
.footer {
    width: 100%;
    height: 50px;
    padding: 0px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #E7E7E7;
}

.footer .logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.footer .logo-container img {
    width: 40px;
}

.footer .logo-container span {
    font-size: 30px;
}

.footer .social-media-links {
    width: 200px;
    display: flex;
    justify-content: space-evenly;
}

.footer .social-media-links img {
    width: 35px;
    height: 35px;
}

.footer a ,
.footer a:visited {
    text-decoration: none;
    color: black;
}


.footer .contact-number {
    font-size: 35px;
    color: #6AC949;
    display: flex;
    justify-content: center;
    align-items: center;
}

.footer .contact-number span {
    font-size: 30px;
    color: black;
}

</style>

<div class="footer">
    <a href="./index.php">
        <div class="logo-container">
            <img src="./assets/images/sun.png" alt="">
            <span>SPS</span>
        </div>
    </a>

    <div class="social-media-links">
        <a href="">
            <img src="./assets/images/facebook.png" alt="">
        </a>
        <a href="">
            <img src="./assets/images/whatsapp.png" alt="">
        </a>
        <a href="">
            <img src="./assets/images/youtube.png" alt="">
        </a>
        <a href="">
            <img src="./assets/images/instagram.png" alt="">
        </a>
    </div>

    <a href="tel:+911234567890">
        <div class="contact-number">
            <i class="fa-solid fa-phone"></i>
            <span>+91 1234567890</span>
        </div>
    </a>
</div>