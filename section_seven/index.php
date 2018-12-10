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
$_SESSION["status"] = null;
$_SESSION["username"] = $_POST["username"] ?? null;
$_SESSION["password"] = $_POST["password"] ?? "";
$_SESSION["password"] = md5($_SESSION["password"]);
$_SESSION["firstVisit"] = $_SESSION["firstVisit"] ?? true;
$formType = $_POST["action"] ?? null;

// Berechnung
// Anmeldestatus
if ($formType == "login" || $formType == null) {
    $status = $dataBase->checkLogin($_SESSION["username"], $_SESSION["password"]);
} elseif ($formType == "registrieren") {
    $status = $dataBase->register($_SESSION["username"], $_SESSION["password"]);
} else {
    die("Es ist ein Fehler aufgetreten. bitte laden sie die Seite erneut.");
}
// Falls anmeldung erfolglos bleibt, soll Nutzername 'null' sein, damit abfragen während dem Nachladen richtig ausgeführt werden können.
if (! $status["boolLogin"]) {
    $_SESSION["username"] = null;
    $_SESSION["password"] = "";
    
    if ($_SESSION["firstVisit"]) {
        $status["loginMsg"] = "Sie sind noch nicht angemeldet.";
        $_SESSION["firstVisit"] = false;
    }
}
// Datenerfassung Content
$contentData = $dataBase->getContents();
// Datenerfassung User & Login
$loginData = array(
    "username" => $_SESSION["username"],
    "loginMsg" => $status["loginMsg"],
    "loginMsgStyle" => $status["loginMsgStyle"]
);

// rendern
$dataBase = null;

$tpl = new SMTemplate();

$tpl->render($loginData, $status['boolLogin'], $contentData);
?>