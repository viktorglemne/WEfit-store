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



// ----------------------------------------------------------------------

require_once "classes/component.php";
$titel = $row['name'] . "Varukorg | WEfit - Bäst på kosttillskott";
menu($titel);

$html_products = file_get_contents("html/cart.html");
$html_pieces = explode("<!--===explode===-->", $html_products);
echo $html_pieces[0];

if (isset($_SESSION['cart'])) {
    $product_id = array_column($_SESSION['cart'], 'id');

    $stmt = $pdo->prepare("SELECT * FROM products");
    $stmt->execute();
    // takes the fetched data and return it as a assite array

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        foreach ($product_id as $session_id) {
            if ($row['id'] == $session_id) {
                $tmp = $html_pieces[1];

                foreach ($_SESSION['cart'] as $value => $key) {
                    if ($key['id'] == $row['id']) {
                        $arrayName = $value;
                    }
                }

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
    echo $html_pieces[2];
} else {
    echo $html_pieces[3];
}
