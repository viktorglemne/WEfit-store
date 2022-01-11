<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();

// include component and config once that consists with useful components and database conneciton
require_once 'classes/config.php';
require_once "classes/component.php";


// if post request been set then do somthing
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

// if post request been set then do somthing
if (isset($_POST['decrease'])) {
    // search specific id and decrease that post in the array if more then one otherwise unset post
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
    // Unset whole array if array is empty
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }
}

// if post request been set then do somthing
if (isset($_POST['increase'])) {
    // search specific id and increase that post in the array
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

// if post request been set then update user settings 
if (isset($_POST['skicka'])) {

    $USER = $_SESSION['username'];

    // Strip the input and put in a variable
    $ADRESS = strip_tags($_POST["address"]);
    $POSTNR = strip_tags($_POST["zipcode"]);
    $ORT = strip_tags($_POST["state"]);
    $TELE = strip_tags($_POST["phonenumber"]);

    // upade value in customer table
    $sql = "UPDATE `customer` SET `address`='$ADRESS',`zipcode`='$POSTNR',`state`='$ORT',`phonenumber`='$TELE' WHERE `email` = '$USER'";
    $result = $pdo->query($sql);

    // locate back to userpage
    header("location: userpage.php");
}
