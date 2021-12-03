<?php
session_start();
// index-file and frontpage
require_once "classes/component.php";
$titel = "WEfit | Bäst på kosttilskott";
menu($titel);
include('html/homepage.html');
$footer = file_get_contents("html/footer.html");
echo $footer;


