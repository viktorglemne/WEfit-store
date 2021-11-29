<?php
session_start();

require_once 'classes/config.php';
require_once "classes/component.php";

try {
    if (!isset($_SESSION['username'])) {
        $userEmail = $_POST["email"];
        $userPass = $_POST["pass"];
        $stmt = $pdo->query("SELECT * FROM customer WHERE email='$userEmail' AND pass = '$userPass';");
        $row = $stmt->fetch();
        if ($stmt->rowCount() < 1) {
            $_SESSION['username'] = NULL;
            $titel = "Log in | WEfit Bäst på kosttilskott";
            menu($titel);
            $html_login = file_get_contents("html/login.html");
            $html_pieces = explode("<!--===explode===-->", $html_login);
            $html_pieces[1] = str_replace('<a></a>', "Password or email did not match", $html_pieces[1]);
            echo $html_pieces[0];
            echo $html_pieces[1];
        } else {
            $_SESSION["username"] = $userEmail;
            header("location: userpage.php");
        }
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
}
