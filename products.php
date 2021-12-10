<?php
session_start();
// index-file and frontpage
require_once "classes/config.php";
require_once "classes/component.php";

$titel = "Produkter hos WEfit | Bäst på kosttilskott";
$html_products = file_get_contents("html/products.html");
$html_pieces = explode("<!--===explode===-->", $html_products);
menu($titel);
echo $html_pieces[0];


$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
// takes the fetched data and return it as a assite array
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();

echo $html_pieces[1];

echo $html_pieces[3];

$footer = file_get_contents("html/footer.html");
echo $footer;
