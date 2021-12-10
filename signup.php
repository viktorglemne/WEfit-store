<?php
session_start();

require_once 'classes/config.php';
require_once "classes/component.php";

try {
    if (!isset($_SESSION['username'])) {
        $USER = $_POST["email"];
        $PASS = $_POST["pass"];
        $ADRESS = $_POST["adress"];
        $POSTNR = $_POST["postnr"];
        $ORT = $_POST["ort"];
        $PHONE = $_POST["telefonnr"];
        $stmt = $pdo->query("SELECT * FROM `customer` WHERE `email` = '$USER'");

        if ($stmt->rowCount() > 0) {
            $titel = "Bli medlem | WEfit Bäst på kosttilskott";
            menu($titel);
            $html_signup = file_get_contents("html/signup.html");
            $html_signup = str_replace('<!---', "", $html_signup);
            $html_signup = str_replace('--->', "", $html_signup);
            echo $html_signup;
        } else {
            $titel = "Bli medlem | WEfit Bäst på kosttilskott";
            menu($titel);
            $html_signup = file_get_contents("html/signup.html");
            echo $html_signup;
            $sql = "INSERT INTO `customer`(`email`, `pass`, `adress`, `postnr`, `ort`, `telefonnr`, `admin`) VALUES ('$USER','$PASS','$ADRESS','$POSTNR','$ORT','$PHONE',0)";
            $result = $pdo->query($sql);
            header("location: signup.php");
            header("location: login.php");
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
