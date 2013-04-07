<?php
require '../action/inc/db.php';
require '../action/inc/session.php';
require '../action/dometa.php';

// ** 根据动作参数调用不同函数 ** //
$action = isset ( $_POST ['action'] ) ? $_POST ['action'] : (isset ( $_GET ['action'] ) ? $_GET ['action'] : NULL);
switch ($action) {
	case 'profile_view' :
		profile_view ();
		break;
	
	default :
		break;
}

/**
 * 查看个人资料函数
 */
function profile_view() {
	$object_id = $_SESSION ['user'] ['id'];
	
	$select_items = "meta_key,meta_value";
	$where = "object_type='user' AND object_id='$object_id'";
	$sql = create_select_string ( $select_items, "pb_meta", $where );
	$result = doQuery ( $sql );
	
	if ($result) {
		$arr = mysqli_fetch_assoc ( $result );
		while ( $arr ) {
			$user_profile [$arr ['meta_key']] = $arr ['meta_value'];
			$arr = mysqli_fetch_assoc ( $result );
		}
	}
	
	$select_items = "user_nicename,user_email";
	$where = "user_id='$object_id'";
	$sql = create_select_string ( $select_items, "pb_users", $where );
	// echo $sql . '<br>';
	$result = doQuery ( $sql );
	
	if ($result) {
		$arr = mysqli_fetch_assoc ( $result );
		$user_profile ['nicename'] = $arr ['user_nicename'];
		$user_profile ['email'] = $arr ['user_email'];
	}
	
	$_SESSION ['user_profile'] = $user_profile;
	header ( 'Location:./profile.php' );
}
?>
