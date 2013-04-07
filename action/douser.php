<?php
require './inc/encrypt.php';
require './inc/dateformat.php';
require './inc/db.php';
require './inc/session.php';
require './dometa.php';

// ** 根据动作参数调用不同函数 ** //
$action = $_POST ['action'] ? $_POST ['action'] : $_GET ['action'];
switch ($action) {
	case 'login' :
		login ();
		break;
	case 'logout' :
		logout ();
		break;
	case 'register' :
		register ();
		break;
	case 'profile_update' :
		profile_update ();
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
	$sql = create_select_string ( "user_id,user_displayname,user_status", "pb_users", "user_pass='$userpass' AND user_login='$username'" );
	$result = doQuery ( $sql );
	if ($result === FALSE) {
		echo "查询失败";
	} else {
		$_SESSION ["isLogin"] = TRUE;
		$arr = mysqli_fetch_assoc ( $result );
		$user ["id"] = $arr ["user_id"];
		$user ["nicename"] = $arr ["user_nicename"];
		$user ["displayname"] = $arr ["user_displayname"];
		$user ["status"] = $arr ["user_status"];
		$_SESSION ["user"] = $user;
		header ( 'Location:' . $_SERVER ["HTTP_REFERER"] );
	}
}

/**
 * 登出函数
 */
function logout() {
	$_SESSION ["isLogin"] = FALSE;
	if (isset ( $_SESSION ["user"] ))
		unset ( $_SESSION ["user"] );
	if (isset ( $_SESSION ["user_profile"] ))
		unset ( $_SESSION ["user_profile"] );
	header ( 'Location:' . $_SERVER ["HTTP_REFERER"] );
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
	$set = "user_login='$username',user_pass='$userpass',user_nicename='$nicename',user_displayname='$displayname',user_email='$useremail',user_registered='$register_time',user_registered_gmt='$register_time_gmt',user_status='$register_time_gmt','$status'";
	$sql = create_insert_string ( "pb_users", $set );
	doQuery ( $sql );
	
	header ( 'Location:' . $_SERVER ["HTTP_REFERER"] );
}

/**
 * 个人资料更新函数
 */
function profile_update() {
	$object_type = "user";
	$object_id = $_SESSION ['user'] ['id'];
	
	$lastname = isset ( $_POST ['lastname'] ) ? $_POST ['lastname'] : FALSE;
	$firstname = isset ( $_POST ['firstname'] ) ? $_POST ['firstname'] : FALSE;
	$nicename = isset ( $_POST ['nicename'] ) ? $_POST ['nicename'] : FALSE;
	$displayname = isset ( $_POST ['displayname'] ) ? $_POST ['displayname'] : FALSE;
	$email = isset ( $_POST ['email'] ) ? $_POST ['email'] : FALSE;
	$tel = isset ( $_POST ['tel'] ) ? $_POST ['tel'] : FALSE;
	
	if ($lastname) {
		meta_update ( $object_type, $object_id, "lastname", $lastname );
		$_SESSION ['user_profile'] ['lastname'] = $lastname;
	}
	if ($firstname) {
		meta_update ( $object_type, $object_id, "firstname", $firstname );
		$_SESSION ['user_profile'] ['firstname'] = $firstname;
	}
	if ($tel) {
		meta_update ( $object_type, $object_id, "tel", $tel );
		$_SESSION ['user_profile'] ['tel'] = $tel;
	}
	
	$where = "user_id='$object_id'";
	if ($displayname) {
		$set = "user_displayname='$displayname'";
		$sql = create_update_string ( "pb_users", $set, $where );
		doQuery ( $sql );
		$_SESSION ['user'] ['displayname'] = $displayname;
	}
	if ($nicename) {
		$set = "user_nicename='$nicename'";
		$sql = create_update_string ( "pb_users", $set, $where );
		doQuery ( $sql );
		$_SESSION ['user_profile'] ['nicename'] = $nicename;
	}
	if ($email) {
		$set = "user_email='$email'";
		$sql = create_update_string ( "pb_users", $set, $where );
		doQuery ( $sql );
		$_SESSION ['user_profile'] ['email'] = $email;
	}
	
	header ( 'Location:' . $_SERVER ["HTTP_REFERER"] );
}

?>
