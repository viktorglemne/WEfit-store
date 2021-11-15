<?php
session_start();

require_once 'classes/config.php';
require_once "classes/component.php";
$titel = "Log in | WEfit Bäst på kosttilskott";
menu($titel);
$html_login = file_get_contents("html/login.html");
$html_pieces = explode("<!--===explode===-->", $html_login);

try {
    if (!isset($_SESSION['username'])) {
        echo $html_pieces[0];
    } elseif (isset($_SESSION['username'])) {
        echo "You have successfully logged in as ", $_SESSION['username'];
        echo $html_pieces[1];
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
}
