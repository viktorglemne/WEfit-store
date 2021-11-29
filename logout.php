<?php
session_start();

require_once 'classes/config.php';
require_once "classes/component.php";

unset($_SESSION['username']);

header("location: Index.php");