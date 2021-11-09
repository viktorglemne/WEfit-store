<?php
session_start();
// index-file and frontpage
require_once "classes/config.php";
require_once "classes/component.php";

$titel = "Produkter hos WEfit | Bäst på kosttilskott";
$html_products = file_get_contents("html/general_products.html");
$html_pieces = explode("<!--===explode===-->", $html_products);
menu($titel);
echo $html_pieces[0];


$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
// takes the fetched data and return it as a assite array
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();

// iterates through an array where the value of the element gets assigned to the variable
foreach ($result as $row) {

	$tmp = $html_pieces[1];

	$id = $row['id'];
	$name = $row['name'];
	$price = $row['price'];
	$image = $row['image'];

	$tmp = str_replace("--description_page--", "description.php?id=$id", $tmp);
	$tmp = str_replace('--name--', $name, $tmp);
	$tmp = str_replace('--price--', $price, $tmp);
	$tmp = str_replace('--image--', $image, $tmp);
	$tmp = str_replace('--id--', $id, $tmp);

	// echo out the assigned values for html_pieces
	echo $tmp;
}

if (isset($_POST["add_product"])) {
	if (isset($_SESSION["shopping_cart"])) {
		$product_array_id = array_column($_SESSION["shopping_cart"], "product_id");
		if (!in_array($_GET["id"], $product_array_id)) {
			$count = count($_SESSION["shopping_cart"]);
			$products = array(
				'item_id'		=>     $_GET["id"],
				'item_name'		=>     $_POST["name_hidden"],
				'item_price'	=>     $_POST["price_hidden"],
				'item_quantity'	=>     $_POST["quantity_hidden"]
			);
			$_SESSION["shopping_cart"][$count] = $products;
		} else {
			echo "Item Already Added";
			echo '<script>window.location="index.php"</script>';
		}
	} else {
		$products = array(
			'item_id'			=>     $_GET["id"],
			'item_name'			=>     $_POST["name_hidden"],
			'item_price'		=>     $_POST["price_hidden"],
			'item_quantity'		=>     $_POST["quantity_hidden"]
		);
		$_SESSION["shopping_cart"][0] = $products;
	}
}
if (isset($_GET["action"])) {
	if ($_GET["action"] == "delete") {
		foreach ($_SESSION["shopping_cart"] as $keys => $values) {
			if ($values["item_id"] == $_GET["id"]) {
				unset($_SESSION["shopping_cart"][$keys]);
				echo "Item Removed";
				echo '<script>window.location="index.php"</script>';
			}
		}
	}
}

echo $html_pieces[2];
