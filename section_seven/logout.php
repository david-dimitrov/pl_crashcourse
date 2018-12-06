<?php
session_start();
unset($_SESSION["password"]);
unset($_SESSION["username"]);
include_once 'index.php';
?>