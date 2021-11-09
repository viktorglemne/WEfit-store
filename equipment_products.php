<?php
session_start();
// index-file and frontpage
require_once "classes/component.php";
$titel = "Kläder hos WEfit | Bäst på kosttilskott";
menu($titel);
$html_products = file_get_contents("html/general_products.html");
$html_pieces = explode("<!--===explode===-->", $html_products);
echo $html_pieces[0];

require_once "classes/config.php";
$stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'equipment'");
$stmt->execute();
// takes the fetched data and return it as a assite array
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();

if (!$result) {
	$pdo->exec("INSERT INTO products (id, name, image, price) VALUES
		(1, 'produkt 1', 'products_images/product_default.jpeg', 100.00),
    	(2, 'produkt 2', 'products_images/product_default.jpeg', 200.00),
    	(3, 'produkt 3', 'products_images/product_default.jpeg', 300.00),
    	(4, 'produkt 4', 'products_images/product_default.jpeg', 300.00)
		(5, 'produkt 5', 'products_images/product_default.jpeg', 100.00),
    	(6, 'produkt 6', 'products_images/product_default.jpeg', 200.00),
    	(7, 'produkt 7', 'products_images/product_default.jpeg', 300.00),
    	(8, 'produkt 8', 'products_images/product_default.jpeg', 300.00)");

	$stmt = $pdo->prepare("SELECT * FROM products");
	$stmt->execute();
	// takes the fetched data and return it as a assite array
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$result = $stmt->fetchAll();
	foreach ($result as $row) {

		$tmp = $html_pieces[1];

		$id = $row['id'];
		$name = $row['name'];
		$price = $row['price'];
		$image = $row['image'];

		$tmp = str_replace('--name--', $name, $tmp);
		$tmp = str_replace('--price--', $price, $tmp);
		$tmp = str_replace('--image--', $image, $tmp);
		$tmp = str_replace('--id--', $id, $tmp);

		// echo out the assigned values for html_pieces
		echo $tmp;
	}
} else {
	// iterates through an array where the value of the element gets assigned to the variable
	foreach ($result as $row) {

		$tmp = $html_pieces[1];

		$id = $row['id'];
		$name = $row['name'];
		$price = $row['price'];
		$image = $row['image'];

		$tmp = str_replace("--action--", "products.php?action=add&id=$id", $tmp);
		$tmp = str_replace('--name--', $name, $tmp);
		$tmp = str_replace('--price--', $price, $tmp);
		$tmp = str_replace('--image--', $image, $tmp);
		$tmp = str_replace('--id--', $id, $tmp);

		// echo out the assigned values for html_pieces
		echo $tmp;
	}
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
