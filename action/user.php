<?php
require_once 'inc/encrypt.php';
require_once 'inc/dateformat.php';
require_once 'inc/db.php';
require_once 'inc/session.php';
require_once 'other.php';
require_once 'inc/protect.php';

// ** 根据动作参数调用不同函数 ** //
$action = get_parameter_once ( 'action' );
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
	$username = get_parameter_once ( 'username_input' );
	$userpass = code_md5 ( get_parameter_once ( 'userpass_input' ) );
	
	// ** 查询数据库验证信息 ** //
	$select_items = "user_id,user_displayname,user_status";
	$where = "WHERE user_pass='$userpass' AND user_login='$username'";
	$sql = create_select_string ( $select_items, "pb_users", $where );
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
	$username = get_parameter_once ( 'username_input' );
	$userpass = code_md5 ( get_parameter_once ( 'userpass_input' ) );
	$nicename = get_parameter_once ( 'nicename_input' );
	$displayname = $nicename;
	$useremail = get_parameter_once ( 'useremail_input' );
	$register_time = dateFormat ( date_timestamp_get ( date_create ( get_parameter_once ( 'register_time' ) ) ) );
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
	
	$lastname = get_parameter_once ( 'lastname' );
	$firstname = get_parameter_once ( 'firstname' );
	$nicename = get_parameter_once ( 'nicename' );
	$displayname = get_parameter_once ( 'displayname' );
	$email = get_parameter_once ( 'email' );
	$tel = get_parameter_once ( 'tel' );
	
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
	
	$where = "WHERE user_id='$object_id'";
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
