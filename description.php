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
menu($titel);

$html = file_get_contents("html/description.html");

$name = $row['name'];
$price = $row['price'];
$image = $row['image'];
$rowId = $row['id'];

$myfile = fopen("descriptions/". $name .".txt", "r") or die("Unable to open file!");
$file = fread($myfile, filesize("descriptions/". $name .".txt"));

$html = str_replace('--description-text--', $file, $html);
$html = str_replace('--image--', $image, $html);
$html = str_replace('--name--', $name, $html);
$html = str_replace('--price--', $price, $html);
$html = str_replace('--id--', $rowId, $html);


// ----------------------------------------------------------------------

// echo '<pre>';
// print_r($_SESSION);
// echo '<br><br>';
// // $sessionId = array_column($_SESSION['cart'], 'id');

// echo $row['id'];
// echo '<br><br>';

// // print_r($_SESSION['cart']['0']['id']);

// // foreach ($_SESSION['cart'] as $value => $key) {
// //     echo $value;
// //     echo $key['id'];
// //     echo '<br>';
// // }

// $_SESSION['cart']['0']['quantity'] = 1;

// foreach ($_SESSION['cart'] as $value => $key) {
//     if ($key['id'] == $row['id']) {
//         $arrayName = $value;
//     }
//     break;
// }

// if ($_SESSION['cart'][$arrayName]['id'] == $row['id']) {
//     $result = $_SESSION['cart'][$arrayName]['quantity'] += 1;
// }

// echo $result;
// echo '<br><br>';

// // print_r(array_column($_SESSION['cart'], 'quantity'));
// echo '<br><br>';

// // foreach ($sessionId as $key) {
// //     echo $sessionId . ": " .  $key;
// //     echo '<br><br>';
// //     if ($key === $row['id']) {

// //     }

// // }
// echo '</pre>';
// echo '<br><br>';


// $test = array(
//     'cart' => array (
//         array(
//             'id' => 1,
//             'quantity' => 1
//         )
//     )
// );

// echo '<br><br>';
// echo '<br><br>';
// echo '<pre>';
// print_r($test);
// echo '</pre>';

// $item_array_id = array_column($test['cart'], "id");

// echo '<br><br>';
// echo '<br><br>';
// echo in_array($row['id'], $item_array_id);

// echo '<br><br>';
// echo '<br><br>';

// if (in_array($row['id'], $item_array_id)) {
//     echo "true";
// } else {
//     echo "false";
// }

// echo '<br><br>';
// echo '<pre>';
// print_r($_SESSION);
// echo '<br><br>';
// echo count($_SESSION['cart']);
// echo '</pre>';

// ----------------------------------------------------------------------

echo $html;

if (isset($_POST['add'])) {
    if (isset($_SESSION['cart'])) {
        $item_array_id = array_column($_SESSION['cart'], "id");
        $item_array_quantity = array_column($_SESSION['cart'], "quantity");

        if (in_array($_POST['id'], $item_array_id)) {
            foreach ($_SESSION['cart'] as $value => $key) {
                if ($key['id'] == $row['id']) {
                    $arrayName = $value;
                    if ($_SESSION['cart'][$arrayName]['id'] == $row['id']) {
                        $_SESSION['cart'][$arrayName]['quantity'] += $_POST['quantity'];
                        header("Location: description.php?id=$rowId");
                    }
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
            header("Location: description.php?id=$rowId");
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
        header("Location: description.php?id=$rowId");
    }
}
