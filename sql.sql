CREATE DATABASE IF NOT EXISTS solar_plant;

USE solar_plant;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_name VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);

INSERT INTO `admins` (`id`, `admin_name`, `password`) VALUES ('1', 'admin', '$2y$10$OLqEVXPZ7VHLYzB04P5ILutpDQKU4t2tUOIQmExzcsBXWBsORLxmS');

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(50),
    product_img VARCHAR(255),
    product_cat VARCHAR(50),
    price FLOAT,
    rating INT
);

INSERT INTO `products` (`id`, `product_name`, `product_img`, `product_cat`, `price`, `rating`) VALUES (1, '2kW Solar Panel', '2kw_solar_panel.png', 'panels', '2500', '4');
INSERT INTO `products` (`id`, `product_name`, `product_img`, `product_cat`, `price`, `rating`) VALUES (2, '5kW Solar Panel', '2kw_solar_panel.png', 'panels', '6500', '3');
INSERT INTO `products` (`id`, `product_name`, `product_img`, `product_cat`, `price`, `rating`) VALUES (3, '60 inch Solar Panel', '2kw_solar_panel.png', 'panels', '6500', '5');
INSERT INTO `products` (`id`, `product_name`, `product_img`, `product_cat`, `price`, `rating`) VALUES (4, '72 inch Solar Panel', '2kw_solar_panel.png', 'panels', '8500', '4');
INSERT INTO `products` (`id`, `product_name`, `product_img`, `product_cat`, `price`, `rating`) VALUES (5, 'Battery', '2kw_solar_panel.png', 'equipment', '8500', '4');
INSERT INTO `products` (`id`, `product_name`, `product_img`, `product_cat`, `price`, `rating`) VALUES (6, 'Wires', '2kw_solar_panel.png', 'equipment', '8500', '4');
INSERT INTO `products` (`id`, `product_name`, `product_img`, `product_cat`, `price`, `rating`) VALUES (7, 'Invertor', '2kw_solar_panel.png', 'equipment', '8500', '4');

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(50),
    service_img VARCHAR(255),
    service_title VARCHAR(100),
    service_desc VARCHAR(255)
);

INSERT INTO `services` (`id`, `service_name`, `service_img`, `service_title`, `service_desc`) VALUES (1, 'Installation', 'installation.png', 'Solar Panel Installation Service', 'Our Executives will come and install the Solar Panels');
INSERT INTO `services` (`id`, `service_name`, `service_img`, `service_title`, `service_desc`) VALUES (2, 'Cleaning', 'cleaning.png', 'Solar Panel Cleaning Service', 'Our Executives will come and Clean the Solar Panels');
INSERT INTO `services` (`id`, `service_name`, `service_img`, `service_title`, `service_desc`) VALUES (3, 'Problem Checker', 'problem_checker.png', 'Solar Panel Problem Checker Service', 'Our Executives will come and Check the Problem in Solar Panels');


CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50),
    email VARCHAR(50),
    mobile_number VARCHAR(50),
    location1 VARCHAR(150),
    location2 VARCHAR(150),
    order_type VARCHAR(50),
    order_type_id INT,
    ordered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS plants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location VARCHAR(50),
    size_of_roof FLOAT,
    consumption INT,
    unit_cost FLOAT,
    panel_type VARCHAR(150),
    no_of_panel INT,
    on_grid BOOLEAN,
    panel_price FLOAT,
    installation FLOAT,
    material_cost FLOAT,
    on_grid_cost FLOAT,
    warranty_gst FLOAT,
    total_estimation FLOAT,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);