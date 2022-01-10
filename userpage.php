<?php
session_start();

require_once 'classes/config.php';
require_once "classes/component.php";
$titel = "Log in | WEfit Bäst på kosttilskott";
menu($titel);

$USER = $_SESSION['username'];

$query  = "SELECT * FROM `customer` WHERE email='$USER'";
$result = $pdo->query($query);
$row = $result->fetch();

$USER_ID = $row['idcustomer'];

$html_login = file_get_contents("html/login.html");
$html_pieces = explode("<!--===explode===-->", $html_login);

try {
    if (!isset($USER)) {
        echo $html_pieces[0];
        echo $html_pieces[1];
    } elseif (isset($USER)) {
        echo $html_pieces[2];
        // query a statment to fetch data from database
        $stmt = $pdo->prepare("SELECT * FROM `orders` WHERE `customer_idcustomer` = '$USER_ID';");
        // fetch all data in an array and saved in a variable
        $stmt->execute();
        // takes the fetched data and return it as a assite array
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row2 = $stmt->fetchAll();

        // echo "<pre>";
        // print_r($row2);
        // echo "</pre>";

        foreach ($row2 as $val) {
            $tmp = $html_pieces[3];

            $orderNr = $val['idorder'];
            $date = $val['date'];
            $totalprice = $val['totalprice'];

            // replace value in html dockumnet with new value from database
            // value too the order
            $tmp = str_replace('--Ordernr--', $orderNr, $tmp);
            $tmp = str_replace('--Date--', $date, $tmp);
            $tmp = str_replace('--totalprice--', $totalprice, $tmp);

            // echo out the assigned values for html_pieces
            echo $tmp;
        }
        echo $html_pieces[4];
        echo $html_pieces[6];
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
}

$footer = file_get_contents("html/footer.html");
echo $footer;




// foreach ($idOrder as $orderId) {
//     // query a statment to fetch data from database
//     $stmt3 = $pdo->query("SELECT * FROM `order_item` RIGHT JOIN `products` ON `order_item`.`products_idproducts` = `products`.`idproducts` WHERE `order_idorder` = '$orderId';");
//     // fetch all data in an array and saved in a variable
//     $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);

//     echo $row3[''];

//     }
// SELECT * FROM `order_item` RIGHT JOIN `products` ON `order_item`.`products_idproducts` = `products`.`idproducts` RIGHT JOIN `orders` ON `order_item`.`order_idorder` = `orders`.`idorder` WHERE `order_idorder` = 18;
