<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// import / include information from config file
// require once will check if the file has already been included, and if so, not include (require) it again.
require_once "classes/config.php";
// import information from compontets 
require_once "classes/component.php";

// sets titel of the webpage
$titel = "Orderbekräftelse | WEfit - Bäst på kosttillskott";
// calls for menu class to show to menu
menu($titel);

// sets content from html documnet in varaible
$html_order = file_get_contents("html/order.html");
// splits html documnet in pieces
$html_pieces = explode("<!--===explode===-->", $html_order);
// Displays content from first split of html documnet
// sets content from footer-html documnet in varaible
$footer = file_get_contents("html/footer.html");

// if user session been set then do something
if (isset($_SESSION['username'])) {
    // set value from get in variable
    $orderNr = $_GET['idorder'];

    $html_pieces[0] = str_replace('--ordernr--', $orderNr, $html_pieces[0]);
    echo $html_pieces[0];
    echo $html_pieces[2];

    // fetch all values from products table in database
    $stmt = $pdo->prepare("SELECT * FROM `order_item` RIGHT JOIN `products` ON `order_item`.`products_idproducts` = `products`.`idproducts` RIGHT JOIN `orders` ON `order_item`.`order_idorder` = `orders`.`idorder` WHERE `order_idorder` = '$orderNr';");
    $stmt->execute();
    // takes the fetched data and return it as a assite array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $row = $stmt->fetchAll();

    // loops through product_id 
    foreach ($row as $val) {

        // echo first pice of information from html documnet
        $tmp = $html_pieces[3];

        $quantity = $val['quantity'];
        $name = $val['name'];
        $price = $val['price'];
        $image = $val['image'];

        // replace value in html dockumnet with new value from database
        // value too the order
        $tmp = str_replace('--quantity--', $quantity, $tmp);
        $tmp = str_replace('--name--', $name, $tmp);
        $tmp = str_replace('--price--', $price, $tmp);
        $tmp = str_replace('--image--', $image, $tmp);

        // echo out the assigned values for html_pieces
        echo $tmp;
    }

    // query sql statement for selection of all row in table with where clause
    $stmt2 = $pdo->query("SELECT * FROM `orders` WHERE `idorder` = '$orderNr';");
    // fetch all data in an array and saved in a variable
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    // sets value in variable
    $totalprice = $row2['totalprice'];

    // gets the html documnet, replace value and displays it
    $html_pieces[4] = str_replace('--total--', $totalprice, $html_pieces[4]);
    echo $html_pieces[4];
}

// display footer content from footer html file
echo $footer;
