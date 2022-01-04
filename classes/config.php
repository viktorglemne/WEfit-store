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

$pdo->exec("CREATE TABLE IF NOT EXISTS customer(
    id INT AUTO_INCREMENT,
    email TEXT NOT NULL,
    pass TEXT NOT NULL,
    PRIMARY KEY(id))");

