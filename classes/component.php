<?php

function products($productname, $productprice, $productimg, $productid)
{
    $html = file_get_contents("html/component.html");

    $html = str_replace('--$productimg--', $productimg, $html);
    $html = str_replace('--$productname--', $productname, $html);
    $html = str_replace('--$productprice--', $productprice, $html);
    $html = str_replace('--$productid--', $productid, $html);

    echo $html;
}

function cartElement($productimg, $productname, $productprice, $productid)
{
    $html = file_get_contents("html/cartElement.html");

    $html = str_replace('--$productimg--', $productimg, $html);
    $html = str_replace('--$productname--', $productname, $html);
    $html = str_replace('--$productprice--', $productprice, $html);
    $html = str_replace('--$productid--', $productid, $html);

    echo $html;
}

function Menu($titel)
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