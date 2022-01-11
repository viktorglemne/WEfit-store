<?php
session_start();

require_once 'classes/config.php';
require_once "classes/component.php";
$titel = "Bli medlem | WEfit Bäst på kosttilskott";
menu($titel);
$html_signup = file_get_contents("html/signup.html");
$html_pieces = explode("<!--===explode===-->", $html_signup);
echo $html_pieces[0];
echo $html_pieces[1];
echo $html_pieces[2];
echo $html_pieces[3];

$footer = file_get_contents("html/footer.html");
echo $footer;