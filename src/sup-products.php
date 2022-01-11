<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// include component and config once that consists with useful components and database conneciton
require_once "classes/component.php";
require_once "classes/config.php";

// sets titel to page 
$titel = "Kosttillskott hos WEfit | Bäst på kosttillskott";
// displays menu and title
menu($titel);

// sets html dokumnet in variable
$html_products = file_get_contents("html/products.html");
// splits html documnet in pieces
$html_pieces = explode("<!--===explode===-->", $html_products);
// displays the first index of the html split
echo $html_pieces[0];

// prepare sql statement for selection of all row in table with where clause
$stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'supplement'");
// execute the statment
$stmt->execute();
// takes the fetched data and return it as a assite array
$stmt->setFetchMode(PDO::FETCH_ASSOC);
// fetch all data and sets it in an array
$result = $stmt->fetchAll();

// iterates through an array where the value of the element gets assigned to the variable
foreach ($result as $row) {

	$tmp = $html_pieces[2];

	$id = $row['idproducts'];
	$name = $row['name'];
	$price = $row['price'];
	$image = $row['image'];

	// replace values in html with fetched data
	$tmp = str_replace("--description_page--", "description.php?id=$id", $tmp);
	$tmp = str_replace('--name--', $name, $tmp);
	$tmp = str_replace('--price--', $price, $tmp);
	$tmp = str_replace('--image--', $image, $tmp);
	$tmp = str_replace('--id--', $id, $tmp);

	// for each id that is divisible by 4 display value in html document
	// value that gets displayed breaks div element in html to display products in 4 per row
	if ($id % 4 == 0) {
		$tmp = str_replace('<!---', " ", $tmp);
		$tmp = str_replace('--->', " ", $tmp);
		echo $tmp;
	// else continue with element until next value that is divisible with 4 displays 	
	} else {
		// echo out the assigned values for html_pieces
		echo $tmp;
	}
}

// echo last piece of the html documnet
echo $html_pieces[3];

// gets the footer html documnet and displays it
$footer = file_get_contents("html/footer.html");
echo $footer;
