<style>
html {
    scroll-behavior: smooth;
}

.nav-bar {
    width: 100%;
    height: 80px;
    line-height: 80px;
    background-color: #E7E7E7;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-bar a ,
.nav-bar:visited {
    color: black;
    text-decoration: none;
}

.nav-bar .logo-container {
    width: 100px;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    /* margin: 0px 30px; */
    margin-left: 30px;
}

.nav-bar .logo-container span {
    color: #07161B;
    font-size: 30px;
}

.nav-bar .nav-links ul {
    list-style: none;
    display: flex;
    /* line-height: 100px; */
}

.nav-links ul a, .nav-links ul a:visited {
    text-decoration: none;
    color: #07161B;
    margin: 0px 15px;
    font-size: 30px;
}

.nav-bar ul a:hover {
    line-height: 75px;
    color: #6AC949;
    border-bottom: 3px solid #6AC949;
}

.nav-links ul li {
    text-decoration: none;
}

.nav-contact-number {
    font-size: 30px;
    color: #6AC949;
}

.nav-contact-number a , .nav-contact-number a:visited {
    text-decoration: none;
    color: #6AC949;
}

.nav-contact-number span {
    color: #07161B;
    margin: 0px 15px;
}

.nav-contact-number button {
    width: 200px;
    height: 50px;
    background-color: #6AC949;
    border: none;
    border-radius: 10px;
    color: black;
    font-size: 25px;
    margin: 0px 20px;
    margin-right: 50px;
}


@media (max-width: 1300px) {
    .nav-links ul a, .nav-links ul a:visited {
        margin: 0px 10px;
        font-size: 25px;
    }

    .nav-contact-number {
        font-size: 25px;
    }
    
}

</style>

<div class="nav-bar">
    <a href="./index.php">
        <div class="logo-container">
            <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="100" height="100" fill="url(#pattern0)"/>
                <defs>
                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0_245_6" transform="scale(0.01)"/>
                </pattern>
                <image id="image0_245_6" width="100" height="100" xlink:href="data:image/png;base64,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"/>
                </defs>
            </svg>
            <span>SPS</span>
        </div>
    </a>
    <div class="nav-links">
        <ul>
            <a href="./index.php">
                <li>Home</li>
            </a>
            <a href="./products.php">
                <li>Products</li>
            </a>
            <a href="./services.php">
                <li>Services</li>
            </a>
            <a href="./contact_us.php">
                <li>Contact Us</li>
            </a>
        </ul>
    </div>
    <div class="nav-contact-number">
        <a href="tel:+911234567890">
            <i class="fa-solid fa-phone"></i>
            <span>+91 1234567890</span>
        </a>
        <!-- <button>Order</button> -->
    </div>
    <!-- <div class="order-btn">
    </div> -->
</div>