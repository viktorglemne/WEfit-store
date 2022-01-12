<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// include component and config once that consists with useful components and database conneciton
require_once 'classes/config.php';
require_once "classes/component.php";

// sets titel to page 
$titel = "Log in | WEfit Bäst på kosttilskott";
// displays menu and title
menu($titel);

// sets user session i variable
$USER = $_SESSION['username'];

// sets sql statement for selection of all row in table with where clause in variable
$query  = "SELECT * FROM `customer` WHERE email='$USER'";
// execute the statment
$result = $pdo->query($query);
// fetches the next row from a result set
$row = $result->fetch();

// sets user id in variable
$USER_ID = $row['idcustomer'];

// sets html dokumnet in variable
$html_login = file_get_contents("html/login.html");
// splits html documnet in pieces
$html_pieces = explode("<!--===explode===-->", $html_login);

// trigger exceptions in with a try element
try {
    if (!isset($USER)) {
        echo $html_pieces[0];
        echo $html_pieces[1];
    } elseif (isset($USER)) {
        echo $html_pieces[2];
        // query a statment to fetch data from database
        $stmt = $pdo->prepare("SELECT * FROM `orders` WHERE `customer_idcustomer` = '$USER_ID';");
        // fetch all data in an array and saved in a variable
        $stmt->execute();
        // takes the fetched data and return it as a assite array
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row2 = $stmt->fetchAll();

        // loops through all values in fetch array
        foreach ($row2 as $val) {
            // sets html split in variable
            $tmp = $html_pieces[3];

            // sets value in variable
            $orderNr = $val['idorder'];
            $date = $val['date'];
            $totalprice = $val['totalprice'];

            // replace value in html dockumnet with new value from database
            // value too the order
            $tmp = str_replace('--Ordernr--', $orderNr, $tmp);
            $tmp = str_replace('--Date--', $date, $tmp);
            $tmp = str_replace('--totalprice--', $totalprice, $tmp);

            // echo out the assigned values for html_pieces
            echo $tmp;
        }
        // display html split
        echo $html_pieces[4];

        // sets html documnet in variable
        $html_signup = file_get_contents("html/signup.html");
        // splits html documnet in pieces
        $html_pieces_signup = explode("<!--===explode===-->", $html_signup);

        // display html split
        echo $html_pieces_signup[0];

        // sets html documnet in variable
        $tmp_signup_1 = $html_pieces_signup[1];
        // replace value in html document
        $tmp_signup_1 = str_replace('member', 'settings', $tmp_signup_1);
        $tmp_signup_1 = str_replace('Bli Medlem!', 'Uppgifter', $tmp_signup_1);
        $tmp_signup_1 = str_replace('bli en del av WEfit', 'uppdatera dina uppgifter', $tmp_signup_1);
        $tmp_signup_1 = str_replace('signup.php', 'action.php', $tmp_signup_1);
        // display split
        echo $tmp_signup_1;

        // sets html documnet in variable
        $tmp_signup_3 = $html_pieces_signup[3];
        // replace value in html document
        $tmp_signup_3 = str_replace('Bli Medlem!', 'Spara', $tmp_signup_3);
        // display splits
        echo $tmp_signup_3;
        echo $html_pieces[6];
    }

// If error in the exception then catch and return a error message    
} catch (\Throwable $e) {
    echo $e->getMessage();
}

// gets the footer html documnet and displays it
$footer = file_get_contents("html/footer.html");
echo $footer;

