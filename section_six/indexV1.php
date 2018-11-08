<?php
require_once 'ajaxController.php';
$ajaxController = new ajaxController();
$return = $ajaxController->execute();
echo  $return;
?>