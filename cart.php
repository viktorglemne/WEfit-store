<?php
session_start();
// index-file and frontpage

require_once "classes/config.php";

// ----------------------------------------------------------------------

// echo '<pre>';
// print_r($_SESSION);
// echo '<br><br>';
// echo '</pre>';
// echo array_sum(array_map("count", $_SESSION['cart']));

// echo '<br><br>';
// echo "quantity in cart is: ";
// print_r(array_sum(array_column($_SESSION['cart'], 'quantity')));

// echo '<br><br>';
// echo "id in cart: ";
// echo '<br>';
// print_r(array_column($_SESSION['cart'], "id"));
// print_r($_SESSION['cart'][0]['quantity']);

// $test[] = array_column($_SESSION['cart'], "id");


// echo '<br><br>';

// foreach ($_SESSION['cart'] as &$value) {
//     if ($value['id'] === "9") {
//         $quantity[] = $value['quantity'];
//     }
// }
// echo "quantity of specific product is: ";
// echo array_sum($quantity);
// echo '<br>';
// print_r($quantity);

// echo '<br><br>';
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

// echo '<br><br>';
// echo '<pre>';
// print_r(array_column($_SESSION['cart'], 'id'));
// echo '</pre>';


// ----------------------------------------------------------------------

// import information from compontets 
require_once "classes/component.php";
// sets titel of the webpage
$titel = "Varukorg | WEfit - Bäst på kosttillskott";
// calls for menu class to show to menu
menu($titel);

// sets content from html documnet in varaible
$html_products = file_get_contents("html/cart.html");
// splits html documnet in pieces
$html_pieces = explode("<!--===explode===-->", $html_products);
echo $html_pieces[0];

// check if session cart been set.
// shows all products if there is any in cart otherwise display that cart i empty 
if (isset($_SESSION['cart'])) {
    // create a variable with a arry of all id values that exist in session cart array.
    $product_id = array_column($_SESSION['cart'], 'id');

    // fetch all values from products table in database
    $stmt = $pdo->prepare("SELECT * FROM products");
    $stmt->execute();
    // takes the fetched data and return it as a assite array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // loops through product_id 
        foreach ($product_id as $session_id) {
            // if value of id is the same as in the cart array then do something
            if ($row['id'] == $session_id) {
                // echo first pice of information from html documnet
                $tmp = $html_pieces[1];
                // through session cart arry to find array name where id exist
                foreach ($_SESSION['cart'] as $value => $key) {
                    if ($key['id'] == $row['id']) {
                        $arrayName = $value;
                    }
                }
                // vaule about product and quantity in varibels and replace placeholders in html documnet
                $quantity = $_SESSION['cart'][$arrayName]['quantity'];
                $name = $row['name'];
                $price = $row['price'];
                $image = $row['image'];

                $tmp = str_replace('--quantity--', $quantity, $tmp);
                $tmp = str_replace('--image--', $image, $tmp);
                $tmp = str_replace('--name--', $name, $tmp);
                $tmp = str_replace('--price--', $price, $tmp);
                $tmp = str_replace('--id--', $session_id, $tmp);

                // echo out the assigned values for html_pieces
                echo $tmp;
            }
        }
    }
    // display information part from html document
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $stmt = $pdo->prepare("SELECT * FROM `customer` WHERE `email` = '$username'");
        $stmt->execute();
        // takes the fetched data and return it as a assite array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $tmp = $html_pieces[2];
        $tmp = str_replace('id="--adress--"', "value=".$row['adress'], $tmp);
        $tmp = str_replace('id="--post--"', "value=".$row['postnr'], $tmp);
        $tmp = str_replace('id="--ort--"', "value=".$row['ort'], $tmp);
        $tmp = str_replace('id="--mail--"', "value=".$row['email'], $tmp);
        $tmp = str_replace('id="--phone--"', "value=".$row['telefonnr'], $tmp);

        echo $tmp;
    } else {
        echo $html_pieces[2];
    }
} else {
    // display that cart is empty if session cart not been set
    echo $html_pieces[3];
}

$footer = file_get_contents("html/footer.html");
echo $footer;
