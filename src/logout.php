<?php
// session is started if you don't write this line can't use $_Session global variable
session_start();
// include component and config once that consists with useful components and database conneciton
require_once 'classes/config.php';
require_once "classes/component.php";

// unset user session
unset($_SESSION['username']);

// locate back to index page
header("location: index.php");