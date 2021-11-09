<?php
session_start();
// index-file and frontpage

require_once "classes/config.php";

// if (isset($_POST['remove'])) {
//     foreach ($_SESSION['cart'] as $key => $value) {
//         if ($value["id"] == $_GET['id']) {
//             unset($_SESSION['cart'][$key]);
//         }
//     }
// }

// echo '<pre>';
// print_r($_SESSION);
// echo '<br><br>';
// echo array_sum(array_map("count", $_SESSION['cart']));

// echo '<br><br>';
// echo "quantity in cart is: ";
// print_r(array_sum(array_column($_SESSION['cart'], 'quantity')));

// echo '<br><br>';
// echo "id in cart: ";
// echo '<br>';
// print_r(array_column($_SESSION['cart'], "id"));

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
// echo '</pre>';

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
                $tmp1 = $html_pieces[1];

                $name = $row['name'];
                $price = $row['price'];
                $image = $row['image'];
                
                // foreach ($_SESSION['cart'] as &$value) {
                //     if ($value['id'] === $session_id) {
                //         $tmp2 = $html_pieces[2];
            
                //         $amount[] = $value['quantity'];
            
                //         $tmp2 = str_replace('--quantity--', "test", $tmp2);
                //     }
                // }

                $tmp1 = str_replace('--image--', $image, $tmp1);
                $tmp1 = str_replace('--name--', $name, $tmp1);
                $tmp1 = str_replace('--price--', $price, $tmp1);
                $tmp1 = str_replace('--id--', $session_id, $tmp1);

                // echo out the assigned values for html_pieces
                echo $tmp1;
                // echo $tmp2;
            }
        }
    }

    // foreach ($_SESSION['cart'] as &$value) {
    //     if ($value['id'] === $session_id) {
    //         $tmp2 = $html_pieces[2];

    //         $amount[] = $value['quantity'];

    //         $tmp2 = str_replace('--quantity--', array_sum($amount), $tmp2);
    //         echo $tmp2;
    //     }
    // }
    
} else {
    echo "Cart is Empty";
}

