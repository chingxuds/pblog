<?php
require_once 'inc/db.php';
require_once 'inc/dateformat.php';
require_once 'inc/encrypt.php';
require_once 'inc/paginate.php';
require_once 'inc/session.php';
require_once 'inc/protect.php';
require_once 'other.php';

// ** 根据动作参数调用不同函数 ** //
$action = get_parameter_once ( 'action' );
switch ($action) {
	case 'publish' :
		publish ();
		break;
	case 'update' :
		update ();
		break;
	case 'self_posts_overview' :
		self_posts_overview ();
		break;
	case 'all_posts_overview' :
		all_posts_overview ();
		break;
	case 'edit_post' :
		edit_post ();
		break;
	case 'disable_post' :
		disable_post ();
		break;
	
	default :
		break;
}

/**
 * 文章发布函数
 */
function publish() {
	$link = createLink ();
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
	
	update_cats_in_app ( $link );
	update_posts_archives ( $link );
	update_posts_latest_in_app ( $link );
	closeLink ( $link );
	header ( 'Location: /pblog/page/?id=' . $post_id );
}

/**
 * 文章更新函数
 */
function update() {
	$link = createLink ();
	/**
	 * 获取传入数据
	 */
	$id = get_parameter_once ( 'post_id' );
	$title = get_parameter_once ( 'post_title' );
	$content = get_parameter_once ( 'post_content' );
	$category = get_parameter_once ( 'post_cat' );
	$modified_date = dateFormat ( date_timestamp_get ( date_create ( get_parameter_once ( 'post_date' ) ) ) );
	
	/**
	 * 获取关键数据
	 */
	$modified_date_gmt = dateFormat ( $_SERVER ['REQUEST_TIME'] );
	
	$excerpt = substr ( strip_tags ( $content ), 0, 300 );
	$excerpt = substr ( $excerpt, 0, strlen ( $excerpt ) - 1 );
	$excerpt .= '&hellip;';
	
	$content = preg_replace ( "/'/", "&##&", $content );
	// echo preg_replace ( "/&##&/", "'",$content );
	$excerpt = preg_replace ( "/'/", "&##&", $excerpt );
	
	$tbl_name_post = 'pb_posts';
	$set = "post_category='$category',post_content='$content',post_title='$title',post_excerpt='$excerpt',post_modified='$modified_date',post_modified_gmt='$modified_date_gmt',post_type='post'";
	$where = "WHERE post_id=$id";
	$sql = create_update_string ( $tbl_name_post, $set, $where );
	if (! doQuery ( $link, $sql )) {
		echo "更新失败";
	}
	
	update_posts_latest_in_app ( $link );
	closeLink ( $link );
	header ( 'Location: /pblog/page/?id=' . $id );
}

/**
 * 查看自己文章函数
 */
function self_posts_overview() {
	$link = createLink ();
	
	$id = $_SESSION ['user'] ['id'];
	$cur_page = get_parameter_once ( 'page' );
	if (! $cur_page) {
		$cur_page = 1;
	}
	$limit = 5;
	
	$tbl_name = "pb_posts";
	$select_items = "post_id,post_title,DATE_FORMAT(post_modified,'%Y年%m月%d日 %H:%i') AS date,post_excerpt,post_url,post_category";
	$where = "WHERE post_type='post' AND post_status=0 AND post_author=$id ORDER BY post_modified_gmt DESC";
	
	$target_page = "/pblog/action/post.php";
	$target_action = "action=self_post_overview";
	$total_pages = get_total_pages ( $link, $tbl_name, $where );
	$page_str = get_pages_string ( $target_page, $target_action, $total_pages, $cur_page, $limit );
	
	$result = get_querry_result ( $link, $tbl_name, $select_items, $where, $cur_page, $limit );
	$arr = mysqli_fetch_assoc ( $result );
	if ($arr) {
		while ( $arr ) {
			$post ['id'] = $arr ['post_id'];
			$post ['title'] = $arr ['post_title'];
			$post ['date'] = $arr ['date'];
			$post ['excerpt'] = preg_replace ( "/&##&/", "'", $arr ['post_excerpt'] );
			$post ['url'] = $arr ['post_url'];
			$post ['category'] = $arr ['post_category'];
			
			$posts [$post ['id']] = $post;
			$arr = mysqli_fetch_assoc ( $result );
		}
		$_SESSION ['self_posts_overview'] = $posts;
		$_SESSION ['self_posts_pagestr'] = $page_str;
	} else {
		$_SESSION ['all_posts_overview'] = FALSE;
		$_SESSION ['all_posts_pagestr'] = '';
	}
	
	closeLink ( $link );
	header ( "Location: /pblog/manage/post-overview.php" );
}

