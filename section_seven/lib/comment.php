<?php
// includes
if (session_status() != 2)
{
    session_start() or die("session konnte nicht aufgebaut werden.");    
}
require_once ('DB.php');
require_once ('smtemplate.php');
$dataBase = DB::getInstance();

function getData($param)
{
    switch ($param) {
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
            break;
        case 4:
            $data = "Ihr Kommentar wurde erfolgreich gelöscht.";
            break;
        default:
            $data = "Ihre Anfrage ist gescheitert. Bitte versuchen sie es später erneut oder kontaktieren sie unseren Support.";
    }
    return $data;
}

// Post Variablen laden
$plaintext = $_POST["plaintext"];
$cid = $_POST["cid"];
$mid = $_POST["mid"];
$del = $_POST["del"];
// Data

$caseSuccess = $dataBase->editComment($_SESSION["status"], $plaintext, $mid, $cid, $del);

$data = getData($caseSuccess);

$dataBase = null;
echo $data;
?>