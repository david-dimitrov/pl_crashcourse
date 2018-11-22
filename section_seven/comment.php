<?php
//includes
session_start();
require_once ('lib/DataBase.php');
require_once ('lib/smtemplate.php');
$dataBase = new DB();

//Post Variablen laden
$plaintext = $_POST["plaintext"];
$cid = $_POST["cid"];
$mid = $_POST["mid"];
//Data
$caseSuccess = $dataBase->editComment($_SESSION["username"],$_SESSION["password"],$plaintext,$mid,$cid);

switch ($caseSuccess)
{
    case 0:
        $data = "Ihr Kommentar wurde erfolgreich eingereicht.";
        break;
    case 1:
        $data = "Ihr Kommentar wurde erfolgreich geändert.";
        break;
    case 2:
        $data = "Ich fürchte wir können gerade nicht feststellen, ob sie eingeloggt sind. Falls dies für sie öffter der Fall ist, sollten sie unseren Support kontaktieren";
        break;
    case 3:
        $data = "Es ist ein Fehler aufgetreten, der es ihnen ermöglichte Kommentare anderer Nutzer zu ändern. Bitte unterlassen sie das ;)";
    default:
        $data = "Ihre Anfrage ist gescheitert. Bitte versuchen sie es später erneut oder kontaktieren sie unseren Support.";
}

$dataBase = null;
return $data;