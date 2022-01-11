<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// include component and config once that consists with useful components and database conneciton
require_once 'classes/config.php';
require_once "classes/component.php";

// sets titel to page 
$titel = "Bli medlem | WEfit Bäst på kosttilskott";
// displays menu and title
menu($titel);

// sets html dokumnet in variable
$html_signup = file_get_contents("html/signup.html");
// splits html documnet in pieces
$html_pieces = explode("<!--===explode===-->", $html_signup);

// displays the index pieces of the html split
echo $html_pieces[0];
echo $html_pieces[1];
echo $html_pieces[2];
echo $html_pieces[3];

// gets the footer html documnet and displays it
$footer = file_get_contents("html/footer.html");
echo $footer;