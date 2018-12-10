<?php
//DB, Smarty
require_once ('lib/DB.php');
require_once ('lib/smtemplate.php');
$dbh = DB::getInstance();
$tpl = new SMTemplate();

$status = $dbh->checkLogin($_POST["username"],md5($_POST["password"]));
$status["username"] = $_POST["username"];

$substitute = $tpl->showContent($status, $status["template"]);
$_SESSION["status"] = $status["uid"];

echo $substitute;
?>