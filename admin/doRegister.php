<?php
require './includes/encrypt.php';
require './includes/dateformat.php';

$username = $_POST['username_input'];
$userpass= code_md5($_POST['userpass_input']);
$nicename = $_POST['nicename_input'];
$useremail = $_POST['useremail_input'];
$register_time = dateFormat(date_timestamp_get(date_create($_POST['register_time'])));
$register_time_gmt = dateFormat($_SERVER['REQUEST_TIME']);

echo $register_time;

?>