<?php
require_once 'inc/db.php';
require_once 'inc/dateformat.php';
require_once 'inc/encrypt.php';
require_once 'inc/session.php';

// ** 根据动作参数调用不同函数 ** //
$action = get_parameter_once ( 'action' );
switch ($action) {
	case 'comment_submit' :
		comment_submit ();
		break;
	case 'ajax_comment_approve' :
		ajax_comment_approve ();
		break;
	
	default :
		break;
}

/**
 * 提交评论函数
 */
function comment_submit() {
	$link = creatLink ();
	$post_id = get_parameter_once ( 'pid' );
	$author_id = get_parameter_once ( 'author' );
	if (! $author_id) {
		$author_id = 0;
	}
	$author_name = get_parameter_once ( 'author_name' );
	$author_email = get_parameter_once ( 'author_email' );
	$author_ip = $_SERVER ["REMOTE_ADDR"];
	$author_agent = $_SERVER ['HTTP_USER_AGENT'];
	$content = get_parameter_once ( 'comment_content' );
	$comment_date = dateFormat ( date_timestamp_get ( date_create ( get_parameter_once ( 'comment_date' ) ) ) );
	$comment_date_gmt = dateFormat ( $_SERVER ['REQUEST_TIME'] );
	
	$tbl_name = "pb_comments";
	$set = "post_id='$post_id',comment_author='$author_name',comment_author_email='$author_email',comment_author_IP='$author_ip',comment_date='$comment_date',comment_date_gmt='$comment_date_gmt',comment_content='$content',comment_agent='$author_agent',user_id='$author_id'";
	$sql = create_insert_string ( $tbl_name, $set );
	doQuery ( $link, $sql );
	
	$tbl_name = "pb_posts";
	$select_items = "post_author,comment_count";
	$where = "WHERE post_id='$post_id'";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$ur = doQuery ( $link, $sql );
	$u = mysqli_fetch_assoc ( $ur );
	$comment_unapproved_user = $u ['post_author'];
	$comment_count = $u ['comment_count'];
	$comment_count ++;
	
	$set = "comment_count='$comment_count'";
	$sql = create_update_string ( $tbl_name, $set, $where );
	doQuery ( $sql );
	
	$tbl_name = "pb_comments";
	$select_items = "COUNT(comment_id) AS num";
	$where = "WHERE comment_approved='unapproved' AND post_id IN (SELECT post_id FROM pb_posts WHERE post_author=$comment_unapproved_user)";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$cr = doQuery ( $link, $sql );
	$c = mysqli_fetch_assoc ( $cr );
	$comment_unapproved_num = $c ['num'];
	
	$comment_unapproved = application ( "comment_unapproved" );
	$comment_unapproved [$comment_unapproved_user] = $comment_unapproved_num;
	application ( "comment_unapproved", $comment_unapproved );
	closeLink ( $link );
	header ( 'Location:' . $_SERVER ["HTTP_REFERER"] );
}

/**
 * 审核通过函数
 */
function ajax_comment_approve() {
	$link = creatLink();
	$id = get_parameter_once ( 'id' );
	
	$tbl_name = "pb_comments";
	$set = "comment_approved='approved'";
	$where = "WHERE comment_id=$id";
	$sql = create_update_string ( $tbl_name, $set, $where );
	doQuery($link, $sql);
	
	$tbl_name = "pb_comments";
	$select_items = "COUNT(comment_id) AS num";
	$where = "WHERE comment_approved='unapproved' AND post_id IN (SELECT post_id FROM pb_posts WHERE post_author=" . $_SESSION['user']['id'] . ")";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$cr = doQuery ( $link, $sql );
	$c = mysqli_fetch_assoc ( $cr );
	$comment_unapproved_num = $c ['num'];
	
	$comment_unapproved = application ( "comment_unapproved" );
	$comment_unapproved [$_SESSION['user']['id']] = $comment_unapproved_num;
	application ( "comment_unapproved", $comment_unapproved );
	
	closeLink($link);
	echo TRUE;
}
?>
