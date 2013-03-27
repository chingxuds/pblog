<?php
require './includes/encrypt.php';

$username_input = $_POST['username_input'];
$userpass_input = $_POST['userpass_input'];
$nicename_input = $_POST['nicename_input'];
$useremail_input = $_POST['useremail_input'];

$userpass_coded = code_md5($userpass_input);

echo $username_input . '||' . $userpass_input . '||' . $nicename_input . '||' . $useremail_input . '<br />';
echo $userpass_coded;
?>