<?php
require_once 'inc/encrypt.php';
require_once 'inc/dateformat.php';
require_once 'inc/db.php';
require_once 'inc/paginate.php';
require_once 'inc/session.php';
require_once 'other.php';
// require_once 'inc/protect.php';

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
	case 'ajax_login' :
		ajax_login ();
		break;
	case 'ajax_check_username' :
		ajax_check_username ();
		break;
	case 'check_all_users' :
		check_all_users ();
		break;
	case 'ajax_update_status' :
		ajax_update_status ();
		break;
	
	default :
		break;
}

/**
 * 登录函数
 */
function login() {
	$link = createLink ();
	// ** 获取前台传入数据 ** //
	$username = get_parameter_once ( 'username_input' );
	$userpass = code_md5 ( get_parameter_once ( 'userpass_input' ) );
	
	// ** 查询数据库验证信息 ** //
	$select_items = "user_id,user_displayname,user_email,user_status";
	$where = "WHERE user_pass='$userpass' AND user_login='$username'";
	$sql = create_select_string ( $select_items, "pb_users", $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	if ($arr) {
		$_SESSION ["isLogin"] = TRUE;
		$user ["id"] = $arr ["user_id"];
		$user ["email"] = $arr ["user_email"];
		$user ["displayname"] = $arr ["user_displayname"];
		$user ["status"] = $arr ["user_status"];
		$_SESSION ["user"] = $user;
	}
	closeLink ( $link );
	header ( 'Location:' . $_SERVER ["HTTP_REFERER"] );
}

/**
 * 登出函数
 */
function logout() {
	$link = createLink ();
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
	$link = createLink ();
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
	$set = "user_login='$username',user_pass='$userpass',user_nicename='$nicename',user_displayname='$displayname',user_email='$useremail',user_registered='$register_time',user_registered_gmt='$register_time_gmt',user_status='$status'";
	$sql = create_insert_string ( "pb_users", $set );
	doQuery ( $link, $sql );
	
	$select_items = "user_id,user_displayname,user_email,user_status";
	$where = "WHERE user_pass='$userpass' AND user_login='$username'";
	$sql = create_select_string ( $select_items, "pb_users", $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	if ($arr) {
		$_SESSION ["isLogin"] = TRUE;
		$user ["id"] = $arr ["user_id"];
		$user ["email"] = $arr ["user_email"];
		$user ["displayname"] = $arr ["user_displayname"];
		$user ["status"] = $arr ["user_status"];
		$_SESSION ["user"] = $user;
	}
	closeLink ( $link );
	header ( 'Location:' . $_SERVER ["HTTP_REFERER"] );
}

/**
 * 个人资料更新函数
 */
function profile_update() {
	$link = createLink ();
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
		doQuery ( $link, $sql );
		$_SESSION ['user'] ['displayname'] = $displayname;
	}
	if ($nicename) {
		$set = "user_nicename='$nicename'";
		$sql = create_update_string ( "pb_users", $set, $where );
		doQuery ( $link, $sql );
		$_SESSION ['user_profile'] ['nicename'] = $nicename;
	}
	if ($email) {
		$set = "user_email='$email'";
		$sql = create_update_string ( "pb_users", $set, $where );
		doQuery ( $link, $sql );
		$_SESSION ['user_profile'] ['email'] = $email;
	}
	closeLink ( $link );
	header ( 'Location:' . $_SERVER ["HTTP_REFERER"] );
}

/**
 * Ajax登录检查
 */
function ajax_login() {
	$link = createLink ();
	// ** 获取前台传入数据 ** //
	$username = get_parameter_once ( 'username' );
	$userpass = code_md5 ( get_parameter_once ( 'userpass' ) );
	
	// ** 查询数据库验证信息 ** //
	$select_items = "user_id";
	$where = "WHERE user_pass='$userpass' AND user_login='$username'";
	$sql = create_select_string ( $select_items, "pb_users", $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	if ($arr) {
		echo TRUE;
	} else {
		echo FALSE;
	}
	closeLink ( $link );
}

/**
 * Ajax检查用户名
 */
function ajax_check_username() {
	$link = createLink ();
	// ** 获取前台传入数据 ** //
	$username = get_parameter_once ( 'username' );
	
	// ** 查询数据库验证信息 ** //
	$select_items = "user_id";
	$where = "WHERE user_login='$username'";
	$sql = create_select_string ( $select_items, "pb_users", $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	if ($arr) {
		echo TRUE;
	} else {
		echo FALSE;
	}
	closeLink ( $link );
}

/**
 * 查看所用用户
 */
function check_all_users() {
	$link = createLink ();
	
	$cur_page = get_parameter_once ( 'page' );
	if (! $cur_page) {
		$cur_page = 1;
	}
	$limit = 5;
	
	if ($_SESSION ['user'] ['status'] != 0) {
		header ( "Location: /pblog/" );
	} else {
		$tbl_name = 'pb_users';
		$select_items = "user_id,user_login,user_nicename,user_email,user_registered,user_status";
		$where = '';
		
		$target_page = "/pblog/action/user.php";
		$target_action = "action=check_all_users";
		
		$total_pages = get_total_pages ( $link, $tbl_name, $where );
		$page_str = get_pages_string ( $target_page, $target_action, $total_pages, $cur_page, $limit );
		
		$result = get_querry_result ( $link, $tbl_name, $select_items, $where, $cur_page, $limit );
		$arr = mysqli_fetch_assoc ( $result );
		while ( $arr ) {
			$user ['id'] = $arr ['user_id'];
			$user ['name'] = $arr ['user_login'];
			$user ['nicename'] = $arr ['user_nicename'];
			$user ['email'] = $arr ['user_email'];
			$user ['time'] = $arr ['user_registered'];
			$user ['status'] = $arr ['user_status'];
			
			$users [$user ['id']] = $user;
			$arr = mysqli_fetch_assoc ( $result );
		}
		
		$_SESSION ['users_list'] = $users;
		$_SESSION ['all_users_pagestr'] = $page_str;
		closeLink ( $link );
		header ( "Location: /pblog/manage/users-list.php" );
	}
}

/**
 * Ajax更新用户级别函数
 */
function ajax_update_status() {
	$link = createLink ();
	
	$uid = get_parameter_once ( 'uid' );
	$status = get_parameter_once ( 'status' );
	
	$tbl_name = "pb_users";
	$set = "user_status=$status";
	$where = "WHERE user_id=$uid";
	$sql = create_update_string ( $tbl_name, $set, $where );
	
	$result = doQuery ( $link, $sql );
	
	if ($result) {
		closeLink ( $link );
		echo TRUE;
	} else {
		closeLink ( $link );
		echo FALSE;
	}
}
?>
