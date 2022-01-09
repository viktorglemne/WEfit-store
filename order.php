<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// import / include information from config file
// require once will check if the file has already been included, and if so, not include (require) it again.
require_once "classes/config.php";
// import information from compontets 
require_once "classes/component.php";


// // sets titel of the webpage
// $titel = "Orderbekräftelse | WEfit - Bäst på kosttillskott";
// // calls for menu class to show to menu
// menu($titel);

// sets content from html documnet in varaible
$html_order = file_get_contents("html/order.html");
// splits html documnet in pieces
$html_pieces = explode("<!--===explode===-->", $html_order);
// Displays content from first split of html documnet
// sets content from footer-html documnet in varaible
$footer = file_get_contents("html/footer.html");

if (isset($_SESSION['username'])) {

    $USER = $_SESSION['username'];
    $PRICE = $_POST['total-price'];

    // query a statment to fetch data from database
    $stmt = $pdo->query("SELECT * FROM `customer` WHERE `email` ='$USER';");
    // fetch all data in an array and saved in a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $USER_ID = $row['idcustomer'];

    $DATE = date("Y-m-d H:i:s");

    // check if session cart been set.
    // shows all products if there is any in cart otherwise display that cart i empty 
    if (isset($_SESSION['cart'])) {
        $sql = "INSERT INTO `orders`(`customer_idcustomer`, `date`, `totalprice`) VALUES ('$USER_ID', '$DATE', '$PRICE')";
        $result = $pdo->query($sql);

        // query a statment to fetch data from database
        $stmt2 = $pdo->query("SELECT * FROM `orders` WHERE `customer_idcustomer` = '$USER_ID' AND `date` = '$DATE';");
        // fetch all data in an array and saved in a variable
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        $idorder = $row2['idorder'];

        $html_pieces[0] = str_replace('--ordernr--', $idorder, $html_pieces[0]);
        echo $html_pieces[0];
        // create a variable with a arry of all id values that exist in session cart array.
        $product_id = array_column($_SESSION['cart'], 'id');
        // fetch all values from products table in database
        $stmt3 = $pdo->prepare("SELECT * FROM products");
        $stmt3->execute();

        // takes the fetched data and return it as an associative array
        while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
            // loops through product_id 
            foreach ($product_id as $session_id) {
                // if value of id is the same as in the cart array then do something
                if ($row3['idproducts'] == $session_id) {
                    // echo first pice of information from html documnet
                    $tmp2 = $html_pieces[1];
                    // through session cart arry to find array name where id exist
                    foreach ($_SESSION['cart'] as $value => $key) {
                        if ($key['id'] == $row3['idproducts']) {
                            $arrayName = $value;
                        }
                    }
                    // vaule about product and quantity in varibels and replace placeholders in html documnet
                    $quantity = $_SESSION['cart'][$arrayName]['quantity'];
                    $name = $row3['name'];
                    $price = $row3['price'];
                    $idproduct = $row3['idproducts'];

                    $sql2 = "INSERT INTO `order_item`(`products_idproducts`, `order_idorder`) VALUES ('$idproduct','$idorder')";
                    $result2 = $pdo->query($sql2);

                    // replace value in html dockumnet with new value from database
                    // value too the order
                    $tmp2 = str_replace('--quantity--', $quantity, $tmp2);
                    $tmp2 = str_replace('--name--', $name, $tmp2);
                    $tmp2 = str_replace('--price--', $price, $tmp2);

                    // echo out the assigned values for html_pieces
                    echo $tmp2;
                }
            }
        }
        unset($_SESSION['cart']);
    }
}