/**
 * 查看所有用户文章函数
 */
function all_posts_overview() {
	$link = createLink ();
	
	$cur_page = get_parameter_once ( 'page' );
	if (! $cur_page) {
		$cur_page = 1;
	}
	$limit = 5;
	
	$tbl_name = "pb_posts";
	$select_items = "post_id,post_author,post_title,DATE_FORMAT(post_modified,'%Y年%m月%d日 %H:%i') AS date,post_excerpt,post_url,post_category";
	$where = "WHERE post_type='post' AND post_status=0 ORDER BY post_modified_gmt DESC";
	
	$target_page = "/pblog/action/post.php";
	$target_action = "action=all_posts_overview";
	$total_pages = get_total_pages ( $link, $tbl_name, $where );
	$page_str = get_pages_string ( $target_page, $target_action, $total_pages, $cur_page, $limit );
	
	$result = get_querry_result ( $link, $tbl_name, $select_items, $where, $cur_page, $limit );
	$arr = mysqli_fetch_assoc ( $result );
	$anonymous ['id'] = 0;
	$anonymous ['name'] = '匿名';
	$author [0] = $anonymous;
	if ($arr) {
		while ( $arr ) {
			$post ['id'] = $arr ['post_id'];
			$post ['title'] = $arr ['post_title'];
			$post ['date'] = $arr ['date'];
			$post ['excerpt'] = preg_replace ( "/&##&/", "'", $arr ['post_excerpt'] );
			$post ['url'] = $arr ['post_url'];
			$post ['category'] = $arr ['post_category'];
			
			if (! isset ( $author [$arr ['post_author']] )) {
				$a ['id'] = $arr ['post_author'];
				$select_items = "user_displayname";
				$where = "WHERE user_id=" . $a ["id"];
				$sql = create_select_string ( $select_items, 'pb_users', $where );
				$ur = doQuery ( $link, $sql );
				$u = mysqli_fetch_assoc ( $ur );
				$a ['name'] = $u ['user_displayname'];
				$post ['author'] = $a;
				$author [$arr ['post_author']] = $a;
			} else {
				$post ['author'] = $author [$arr ['post_author']];
			}
			
			$posts [$post ['id']] = $post;
			$arr = mysqli_fetch_assoc ( $result );
		}
		$_SESSION ['all_posts_overview'] = $posts;
		$_SESSION ['all_posts_pagestr'] = $page_str;
	} else {
		$_SESSION ['all_posts_overview'] = FALSE;
		$_SESSION ['all_posts_pagestr'] = '';
	}
	
	closeLink ( $link );
	header ( "Location: /pblog/manage/all-posts-overview.php" );
}

/**
 * 编辑文章函数
 */
function edit_post() {
	$link = createLink ();
	$id = get_parameter_once ( 'id' );
	
	$tbl_name = "pb_posts";
	$select_items = "post_id,post_title,post_content,post_category";
	$where = "WHERE post_id=$id";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	
	$post ['id'] = $arr ['post_id'];
	$post ['title'] = $arr ['post_title'];
	$post ['content'] = preg_replace ( "/&##&/", "'", $arr ['post_content'] );
	$post ['category'] = $arr ['post_category'];
	
	$_SESSION ['edit_post'] = $post;
	closeLink ( $link );
	header ( "Location: /pblog/manage/post-edit.php" );
}

/**
 * 关闭文章（删除文章）函数
 */
function disable_post() {
	$link = createLink ();
	$id = get_parameter_once ( 'id' );
	
	$tbl_name = "pb_posts";
	$set = "post_status=1";
	$where = "WHERE post_id=$id";
	$sql = create_update_string ( $tbl_name, $set, $where );
	doQuery ( $link, $sql );
	
	self_posts_overview ();
	
	closeLink ( $link );
}
?>
