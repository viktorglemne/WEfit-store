<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();

// import / include information from config file
// require once will check if the file has already been included, and if so, not include (require) it again.
require_once "classes/config.php";

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
// Displays content from first split of html documnet
echo $html_pieces[0];
// sets content from footer-html documnet in varaible
$footer = file_get_contents("html/footer.html");

// check if session cart been set.
// shows all products if there is any in cart otherwise display that cart i empty 
if (isset($_SESSION['cart'])) {
    // Displays content from html documnet
    echo $html_pieces[1];
    // create a variable with a arry of all id values that exist in session cart array.
    $product_id = array_column($_SESSION['cart'], 'id');

    // fetch all values from products table in database
    $stmt = $pdo->prepare("SELECT * FROM products");
    $stmt->execute();
    // takes the fetched data and return it as an associative array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // loops through product_id 
        foreach ($product_id as $session_id) {
            // if value of id is the same as in the cart array then do something
            if ($row['id'] == $session_id) {
                // echo first pice of information from html documnet
                $tmp = $html_pieces[2];
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

                // calculates the total value of the item
                $total = $quantity * $price;
                // // sets the item total value in a variable and increment with next item total value
                $totalPrice += $total;

                // replace value in html dockumnet with new value from database
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

    // replace value in html dockumnet with value about sum of all product in cart
    $html_pieces[3] = str_replace('--total--', $totalPrice, $html_pieces[3]);
    echo $html_pieces[3];


    // display information part from html document
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $stmt = $pdo->prepare("SELECT * FROM `customer` WHERE `email` = '$username'");
        $stmt->execute();
        // takes the fetched data and return it as a assite array
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $tmp = $html_pieces[4];
        $tmp = str_replace('id="--adress--"', "value=" . $row['adress'], $tmp);
        $tmp = str_replace('id="--post--"', "value=" . $row['postnr'], $tmp);
        $tmp = str_replace('id="--ort--"', "value=" . $row['ort'], $tmp);
        $tmp = str_replace('id="--mail--"', "value=" . $row['email'], $tmp);
        $tmp = str_replace('id="--phone--"', "value=" . $row['telefonnr'], $tmp);

        echo $tmp;
    } else {
        echo $html_pieces[4];
    }
} else {
    // display that cart is empty if session cart not been set
    echo $html_pieces[5];
}

// display footer content from footer html file
echo $footer;
