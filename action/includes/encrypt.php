<?php
$prefix_md5 = '$1$';
$prefix_replace = '$P$';

function code_md5($text = 'NULL') {
    $text_coded = crypt($text, $GLOBALS["prefix_md5"] . md5($text));
    return str_replace($GLOBALS["prefix_md5"], $GLOBALS["prefix_replace"], $text_coded);
}
?>