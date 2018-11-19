<?php
require_once ('lib/smtemplate.php');

$tpl = new SMTemplate();

$data = array("data" => "Das hier sind daten");

$tpl->render('view_start',$data);
?>