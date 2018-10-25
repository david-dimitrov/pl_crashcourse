<?php
$dataSets = str_getcsv(file_get_contents("Artothek.csv"),";");
$key = "Orientation";
$value = "Keine Angabe";

echo $dataSets[100];

?>