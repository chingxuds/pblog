<?php
echo dirname(dirname(dirname(dirname(__FILE__))));
echo "<br />";
echo dirname(dirname(dirname(dirname($_SERVER['PHP_SELF']))));
?>