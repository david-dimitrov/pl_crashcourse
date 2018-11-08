<?php
// Aufgerufene Methode
$method = "";

// Rueckgabeobjekt
$result = "";

// Das zu ladende Datenset
$activeDataset = "";

// Daten
$flowers = array(
    "Rosen", "Tulpen", "Lilien", "Nelken"
);
$dogs = array(
    "Husky", "Shiba Inu", "Dogge"
);
$teams = array(
    "Borussia Dortmund", "Atheltico Madrid", "FC Liverpool"
);

//welche Methode?
if (isset($_POST['method']))
{
    $method = $_POST['method'];
}


//Datensatz entsprechend der Methode laden
switch($method)
{
    case "flowers":
        $activeDataset = $flowers;
        break;
    case "dogs":
        $activeDataset = $dogs;
        break;
    case "teams":
        $activeDataset = $teams;
        break;
    default:
        $activeDataset = null;
}

//Process Data
if (isset($activeDataset))
{
    for ($i=0;$i<count($activeDataset);$i++)
    {
        $result .= "<li>".$activeDataset[$i]."</li>";
    }
}
else
{
    $result= "Es ist ein Fehler aufgetreten.";
}


echo $result;