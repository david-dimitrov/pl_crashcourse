<?php
// includes | Entgegennahme der Parameter
if (session_status() != 2)
{
    session_start() or die("session konnte nicht aufgebaut werden.");    
}
require_once ('lib/smtemplate.php');
require_once ('lib/DB.php');
$dataBase = DB::getInstance();
$dataBase = DB::getInstance();

if (isset($_POST["action"])){
    $action = "lib/".$_POST["action"].".php";
    include_once $action;
    die();
}

// Entgegennahme und erste Verarbeitung Login-Daten
$_SESSION["status"] = $_SESSION["status"] ?? null;
$_SESSION["firstVisit"] = $_SESSION["firstVisit"] ?? true;

// Berechnung
// Anmeldestatus
// Falls anmeldung erfolglos bleibt, soll Nutzername 'null' sein, damit abfragen während dem Nachladen richtig ausgeführt werden können.
if ($_SESSION["firstVisit"]) {
    $status["loginMsg"] = "Sie sind noch nicht angemeldet.";
    $_SESSION["firstVisit"] = false;
}
$status = array(
    "boolLogin" => false,
    "uid"       => null,
    "template"  => "view_loginForm",
    "loginMsg" => "Sie sind nicht eingeloggt.",
    "loginMsgStyle" => ""
);
// Datenerfassung Content
$contentData = $dataBase->getContents();
// Datenerfassung User & Login
$loginData = array(
    "loginMsg" => $status["loginMsg"],
    "loginMsgStyle" => $status["loginMsgStyle"]
);

// rendern
$dataBase = null;

$tpl = new SMTemplate();

$tpl->render($loginData, $status['boolLogin'], $contentData);
?>