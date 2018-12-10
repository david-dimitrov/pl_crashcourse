<?php
if (session_status() != 2)
{
    session_start() or die("session konnte nicht aufgebaut werden.");    
}
// includes
require_once ('lib/DB.php');
require_once ('lib/smtemplate.php');
$dataBase = DB::getInstance();

// Post Variablen laden
$method = $_POST["method"];
$value = $_POST["value"];

// berechnung
if ($method == "loadFilmDetail") {
    $data = $dataBase->getFilmDetailContents($value);
    // Formating
    $tpl = new SMTemplate();
    $substitute = $tpl->showContent($data);
} elseif ($method == "loadFilmComments") {
    $data = $dataBase->getFilmComments($value, $_SESSION["status"]);
    // Formating
    if(isset($_SESSION["status"])){
        $data["logedin"] = true;
    }
    else
    {
        $data["logedin"] = false;
    }
    $tpl = new SMTemplate();
    $substitute = $tpl->showContent($data, "view_commentDisplay");
} else {
    die("Es ist ein Fehler aufgetreten: <a href='index.php'>Zurück</a>");
}

// Output
echo $substitute;
?>