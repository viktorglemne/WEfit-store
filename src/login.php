<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// include component and config once that consists with useful components and database conneciton
require_once 'classes/config.php';
require_once "classes/component.php";

// trigger exceptions in with a try element
try {
    if (!isset($_SESSION['username'])) {

        // save post value in variables 
        $USER = $_POST["email"];
        $PASS = $_POST["password"];

        // query a statment to fetch data from database
        $stmt = $pdo->query("SELECT * FROM customer WHERE email='$USER';");
        // fetch all data in an array and saved in a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // store fetched password in variable 
        $PASS_HASH = $row['password'];

        // unhash the password and check that it is valid
        if (password_verify($PASS, $PASS_HASH)) {
            $_SESSION["username"] = $USER;
            header('Location: userpage.php');
        // if password and email not match then display error     
        } else {
            $_SESSION['username'] = NULL;
            $titel = "Log in | WEfit Bäst på kosttilskott";
            menu($titel);
            $html_login = file_get_contents("html/login.html");
            $html_pieces = explode("<!--===explode===-->", $html_login);
            $html_pieces[1] = str_replace('<a></a>', "Lösenord och e-postadress matchade inte", $html_pieces[1]);
            echo $html_pieces[0];
            echo $html_pieces[1];
        }
    }

    // If error in the exception then catch and return a error message
} catch (\Throwable $e) {
    echo $e->getMessage();
}

// gets the footer html documnet and displays it
$footer = file_get_contents("html/footer.html");
echo $footer;
