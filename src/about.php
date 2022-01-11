<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// include component once that consists with useful components
require_once "classes/component.php";

// sets titel of the page
$titel = "Om WEfit | Bäst på kosttilskott";
// calls menu class and takes title as a parameter
menu($titel);

// fetch html dokumnet 
$html_products = file_get_contents("html/about.html");
// split the html documnet in pieces
$html_pieces = explode("<!--===explode===-->", $html_products);

// display picese from html dockument
echo $html_pieces[0];
echo $html_pieces[1];
echo $html_pieces[2];

// fetch html dokumnet for footer and displays it
$footer = file_get_contents("html/footer.html");
echo $footer;