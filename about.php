<?php
session_start();
// index-file and frontpage
require_once "classes/component.php";

$titel = "Om WEfit | Bäst på kosttilskott";
menu($titel);



$html_products = file_get_contents("html/about.html");
$html_pieces = explode("<!--===explode===-->", $html_products);
echo $html;
echo $html_pieces[0];
echo $html_pieces[1];
echo $html_pieces[2];


$footer = file_get_contents("html/footer.html");
echo $footer;