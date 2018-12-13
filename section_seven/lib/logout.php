<?php
if (session_status() != 2)
{
    session_start() or die("session konnte nicht aufgebaut werden.");    
}
unset($_SESSION["status"]);
unset($_POST["action"]);

$data = array(
    "loginMsg" => "Sie sind nicht eingeloggt.",
    "loginMsgStyle" => ""
);

require_once 'smtemplate.php';
$tpl = new SMTemplate();
echo $tpl->showContent($data,"view_loginForm");
?>