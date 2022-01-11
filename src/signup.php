<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// include component and config once that consists with useful components and database conneciton
require_once 'classes/config.php';
require_once "classes/component.php";

// sets titel to page 
$titel = "Bli medlem | WEfit Bäst på kosttilskott";
// displays menu and title
menu($titel);

// sets html dokumnet in variable
$html_signup = file_get_contents("html/signup.html");
// splits html documnet in pieces
$html_pieces = explode("<!--===explode===-->", $html_signup);

// trigger exceptions in with a try element
try {
    // if user session not ben set display sign up form
    if (!isset($_SESSION['username'])) {

        // strips post element and saves in variable
        $USER = strip_tags($_POST["email"]);
        $PASS = $_POST["password"];

        // hash password with default algoritm 
        $PASS_HASH = password_hash($PASS, PASSWORD_DEFAULT);
        $ADRESS = strip_tags($_POST["address"]);
        $POSTNR = strip_tags($_POST["zipcode"]);
        $ORT = strip_tags($_POST["state"]);
        $TELE = strip_tags($_POST["phonenumber"]);
        $stmt = $pdo->query("SELECT * FROM `customer` WHERE `email` = '$USER'");

        // checks if email already exist in database and show error
        if ($stmt->rowCount() > 0) {
            $html_pieces[2] = str_replace('<!---', "", $html_pieces[2]);
            $html_pieces[2] = str_replace('--->', "", $html_pieces[2]);
            echo $html_pieces[0];
            echo $html_pieces[1];
            echo $html_pieces[2];
            echo $html_pieces[3];

        // if email not exist then insert new customer in database 
        } else {
            // insert statement to database
            $sql = "INSERT INTO `customer`(`email`, `password`, `address`, `zipcode`, `state`, `phonenumber`) VALUES ('$USER','$PASS_HASH','$ADRESS','$POSTNR','$ORT','$TELE')";
            // execute statement 
            $result = $pdo->query($sql);
            // sets email and pass value in form in html document to make login possible
            $html_pieces[4] = str_replace('--email--', $USER, $html_pieces[4]);
            $html_pieces[4] = str_replace('--pass--', $PASS, $html_pieces[4]);
            echo $html_pieces[0];
            echo $html_pieces[4];
        }
    // sets session and locate back to userpage    
    } else {
        $_SESSION["username"] = $USER;
        header("location: userpage.php");
    }

    // If error in the exception then catch and return a error message
} catch (\Throwable $e) {
    echo $e->getMessage();
}

// gets the footer html documnet and displays it
$footer = file_get_contents("html/footer.html");
echo $footer;
