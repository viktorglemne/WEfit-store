<?php
session_start();
// index-file and frontpage
require_once "classes/component.php";
$titel = "Kosttillskott hos WEfit | Bäst på kosttillskott";
menu($titel);
$html_products = file_get_contents("html/products.html");
$html_pieces = explode("<!--===explode===-->", $html_products);
echo $html_pieces[0];

require_once "classes/config.php";
$stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'supplement'");
$stmt->execute();
// takes the fetched data and return it as a assite array
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();

// iterates through an array where the value of the element gets assigned to the variable
foreach ($result as $row) {

	$tmp = $html_pieces[2];

	$id = $row['idproducts'];
	$name = $row['name'];
	$price = $row['price'];
	$image = $row['image'];

	$tmp = str_replace("--description_page--", "description.php?id=$id", $tmp);
	$tmp = str_replace('--name--', $name, $tmp);
	$tmp = str_replace('--price--', $price, $tmp);
	$tmp = str_replace('--image--', $image, $tmp);
	$tmp = str_replace('--id--', $id, $tmp);

	if ($id % 4 == 0) {
		$tmp = str_replace('<!---', " ", $tmp);
		$tmp = str_replace('--->', " ", $tmp);
		echo $tmp;
	} else {
		// echo out the assigned values for html_pieces
		echo $tmp;
	}
}

echo $html_pieces[3];

$footer = file_get_contents("html/footer.html");
echo $footer;
