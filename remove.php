<?php
session_start();

require_once 'classes/config.php';
require_once "classes/component.php";

if (isset($_POST['remove'])) {
    foreach ($_SESSION['cart'] as $value => $key) {
        if ($key['id'] == $_POST['id']) {
            $arrayName = $value;
        }
        break;
    }
    unset($_SESSION['cart'][$arrayName]);
}

header("location: cart.php");