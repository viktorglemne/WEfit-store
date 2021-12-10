<?php
session_start();
// index-file and frontpage
require_once "classes/component.php";
$titel = "WEfit | Bäst på kosttilskott";
menu($titel);
$html_index = file_get_contents("html/index-page.html");
$html_products = file_get_contents("html/products.html");
$html_pieces = explode("<!--===explode===-->", $html_products);
$html_categorie = explode("<!--===inner-explode===-->", $html_pieces[1]);

$html_index = str_replace('--supplement--', $html_categorie[0], $html_index);
$html_index = str_replace('--weights--', $html_categorie[1], $html_index);
$html_index = str_replace('--clothes--', $html_categorie[2], $html_index);

echo $html_index;

$footer = file_get_contents("html/footer.html");
echo $footer;


