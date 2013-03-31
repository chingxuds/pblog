<?php
require 'action/inc/encrypt.php';
require 'action/inc/dateformat.php';
require 'action/inc/db.php';

// ** 若会话尚未开启，则开启之 ** //
if (session_status () == PHP_SESSION_NONE) {
	session_start ();
}

// ** 根据动作参数调用不同函数 ** //
$action = $_POST ['action'];
switch ($action) {
	case 'login' :
		login ();
		break;
	case 'register' :
		register ();
		break;
	
	default :
		break;
}

/**
 * 登录函数
 */
function login() {
	// ** 获取前台传入数据 ** //
	$username = $_POST ['username_input'];
	$userpass = code_md5 ( $_POST ['userpass_input'] );
	
	// ** 查询数据库验证信息 ** //
	$sql = "SELECT user_id,user_displayname,user_status FROM pb_users WHERE user_pass='$userpass' AND user_login='$username'";
	$result = doQuery ( $sql );
	if ($result === FALSE) {
		echo "查询失败";
	} else {
		$_SESSION ["isLogin"] = TRUE;
		$arr = mysqli_fetch_assoc ( $result );
		$user ["id"] = $arr ["user_id"];
		$user ["displayname"] = $arr ["user_displayname"];
		$user ["status"] = $arr ["user_status"];
		$_SESSION ["user"] = $user;
		header ( 'Location:../index.php' );
	}
}

/**
 * 注册函数
 */
function register() {
	// ** 获取前台传入数据 ** //
	$username = $_POST ['username_input'];
	$userpass = code_md5 ( $_POST ['userpass_input'] );
	$nicename = $_POST ['nicename_input'];
	$displayname = $nicename;
	$useremail = $_POST ['useremail_input'];
	$register_time = dateFormat ( date_timestamp_get ( date_create ( $_POST ['register_time'] ) ) );
	$register_time_gmt = dateFormat ( $_SERVER ['REQUEST_TIME'] );
	$status = 0;
	
	// ** 把数据加入到数据库中以完成注册 ** //
	$sql = "INSERT INTO pb_users (user_login,user_pass,user_nicename,user_displayname,user_email,user_registered,user_registered_gmt,user_status) VALUES ('$username','$userpass','$nicename','$displayname','$useremail','$register_time','$register_time_gmt','$status')";
	$result = doQuery ( $sql );
	echo $result;
}
?>
