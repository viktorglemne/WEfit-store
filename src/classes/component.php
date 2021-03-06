<?php
function menu($titel)
{
    $html = file_get_contents("html/navBar.html");
    $html = str_replace('--Titel--', $titel, $html);

    if (isset($_SESSION['cart'])) {
        $count = array_sum(array_column($_SESSION['cart'], 'quantity'));
        $html = str_replace('--count--', $count, $html);
    } else {
        $html = str_replace('--count--', "", $html);
    }

    if (isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
        $html = str_replace('Logga In', $user, $html);
    }
    echo $html;
}