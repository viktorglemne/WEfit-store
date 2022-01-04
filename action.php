<?php
session_start();

require_once 'classes/config.php';
require_once "classes/component.php";

if (isset($_POST['remove'])) {
    // search specific id and unset that post in the array
    foreach ($_SESSION['cart'] as $value => $key) {
        if ($key['id'] == $_POST['id']) {
            $arrayName = $value;
            unset($_SESSION['cart'][$arrayName]);
        }
    }
    // Unset whole array if array is empty
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }
}

if (isset($_POST['decrease'])) {
    foreach ($_SESSION['cart'] as $value => $key) {
        if ($key['id'] == $_POST['id']) {
            $arrayName = $value;
            if ($_SESSION['cart'][$arrayName]['quantity'] > 1) {
                if ($_SESSION['cart'][$arrayName]['id'] == $_POST['id']) {
                    $_SESSION['cart'][$arrayName]['quantity'] -= 1;
                }
            } else {
                unset($_SESSION['cart'][$arrayName]);
            }
        }
    }
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }
}

if (isset($_POST['increase'])) {
    foreach ($_SESSION['cart'] as $value => $key) {
        if ($key['id'] == $_POST['id']) {
            $arrayName = $value;
            if ($_SESSION['cart'][$arrayName]['id'] == $_POST['id']) {
                $_SESSION['cart'][$arrayName]['quantity'] += 1;
            }
        }
    }
}

// redirect to cart page
header("location: cart.php");


if (isset($_POST['order'])) {

    if (isset($_SESSION['username'])) {
        $USER = $_SESSION['username'];

        $query  = "SELECT * FROM `customer` WHERE email='$USER'";
        $result = $pdo->query($query);
        $row = $result->fetch();

        $pdo->exec("INSERT INTO `order`(`customer_id`) VALUES ('[value-3]')");

        unset($_SESSION['cart']);
        header("location: order.php");
    } else {
        echo 'test';
    }
}
