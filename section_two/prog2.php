<?php
session_start();
echo "es ist:";
if ($_SESSION["proof"])
{
    echo " True";
}
else
{
    echo " False";
}
?>