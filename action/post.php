<?php
require_once 'inc/db.php';
require_once 'inc/dateformat.php';
require_once 'inc/encrypt.php';
require_once 'inc/session.php';
require_once 'inc/protect.php';
require_once 'other.php';

// ** 根据动作参数调用不同函数 ** //
$action = get_parameter_once ( 'action' );
switch ($action) {
	case 'publish' :
		publish ();
		break;
	
	default :
		break;
}

/**
 * 文章发布函数
 */
function publish() {
	$link = creatLink();
	/**
	 * 获取传入数据
	 */
	$title = get_parameter_once ( 'post_title' );
	$content = get_parameter_once ( 'post_content' );
	$category = get_parameter_once ( 'post_cat' );
	$tags = get_parameter_once ( "post_tags" );
	$post_date = dateFormat ( date_timestamp_get ( date_create ( get_parameter_once ( 'post_date' ) ) ) );
	
	/**
	 * 获取关键数据
	 */
	$author = $_SESSION ['user'] ['id'];
	$post_date_gmt = dateFormat ( $_SERVER ['REQUEST_TIME'] );
	
	$name = code_short ( $title, 'po' );
	
	$excerpt = substr ( strip_tags ( $content ), 0, 300 );
	$excerpt = substr ( $excerpt, 0, strlen ( $excerpt ) - 1 );
	$excerpt .= '&hellip;';
	
	$content = preg_replace ( "/'/", "&##&", $content );
	// echo preg_replace ( "/&##&/", "'",$content );
	$excerpt = preg_replace ( "/'/", "&##&", $excerpt );
	
	$modified_date = $post_date;
	$modified_date_gmt = $post_date_gmt;
	$status = 0;
	
	$tbl_name_post = 'pb_posts';
	$tbl_name_term = 'pb_terms';
	$set = "post_author='$author',post_category='$category',post_date='$post_date',post_date_gmt='$post_date_gmt',post_content='$content',post_title='$title',post_excerpt='$excerpt',post_name='$name',post_modified='$modified_date',post_modified_gmt='$modified_date_gmt',post_type='post',post_status='$status',comment_status='$status'";
	$sql = create_insert_string ( $tbl_name_post, $set );
	if (! doQuery ( $link, $sql )) {
		echo "插入失败";
	}
	
	$select_items = "post_id";
	$where = "WHERE post_author='$author' AND post_date_gmt='$post_date_gmt'";
	$sql = create_select_string ( $select_items, $tbl_name_post, $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	$post_id = $arr ['post_id'];
	
	$url = "/pblog/page/?id=$post_id";
	$set = "post_url='$url'";
	$where = "WHERE post_id='$post_id'";
	$sql = create_update_string ( $tbl_name_post, $set, $where );
	doQuery ( $link, $sql );
	
	$select_items = 'count';
	$where = "WHERE term_id='$category'";
	$sql = create_select_string ( $select_items, $tbl_name_term, $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	$cat_count = $arr ['count'];
	$cat_count ++;
	$set = "count='$cat_count'";
	$sql = create_update_string ( $tbl_name_term, $set, $where );
	doQuery ( $link, $sql );
	
// 	meta_update('post', $post_id, "category", $category);
	
	update_cats_in_app();
	update_posts_archives();
	update_posts_latest_in_app();
	closeLink($link);
	header ( 'Location: /pblog/page/?id='.$post_id );
}

?>