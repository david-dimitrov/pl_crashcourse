<?php

function smarty_modifier_minimize($input)
{
    $input = preg_replace('/^s+|\n|\r|\t$/m', '', $input);
    // Kommentare entfernen
    $input = preg_replace('//sU', '', $input);
    
    return $input;
}
?>