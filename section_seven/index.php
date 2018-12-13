<?php
// includes | Entgegennahme der Parameter
if (session_status() != 2)
{
    session_start() or die("session konnte nicht aufgebaut werden.");    
}
require_once ('lib/smtemplate.php');
require_once ('lib/DB.php');
$dataBase = DB::getInstance();


// Entgegennahme und erste Verarbeitung Login-Daten
$_SESSION["status"] = $_SESSION["status"] ?? null;

//nachladeaufrufe werden abgefangen
if (isset($_POST["action"])){
    $action = "lib/".$_POST["action"].".php";
    include_once $action;
    die();
}


// Berechnung
// Anmeldestatus
// Falls anmeldung erfolglos bleibt, soll Nutzername 'null' sein, damit abfragen während dem Nachladen richtig ausgeführt werden können.
if ($_SESSION["status"] != null) {
    $status = array(
        "boolLogin" => true,
        "uid"       => $_SESSION["status"],
        "template"  => "view_loginNameDisplay",
        "loginMsg" => "Wilkommen zurück.",
        "loginMsgStyle" => "class='loginMsgSuccess'"
    );
}
else
{
    $status = array(
        "boolLogin" => false,
        "uid"       => null,
        "template"  => "view_loginForm",
        "loginMsg" => "Sie sind nicht eingeloggt.",
        "loginMsgStyle" => ""
    );
}
// Datenerfassung Content
$contentData = $dataBase->getContents();
// Datenerfassung User & Login
$loginData = array(
    "loginMsg" => $status["loginMsg"],
    "loginMsgStyle" => $status["loginMsgStyle"],
    "username" => $dataBase->getUsername($_SESSION["status"])
);

// rendern
$dataBase = null;

$tpl = new SMTemplate();

$tpl->render($loginData, $status['boolLogin'], $contentData);
?>