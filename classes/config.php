<?php
// tellS PHP which computer to use when connecting to a database
$host = 'localhost';
// tells which user that being used
$user = 'root';
// password for the database
$pass = '';
// tells which database to use
$db = 'website';
// character set, and in this case we are using utf8mb4
$chrs = 'utf8mb4';
// Adds additional options needed to access the database
$attr = "mysql:host=$host;dbname=$db;charset=$chrs";
$opts =
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

// <--- connect to database ---> 
// made for checking errros
try {
    // creates a new object by calling a new instance of the PDO method.
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

$pdo->exec("CREATE TABLE IF NOT EXISTS products(
    id INT AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL,
    image TEXT NOT NULL,
    price DECIMAL(5,2) NOT NULL,
    category VARCHAR(10) NOT NULL,
    PRIMARY KEY(id))");

// "INSERT INTO products (name, image, price, category) VALUES
//     ('WEfit-Prework', 'products_images/WEfit-Prework.png', 299.00, 'supplement'),
//     ('WEfit-Sport', 'products_images/WEfit-Sport.png', 299.00, 'supplement'),
//     ('WEfit-After', 'products_images/WEfit-After.png', 299.00, 'supplement'),
//     ('WEfit-Drink', 'products_images/WEfit-drink.png', 19.00, 'supplement'),
//     ('WEfit-Bars', 'products_images/WEfit-bars.png', 39.00, 'supplement'),
//     ('WEfit-Milkshake', 'products_images/WEfit-milkshake.png', 22.00, 'supplement'),
//     ('WEfit-Gel', 'products_images/WEfit-gel.png', 19.00, 'supplement'),
//     ('WEfit-Bars 12-pack', 'products_images/WEfit-bars-12-pack.png', 399.00, 'supplement'),
//     ('WEfit Belt', 'products_images/WEfit-balte.png', 500.00, 'equipment'),
//     ('WEfit Shaker', 'products_images/WEfit-shaker.png', 19.00, 'equipment'),
//     ('WEfit Bag', 'products_images/WEfit-vaska.jpg', 400.00, 'equipment'),
//     ('WEfit Gummmiband', 'products_images/WEfit_gummiband.png', 100.00, 'equipment'),
//     ('WEfit T-shirt', 'products_images/WEfit-T-shirt.png', 299.00, 'clothes'),
//     ('WEfit Byxor', 'products_images/WEfit-Byxor.png', 499.00, 'clothes'),
//     ('WEfit Shorts', 'products_images/WEfit-shorts.png', 499.00, 'clothes'),
//     ('WEfit Hoodie', 'products_images/WEfit-Hoodie.png', 599.00, 'clothes');"

$pdo->exec("CREATE TABLE IF NOT EXISTS customer(
    id INT AUTO_INCREMENT,
    email TEXT NOT NULL,
    pass TEXT NOT NULL,
    PRIMARY KEY(id))");

