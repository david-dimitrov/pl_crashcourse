<?php
/*//Inculde test
$var = 1;
include 'func.inc.php';
echo $var;
*/
/*//Kekse und co.
include 'param.inc.php';
$cookie = $_COOKIE["param2Cookie"];
echo $paramToLoad.$cookie;
*/
/*//Session test
session_start();
$_SESSION["proof"] = $_SESSION["proof"] ?? true;

if (isset($_POST["boolean"]))
{
    if ($_POST["boolean"]=="true")
    {
        $_SESSION["proof"] = true;
    }
    else
    {
        $_SESSION["proof"] = false;
    }
}
else
{
    $_SESSION["proof"] = true;
}
if ($_SESSION["proof"])
{
    echo "true";
}
else
{
    echo "false";
}

echo 
    "<form action=\"index.php\" method=\"post\">
        <fieldset>
            <input type=\"radio\" id=\"true\" name=\"boolean\" value=\"true\">
            <labe for=\"true\">True</label>
            <input type=\"radio\" id=\"false\" name=\"boolean\" value=\"false\">
            <labe for=\"false\">False</label>
        </fieldset>
        <input type=\"Submit\">
    </form>
    <a href=\"prog2.php\">hier zum Test</a>";
*///End of Session test

/*//Date and timestamp test
$var0 = time();
$var0 = "heute ist der: ".date("j:n:Y",$var0);

echo $var0."<br><br>";

$varDiff = $_GET["diff"];
echo $varDiff."<br>Der Upload ist ";
$varcomp = date("y",$varDiff)-70;
if ($varcomp >= 1)
{
    echo "über ein Jahr alt.";    
}
else
{
    $varcomp = date("n",$varDiff)." Monate alt.";
    //... und so weiter ...
}
echo $varcomp."<br>";
*///EO Timestamp...

/*//File IO test
$var0 = $_GET["var0"];
echo $var0."<br>";


if (file_exists($var0))
{
    $read = file_get_contents($var0);
    echo count($read)."<br/>";
    $var1 = explode("\n", $read);
    echo count($var1)."<br/><br>";
    echo "<br>1<br>";
    $outString = "";
    
    for($i=0; $i<count($var1); $i++)
    {
        echo $i." : ".$var1[$i]."<br/>";
        
        $placeholder = explode(",", $var1[$i])[1];
        echo $placeholder." ==>"; //Ausgabe aktueller Wert
        $placeholder += 3;
        echo $placeholder."<br/>"; //Ausgabe neuer Wert
        $var1[$i] = explode(",",$var1[$i])[0].",".$placeholder; //Rückzusammensetzungder Zeile
        echo $var1[$i]."<br>";    
    }    
    $outString = implode("\n", $var1);
    echo "<br>".nl2br($outString)."<br>";
    file_put_contents($var0, $outString);
}*/

//phpinfo();
?>