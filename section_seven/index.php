<?php
//includes | Entgegennahme der Parameter
session_start() or die("session konnte nicht aufgebaut werden.");
require_once ('lib/smtemplate.php');
require_once ('lib/DataBase.php');
$dataBase = new DB();
//Entgegennahme und erste Verarbeitung Login-Daten
$_SESSION["username"] = $_POST["username"] ?? null;
$_SESSION["password"] = $_POST["password"] ?? ""; //GGF: Md5 -<-hier-<- implementieren
$_SESSION["firstVisit"] = $_SESSION["firstVisit"] ?? true;

//Berechnung
//Anmeldestatus
$status = $dataBase->checkLogin($_SESSION["username"], $_SESSION["password"]);

//Falls anmeldung erfolglos bleibt, soll Nutzername 'null' sein, damit abfragen während dem Nachladen richtig ausgeführt werden können.
if (!$status["boolLogin"])
{
    $_SESSION["username"] = null;
    $_SESSION["password"] = "";
    
    if ($_SESSION["firstVisit"])
    {
        $status["returnMsg"] = "Sie sind noch nicht angemeldet.";
        $_SESSION["firstVisit"] = false;
    }
}
//Datenerfassung Content
$contentData = $dataBase->getContents();
//Datenerfassung User & Login
$loginData = array("username" => $_SESSION["username"], "loginMsg" => $status["returnMsg"], "loginMsgStyle" => $status["loginMsgStyle"]);



//rendern
$dataBase = null;

$tpl = new SMTemplate();

$tpl->render($loginData, $status['boolLogin'], $contentData);
?>