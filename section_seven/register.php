<?php
if (session_status() != 2)
{
    session_start() or die("session konnte nicht aufgebaut werden.");    
}
//DB, Smarty
require_once ('lib/DB.php');
require_once ('lib/smtemplate.php');
$dbh = DB::getInstance();
$tpl = new SMTemplate();

$status = $dbh->register($_POST["username"], md5($_POST["password"]));
$status["username"] = $_POST["username"];

$substitute = $tpl->showContent($status, $status["template"]);
echo $substitute;
?>