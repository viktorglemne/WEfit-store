<?php
session_start();

require_once "classes/component.php";
$titel = "Log in | WEfit Bäst på kosttilskott";
menu($titel);

$html_login = file_get_contents("html/login.html");
$html_pieces = explode("<!--===explode===-->", $html_login);

function logIn()
{
    require_once 'classes/config.php';
    try {
        if (!isset($_SESSION['username'])) {
            // echo $html_pieces[10];
            $userEmail = $_POST["email"];
            $userPass = $_POST["pass"];
            $stmt = $pdo->query("SELECT * FROM customer WHERE email='$userEmail' AND pass = '$userPass';");
            $row = $stmt->fetch();
            if ($stmt->rowCount() < 1) {
                $_SESSION['username'] = NULL;
                // throw new Exception('User not found');
            } elseif (isset($_SESSION['username'])) {
                $_SESSION["username"] = $userEmail;
                // echo $html_pieces[2];
            }
        }
    } catch (\Throwable $e) {
        echo $e->getMessage();
    }
}
