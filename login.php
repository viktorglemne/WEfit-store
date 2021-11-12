<?php
session_start();

require_once 'classes/config.php';
require_once "classes/component.php";
$titel = "Log in | WEfit Bäst på kosttilskott";
$html_login = file_get_contents("html/login.html");
// menu($titel);

echo $html_login;

try {
    if (!isset($_SESSION['username'])) {
        $userEmail = $_POST["email"];
        $userPass = $_POST["pass"];
        $stmt = $pdo->query("SELECT * FROM customer WHERE email='$userEmail' AND pass = '$userPass';");
        $row = $stmt->fetch();
        if ($stmt->rowCount() < 1) {
            $_SESSION['username'] = NULL;
            throw new Exception('User not found');
        } else {
            echo "You have successfully logged in as ", $row['email'];
            $_SESSION["email"] = $row['id'];
        }
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
}