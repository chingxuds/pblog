<?php
require './includes/encrypt.php';
require './includes/db.php';

$username = $_POST['username_input'];
$userpass = code_md5($_POST['userpass_input']);
echo $userpass;
$sql = "SELECT * FROM pb_users WHERE user_pass='$userpass' AND user_login='$username'";
$result = doQuery($sql);
if ($result === FALSE) {
    echo "查询失败";
} else {
    echo "查询成功";
    $arr = mysqli_fetch_assoc($result);
    foreach ($arr as $key => $value) {
        echo $key . '=>' . $value;
    }
}
?>
