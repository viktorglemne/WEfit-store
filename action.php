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


if (isset($_POST['skicka'])) {

    $USER = $_SESSION['username'];

    $ADRESS = strip_tags($_POST["address"]);
    $POSTNR = strip_tags($_POST["zipcode"]);
    $ORT = strip_tags($_POST["state"]);
    $TELE = strip_tags($_POST["phonenumber"]);

    $sql = "UPDATE `customer` SET `address`='$ADRESS',`zipcode`='$POSTNR',`state`='$ORT',`phonenumber`='$TELE' WHERE `email` = '$USER'";
    $result = $pdo->query($sql);
    
    header("location: userpage.php");
}
