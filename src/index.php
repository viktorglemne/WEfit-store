<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// index-file and frontpage
require_once "classes/component.php";

// sets titel to page 
$titel = "WEfit | Bäst på kosttilskott";
// displays menu and title
menu($titel);

// sets html dokumnet in variable
$html_index = file_get_contents("html/index-page.html");
$html_products = file_get_contents("html/products.html");
// splits html documnet in pieces
$html_pieces = explode("<!--===explode===-->", $html_products);
// splits html pieces documnet in more pieces
$html_categorie = explode("<!--===inner-explode===-->", $html_pieces[1]);

// replace values in html with inner splits
$html_index = str_replace('--supplement--', $html_categorie[0], $html_index);
$html_index = str_replace('--weights--', $html_categorie[1], $html_index);
$html_index = str_replace('--clothes--', $html_categorie[2], $html_index);

// displays html dokument
echo $html_index;

// gets the footer html documnet and displays it
$footer = file_get_contents("html/footer.html");
echo $footer;


