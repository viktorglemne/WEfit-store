<?php
session_start();

require_once("classes/component.php");
require_once("classes/config.php");

if (isset($_POST['remove'])) {
    if ($_GET['action'] == 'remove') {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value["product_id"] == $_GET['id']) {
                unset($_SESSION['cart'][$key]);
            }
        }
    }
}

$html_cart = file_get_contents("html/cart.html");
$html_pieces_cart = explode("<!--===explode===-->", $html_cart);

echo $html_pieces_cart[0];

require_once('php/header.php');

echo $html_pieces_cart[1];


$total = 0;
if (isset($_SESSION['cart'])) {
    $product_id = array_column($_SESSION['cart'], 'product_id');

    $result = $db->getData();
    while ($row = mysqli_fetch_assoc($result)) {
        foreach ($product_id as $id) {
            if ($row['id'] == $id) {
                cartElement($row['product_image'], $row['product_name'], $row['product_price'], $row['id']);
                $total = $total + (int)$row['product_price'];
            }
        }
    }
} else {
    echo "Cart is Empty";
}

echo $html_pieces_cart[2];

if (isset($_SESSION['cart'])) {
    $count  = count($_SESSION['cart']);
    echo "Price ($count items)";
} else {
    echo "Price (0 items)";
}

$html_pieces_cart[3] = str_replace('--$total--', $total, $html_pieces_cart[3]);
echo $html_pieces_cart[3];
