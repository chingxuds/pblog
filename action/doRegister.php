<?php
require './includes/encrypt.php';
require './includes/dateformat.php';
require './includes/db.php';

$username = $_POST['username_input'];
$userpass = code_md5($_POST['userpass_input']);
$nicename = $_POST['nicename_input'];
$displayname = $nicename;
$useremail = $_POST['useremail_input'];
$register_time = dateFormat(date_timestamp_get(date_create($_POST['register_time'])));
$register_time_gmt = dateFormat($_SERVER['REQUEST_TIME']);
$status = 0;

$sql = "INSERT INTO pb_users (user_login,user_pass,user_nicename,user_displayname,user_email,user_registered,user_registered_gmt,user_status) VALUES ('$username','$userpass','$nicename','$displayname','$useremail','$register_time','$register_time_gmt','$status')";
$result = doQuery($sql);
echo $result;
?>