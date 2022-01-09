<?php
session_start();

require_once 'classes/config.php';
require_once "classes/component.php";
$titel = "Bli medlem | WEfit Bäst på kosttilskott";
menu($titel);
$html_signup = file_get_contents("html/signup.html");
$html_pieces = explode("<!--===explode===-->", $html_signup);

try {
    if (!isset($_SESSION['username'])) {
        $USER = strip_tags($_POST["email"]);
        $PASS = $_POST["password"];
        $PASS_HASH = password_hash($PASS, PASSWORD_DEFAULT);
        $ADRESS = strip_tags($_POST["address"]);
        $POSTNR = strip_tags($_POST["zipcode"]);
        $ORT = strip_tags($_POST["state"]);
        $TELE = strip_tags($_POST["phonenumber"]);
        $stmt = $pdo->query("SELECT * FROM `customer` WHERE `email` = '$USER'");

        if ($stmt->rowCount() > 0) {
            $html_pieces[1] = str_replace('<!---', "", $html_pieces[1]);
            $html_pieces[1] = str_replace('--->', "", $html_pieces[1]);
            echo $html_pieces[0];
            echo $html_pieces[1];
        } else {
            $sql = "INSERT INTO `customer`(`email`, `password`, `address`, `zipcode`, `state`, `phonenumber`, `admin`) VALUES ('$USER','$PASS_HASH','$ADRESS','$POSTNR','$ORT','$TELE',0)";
            $result = $pdo->query($sql);
            $html_pieces[2] = str_replace('--email--', $USER, $html_pieces[2]);
            $html_pieces[2] = str_replace('--pass--', $PASS, $html_pieces[2]);
            echo $html_pieces[0];
            echo $html_pieces[2];
        }
    } else {
        $_SESSION["username"] = $USER;
        header("location: userpage.php");
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
}

$footer = file_get_contents("html/footer.html");
echo $footer;
