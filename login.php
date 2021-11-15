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
            // throw new Exception('User not found');
        } else {
            $_SESSION["username"] = $userEmail;
            header("location: userpage.php");
        }
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
}
