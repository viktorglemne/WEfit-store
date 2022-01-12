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

// if post request been set then update user settings 
if (isset($_POST['add'])) {

    $idpost = $_POST['id'];
    $quantity = $_POST['quantity'];

    // check that cart been set
    if (isset($_SESSION['cart'])) {

        // store info about item array id value variable
        $item_array_id = array_column($_SESSION['cart'], "id");
        // store info about item array quantity value in variable
        $item_array_quantity = array_column($_SESSION['cart'], "quantity");

        // checks if post id vaule exist in session cart
        if (in_array($idpost, $item_array_id)) {

            // if id exist in session cart then loop through vaule and keys to find array name / index
            foreach ($_SESSION['cart'] as $value => $key) {

                // if key id is equal to post id then store value in varible
                if ($key['id'] == $idpost) {
                    $arrayName = $value;
                    // if id are the same on index that id in post is then increase quantity 
                    if ($_SESSION['cart'][$arrayName]['id'] == $idpost) {

                        // increase item quantity in session
                        $_SESSION['cart'][$arrayName]['quantity'] += $quantity;
                    }
                }
            }
        // else if post id vaule not exist in session cart then set a new value in array
        } else {
            $item_array = array(
                'id' => $idpost,
                'quantity' => $quantity
            );
            // take the last index key of session and increase with 1
            // stored in a variable
            $count = array_key_last($_SESSION['cart']) + 1;

            // sets new value in session with count varible value of index
            $_SESSION['cart'][$count] = $item_array;        
        }
        // if cart not ben set then set cart with new value
    } else {
        $item_array = array(
            'id' => $idpost,
            'quantity' => $quantity
        );
        // Create new session variable
        $_SESSION['cart'][1] = $item_array;
    }
    // reloads page to show that item been put in cart
    header("Location: description.php?id=$idpost");
}
