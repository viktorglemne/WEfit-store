<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// include component once that consists with useful components
require_once "classes/component.php";

// sets titel of the page
$titel = "Artiklar hos WEfit | Bäst på kosttilskott";
// calls menu class and takes title as a parameter
menu($titel);

// fetch html dokumnet 
$html_products = file_get_contents("html/articles.html");

// display html dockument
echo $html_products;

// fetch html dokumnet for footer and displays it
$footer = file_get_contents("html/footer.html");
echo $footer;