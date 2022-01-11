<?php
// session is started if you don't write this line can't use $_Session  global variable
session_start();
// include component and config once that consists with useful components and database conneciton
require_once "classes/config.php";
require_once "classes/component.php";

// sets get value in variable 
$id = $_GET['id'];
// fetch data from the database where value from get determines which value to retrieve
$query  = "SELECT * FROM products WHERE idproducts=$id";
$result = $pdo->query($query);
$row = $result->fetch();

// sets titel to page with value from database 
$titel = $row['name'] . "hos WEfit | Bäst på kosttilskott";
// displays menu and title
menu($titel);

// sets html dokumnet in variable
$html = file_get_contents("html/description.html");
// sets html footer dokumnet in variable
$footer = file_get_contents("html/footer.html");

// sets fetch data in variables
$name = $row['name'];
$price = $row['price'];
$image = $row['image'];
$rowId = $row['idproducts'];

// open descriptions file with name from fetch data 
$myfile = fopen("descriptions/" . $name . ".txt", "r") or die("Unable to open file!");
// reads the file 
$file = fread($myfile, filesize("descriptions/" . $name . ".txt"));

// replace values in html with fetched data from database
$html = str_replace('--description-text--', $file, $html);
$html = str_replace('--image--', $image, $html);
$html = str_replace('--name--', $name, $html);
$html = str_replace('--price--', $price, $html);
$html = str_replace('--id--', $rowId, $html);

// displays html dokument
echo $html;

// check that add been set
if (isset($_POST['add'])) {
    // check that cart been set
    if (isset($_SESSION['cart'])) {

        // store info about item array id value variable
        $item_array_id = array_column($_SESSION['cart'], "id");
        // store info about item array quantity value in variable
        $item_array_quantity = array_column($_SESSION['cart'], "quantity");

        // checks if post id vaule exist in session cart
        if (in_array($_POST['id'], $item_array_id)) {

            // if id exist in session cart then loop through vaule and keys to find array name / index
            foreach ($_SESSION['cart'] as $value => $key) {

                // if key id is equal to row id then store value in varible
                if ($key['id'] == $row['id']) {
                    $arrayName = $value;
                    // if id are the same on index X that id in row is then increase quantity 
                    if ($_SESSION['cart'][$arrayName]['id'] == $row['id']) {

                        // increase item quantity in session
                        $_SESSION['cart'][$arrayName]['quantity'] += $_POST['quantity'];

                        // reloads page to show that item been put in cart
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                    }
                }
            }

        // else if post id vaule not exist in session cart then set a new value in array
        } else {
            $item_array = array(
                'id' => $_POST['id'],
                'quantity' => $_POST['quantity']
            );

            // take the last index key of session and increase with 1
            // stored in a variable
            $count = array_key_last($_SESSION['cart']) + 1;

            // sets new value in session with count varible value of index
            $_SESSION['cart'][$count] = $item_array;
            // reloads page to show that item been put in cart
            header("Location: description.php?id=$rowId");
        }
        // if cart not ben set then set cart with new value
    } else {
        $item_array = array(
            'id' => $_POST['id'],
            'quantity' => $_POST['quantity']
        );
        // Create new session variable
        $_SESSION['cart'][1] = $item_array;
        header("Location: description.php?id=$rowId");
    }
}

// display footer html dokumnet 
echo $footer;
