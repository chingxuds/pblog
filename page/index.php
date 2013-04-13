<?php
require_once '../action/inc/session.php';
require_once '../action/inc/db.php';

// ** 根据动作参数调用不同函数 ** //
$action = get_parameter_once ( 'action' );
if (! $action) {
	$action = 'post_view';
}
switch ($action) {
	case 'post_view' :
		post_view ();
		break;
	case 'archive_view' :
		archive_view ();
		break;
	
	default :
		break;
}
function post_view() {
	$id = get_parameter_once ( 'id' );
	echo "<script>alert($id);</script>";
	
	$tbl_name = "pb_posts";
	$select_items = "post_author,post_category,post_title,post_content,post_url,post_modified";
	$where = "WHERE post_id=$id";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $sql );
	$arr = mysqli_fetch_assoc ( $result );
	if ($arr) {
		$post ['id'] = $id;
		$post ['category'] = $arr ['post_category'];
		$post ['title'] = $arr ['post_title'];
		$post ['content'] = preg_replace ( "/&##&/", "'", $arr ['post_content'] );
		$post ['url'] = $arr ['post_url'];
		$post ['date'] = $arr ['post_modified'];
		
		$author ['id'] = $arr ['post_author'];
		$select_items = "user_displayname";
		$where = "WHERE user_id=" . $author ["id"];
		$sql = create_select_string ( $select_items, 'pb_users', $where );
		$ur = doQuery ( $sql );
		$u = mysqli_fetch_assoc ( $ur );
		$author ['name'] = $u ['user_displayname'];
		$post ['author'] = $author;
		
// 		echo "<pre>" . var_dump($post) . "</pre>";
		$_SESSION ['post_view'] = $post;
	}
	
	header ( 'Location: /pblog/page/post-view.php' );
}
function archive_view() {
	$year = get_parameter_once ( 'year' );
	$month = get_parameter_once ( 'month' );
	$month_next = $month + 1;
	
	$tbl_name = 'pb_posts';
	$select_items = "post_id,post_title";
	$where = "WHERE UNIX_TIMESTAMP(post_modified_gmt) BETWEEN UNIX_TIMESTAMP('$year-$month-01 00:00:00') AND UNIX_TIMESTAMP('$year-$month_next-01 00:00:00')";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
}
?>