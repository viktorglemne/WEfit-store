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


$html_login = file_get_contents("html/login.html");
$html_pieces = explode("<!--===explode===-->", $html_login);

try {
    if (!isset($USER)) {
        echo $html_pieces[0];
        echo $html_pieces[1];
    } elseif (isset($USER)) {
        echo $html_pieces[2];
        $id = $row['id'];

        $query2 = $pdo->prepare("SELECT * FROM `product_order` WHERE customer_id=$id");
        $query2->execute();
        while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)) {

            $products = $row2['product_id'];

            $query3  = "SELECT * FROM `products` WHERE id=$products";
            $result3 = $pdo->query($query3);
            $row3 = $result3->fetch();

            $name = $row3['name'];
            $price = $row3['price'];
            $image = $row3['image'];

            $tmp = $html_pieces[3];

            $tmp = str_replace('--image--', $image, $tmp);
            $tmp = str_replace('--name--', $name, $tmp);
            $tmp = str_replace('--price--', $price, $tmp);

            echo $tmp;
        }
        echo $html_pieces[4];
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
}


$footer = file_get_contents("html/footer.html");
echo $footer;
