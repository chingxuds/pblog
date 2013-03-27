<?php
$date_format = 'Y-m-d H:i:s';
$server_timezone = 'Asia/Shanghai';

function dateFormat($time='0')
{
	return date($GLOBALS['date_format'],$time);
}
?>