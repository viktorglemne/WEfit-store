<?php
/*session is started if you don't write this line can't use $_Session  global variable*/
session_start();

require_once "classes/config.php";
require_once "classes/component.php";

$id = $_GET['id'];
$query  = "SELECT * FROM products WHERE id=$id";
$result = $pdo->query($query);
$row = $result->fetch();

$titel = $row['name'] . "hos WEfit | Bäst på kosttilskott";
// menu($titel);

if (isset($_POST['add'])) {
    if (isset($_SESSION['cart'])) {
        $item_array_id = array_column($_SESSION['cart'], "id");
        $item_array_quantity = array_column($_SESSION['cart'], "quantity");

        if ($_POST['id'] == checkId($_POST['id'])) {

            $oldValue = checkQuantity($_POST['id']);
            $newValue = $_POST['quantity'];

            

            // $count = 0;
            // foreach ($array as $type) {
            //     $oldValue += $newValue;
            // }


            // $id = $_GET['id'];
            // $quantitytoadd = $_GET['quantity'];

            // if( isset( $_SESSION['shoppingcart'][$id]))
            // {
            //     //CODE TO ADD TO QUANTITY????
            //      $_SESSION['shoppingcart'][$id]++;


            // $result = $oldValue + $newValue;

            // Putting & before the function name means "return by reference".
            foreach ($_SESSION['cart'] as &$value) {
                if ($value['id'] === $_POST['id']) {
                    $value['quantity'] = $result;
                    break; // Stop the loop after we've found the item
                }
            }
        } else {
            $id = $_POST['id'];
            $quantity = $_POST['quantity'];

            $item_array = array(
                'id' => $id,
                'quantity' => $quantity
            );

            $count = count($_SESSION['cart']);

            $_SESSION['cart'][$count] = $item_array;
        }
    } else {
        $id = $_POST['id'];
        $quantity = $_POST['quantity'];

        $item_array = array(
            'id' => $id,
            'quantity' => $quantity
        );
        // Create new session variable
        $_SESSION['cart'][0] = $item_array;
    }
}

$html_products = file_get_contents("html/description.html");

$name = $row['name'];
$price = $row['price'];
$image = $row['image'];
$id = $row['id'];

$html_products = str_replace('--image--', $image, $html_products);
$html_products = str_replace('--name--', $name, $html_products);
$html_products = str_replace('--price--', $price, $html_products);
$html_products = str_replace('--id--', $id, $html_products);

echo $html_products;
