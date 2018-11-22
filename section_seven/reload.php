<?php
//includes
session_start();
require_once ('lib/DataBase.php');
require_once ('lib/smtemplate.php');
$dataBase = new DB();

//Post Variablen laden
$method = $_POST["method"];
$value = $_POST["value"];
//Data
$data = "";

//berechnung
if($method == "loadFilmDetail")
{
    $data = $dataBase->getFilmDetailContents($value, $_SESSION["username"], $_SESSION["password"]);
    //Formating
    $tpl = new SMTemplate();
    $substitute = $tpl->showContent($data);
}
else
{
    die("Es ist ein Fehler aufgetreten: <a href='index.php'>Zurück</a>");
}


//Output
$dataBase = null;

echo $substitute;
?>