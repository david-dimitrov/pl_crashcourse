<?php
$dataSets = file("Artothek.csv");
$key = "Orientation";
$keyName = $key;
$value = "Keine Angabe";
//echo $dataSets[0]."<br>";

//find Orientation
$template = $dataSets[0];
$template = explode(";", $template);
for ($i=0;$i<count($template);$i++){
    if ($template[$i] == $key){
        //suchattribut belegen
        $key = $i;
        break;
    }elseif ($i == (count($template)-1)){
        die("das Atribut ist nicht enthalten.");
    }
}
echo "Das gesuchte Atribut befindet sich an Stelle ".$key." eines Datensatzes<br>";
//finden und Sammeln aller zutreffenden Datensätze
$dataSetPositives = array(); //das Array, das alle zutreffenden Datensätze als referenz aufnimmt
$dataSetValuePosibilities = array(); //FTLOLZ alle Möglichen Values für $key 
for ($i=1;$i<count($dataSets);$i++){
    if (explode(";", $dataSets[$i])[$key]==$value){
        $dataSetPositives[] = $i;
        //echo $i."; ".$dataSets[$i]."<br><br>";
    }else{ //FTLolz (kann weg)
        if (!in_array(explode(";", $dataSets[$i])[$key], $dataSetValuePosibilities)){
            $dataSetValuePosibilities[] = explode(";", $dataSets[$i])[$key];
        }
    }
}
//Ausgabe
    //Formatierung
$outStringPositives = "wurde";
if (count($dataSetPositives)==1){
    $outStringPositives .= " ein Datensatz";
}else{
    $outStringPositives .= "n ".count($dataSetPositives)." Datensätze";
}
    //Print
echo "Es ".$outStringPositives." mit dem Wert: \""
    .$value."\" für das Atribut \"".$keyName
    ."\" gefunden.<br>Andere mögliche Werte, die man für dieses Atribut auszählen kann sind:<br>";
for ($i=0;$i<count($dataSetValuePosibilities);$i++){
    echo "   -".$dataSetValuePosibilities[$i]."<br>";
}

/*Scrap Code*/
/* Key wird richtig gefunden :
echo $template[$key]."<br>";
echo explode(";",$dataSets[])[$key];
*/
?>
