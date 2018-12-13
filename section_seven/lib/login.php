<?php
if (session_status() != 2)
{
    session_start() or die("session konnte nicht aufgebaut werden.");    
}
//DB, Smarty
require_once ('DB.php');
require_once ('smtemplate.php');
$dbh = DB::getInstance();
$tpl = new SMTemplate();

$status = $dbh->checkLogin($_POST["username"],md5($_POST["password"]));
$status["username"] = $_POST["username"];

$substitute = $tpl->showContent($status, $status["template"]);
echo $substitute;
?>