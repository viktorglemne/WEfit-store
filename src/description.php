<?php
// session is started if you don't write this line can't use $_Session  global variable
session_start();
// include component and config once that consists with useful components and database conneciton
require_once "classes/config.php";
require_once "classes/component.php";

// sets get value in variable 
$id = $_GET['id'];
// fetch data from the database where value from get determines which value to retrieve
$query  = "SELECT * FROM products WHERE idproducts=$id";
$result = $pdo->query($query);
$row = $result->fetch();

// sets titel to page with value from database 
$titel = $row['name'] . "hos WEfit | Bäst på kosttilskott";
// displays menu and title
menu($titel);

// sets html dokumnet in variable
$html = file_get_contents("html/description.html");
// sets html footer dokumnet in variable
$footer = file_get_contents("html/footer.html");

// sets fetch data in variables
$name = $row['name'];
$price = $row['price'];
$image = $row['image'];
$rowId = $row['idproducts'];

// open descriptions file with name from fetch data 
$myfile = fopen("descriptions/" . $name . ".txt", "r") or die("Unable to open file!");
// reads the file 
$file = fread($myfile, filesize("descriptions/" . $name . ".txt"));

// replace values in html with fetched data from database
$html = str_replace('--description-text--', $file, $html);
$html = str_replace('--image--', $image, $html);
$html = str_replace('--name--', $name, $html);
$html = str_replace('--price--', $price, $html);
$html = str_replace('--id--', $rowId, $html);

// displays html dokument
echo $html;

// display footer html dokumnet 
echo $footer;
