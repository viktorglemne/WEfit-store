<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();

// import / include information from config file
// require once will check if the file has already been included, and if so, not include (require) it again.
require_once "classes/config.php";

// import information from compontets 
require_once "classes/component.php";
// sets titel of the webpage
$titel = "Varukorg | WEfit - Bäst på kosttillskott";
// calls for menu class to show to menu
menu($titel);

// sets content from html documnet in varaible
$html_products = file_get_contents("html/cart.html");
// splits html documnet in pieces
$html_pieces = explode("<!--===explode===-->", $html_products);
// Displays content from first split of html documnet
echo $html_pieces[0];

echo $html_pieces[6];
// sets content from footer-html documnet in varaible
$footer = file_get_contents("html/footer.html");

// display footer content from footer html file
echo $footer;