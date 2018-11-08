<?php
$user = "root";
$pass = "";

$dbh = new PDO('mysql:host=localhost;dbname=pl_crashcourse', $user, $pass);

$effected = $dbh->exec("DELETE FROM `user` WHERE uid != 1");
echo "es wurden ".$effected." Datensätz(e) gelöscht.<br><a href = 'index.php'>Zurück zur Seite</a>";
$dbh =null;
?>