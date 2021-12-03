<?php
session_start();
// index-file and frontpage
require_once "classes/component.php";
$titel = "Artiklar hos WEfit | Bäst på kosttilskott";
$html_products = file_get_contents("html/articles.html");
menu($titel);
echo $html_products;
$footer = file_get_contents("html/footer.html");
echo $footer;