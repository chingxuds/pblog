<?php
require_once 'inc/db.php';
require_once 'inc/session.php';
require_once 'inc/paginate.php';

// ** 根据动作参数调用不同函数 ** //
$action = get_parameter_once ( 'action' );
switch ($action) {
	case 'post' :
		search_posts ();
		break;
	case 'author' :
		author_view ();
		break;
	case 'archive_view_date' :
		archive_view_date ();
		break;
	case 'category_view' :
		category_view ();
		break;
	
	default :
		break;
}

/**
 * 文章搜索函数
 */
function search_posts() {
	$link = createLink ();
	$key = get_parameter_once ( 'key' );
	$cur_page = get_parameter_once ( 'page' );
	$target_page = "/pblog/action/search.php";
	$target_action = "action=post";
	
	if (! $cur_page) {
		$cur_page = 1;
	}
	
	$w = "WHERE";
	if ($key) {
		$w = $w." post_title LIKE '%$key%' AND";
	}
	$where = $w . " post_status='0' ORDER BY post_modified_gmt DESC";
	$select_items = "post_id,post_title,DATE_FORMAT(post_modified_gmt,'%Y年%m月%d日') AS date,post_url";
	$tbl_name = 'pb_posts';
	$limit = 10;
// 	$adjacents = 4;
	$total_pages = get_total_pages ( $link, $tbl_name, $where );
	$result = get_querry_result ( $link, $tbl_name, $select_items, $where, $cur_page );
	$pages_str = get_pages_string ( $target_page, $target_action, $total_pages, $cur_page );
	
	$arr = mysqli_fetch_assoc ( $result );
	$i = 1;
	while ( $arr ) {
		$post ['id'] = $arr ['post_id'];
		$post ['title'] = $arr ['post_title'];
		$post ['date'] = $arr ['date'];
		$post ['url'] = $arr ['post_url'];
		
		$posts [$i ++] = $post;
		$arr = mysqli_fetch_assoc ( $result );
	}
	
	$info = "共找到 $total_pages 项结果，以下是第 " . (($cur_page - 1) * $limit + 1) . " - " . (($cur_page - 1) * $limit + ($i - 1)) . " 项";
	
	$_SESSION ['search_info'] = $info;
	$_SESSION ['search_list'] = $posts;
	$_SESSION ['search_pages_str'] = $pages_str;
	closeLink ( $link );
	header ( "Location: /pblog/search-list.php" );
}

/**
 * 按作者查询文章函数
 */
function author_view() {
	$link = createLink ();
	$author = get_parameter_once('author');
	$cur_page = get_parameter_once ( 'page' );
	$target_page = "/pblog/action/search.php";
	$target_action = "action=author&author=$author";
	
	if (! $cur_page) {
		$cur_page = 1;
	}
	
	$w = "WHERE";
	if ($author) {
		$w = $w." post_author=$author AND";
	}
	$where = $w . " post_status='0' ORDER BY post_modified_gmt DESC";
	$select_items = "post_id,post_title,DATE_FORMAT(post_modified_gmt,'%Y年%m月%d日') AS date,post_url";
	$tbl_name = 'pb_posts';
	$limit = 10;
// 	$adjacents = 4;
	$total_pages = get_total_pages ( $link, $tbl_name, $where );
	$result = get_querry_result ( $link, $tbl_name, $select_items, $where, $cur_page );
	$pages_str = get_pages_string ( $target_page, $target_action, $total_pages, $cur_page );
	
	$arr = mysqli_fetch_assoc ( $result );
	$i = 1;
	while ( $arr ) {
		$post ['id'] = $arr ['post_id'];
		$post ['title'] = $arr ['post_title'];
		$post ['date'] = $arr ['date'];
		$post ['url'] = $arr ['post_url'];
		
		$posts [$i ++] = $post;
		$arr = mysqli_fetch_assoc ( $result );
	}
	
	$info = "共找到 $total_pages 项结果，以下是第 " . (($cur_page - 1) * $limit + 1) . " - " . (($cur_page - 1) * $limit + ($i - 1)) . " 项";
	
	$_SESSION ['search_info'] = $info;
	$_SESSION ['search_list'] = $posts;
	$_SESSION ['search_pages_str'] = $pages_str;
	closeLink ( $link );
	header ( "Location: /pblog/search-list.php" );
}

/**
 * 按时间查询归档函数
 */
function archive_view_date() {
	$link = createLink ();
	$year = get_parameter_once ( 'year' );
	$month = get_parameter_once ( 'month' );
	$year_next = ($month + 1) > 12 ? ($year + 1) : $year;
	$month_next = ($month + 1) > 12 ? 01 : ($month + 1);
	$cur_page = get_parameter_once ( 'page' );
	if (! $cur_page) {
		$cur_page = 1;
	}
	
	$tbl_name = 'pb_posts';
	$target_page = "/pblog/action/search.php";
	$target_action = "action=archive_view_date&year=$year&month=$month";
	$limit =10;
	
	$select_items = "post_id,post_title,DATE_FORMAT(post_modified_gmt,'%Y年%m月%d日') AS date,post_url";
	$where = "WHERE post_type='post' AND post_status=0 AND post_modified_gmt BETWEEN '$year-$month-01 00:00:00' AND '$year_next-$month_next-01 00:00:00' ORDER BY post_id DESC";
	
	$total_pages = get_total_pages ( $link, $tbl_name, $where );
	$result = get_querry_result ( $link, $tbl_name, $select_items, $where, $cur_page );
	$pages_str = get_pages_string ( $target_page, $target_action, $total_pages, $cur_page );
	
	$arr = mysqli_fetch_assoc ( $result );
	$i = 1;
	while ( $arr ) {
		// echo "<p><pre>" . var_dump ( $arr ) . "</pre></p>";
		$post ['id'] = $arr ['post_id'];
		$post ['title'] = $arr ['post_title'];
		$post ['date'] = $arr ['date'];
		$post ['url'] = $arr ['post_url'];
		
		$posts [$i ++] = $post;
		$arr = mysqli_fetch_assoc ( $result );
	}
	
	$info = "共找到 $total_pages 项结果，以下是第 " . (($cur_page - 1) * $limit + 1) . " - " . (($cur_page - 1) * $limit + ($i - 1)) . " 项";
	
	$_SESSION ['search_info'] = $info;
	$_SESSION ['search_list'] = $posts;
	$_SESSION ['search_pages_str'] = $pages_str;
	closeLink ( $link );
	header ( "Location: /pblog/search-list.php" );
}

/**
 * 按类别查询文章函数
 */
function category_view() {
	$link = createLink();
	$category = get_parameter_once ( 'cat' );
	$cur_page = get_parameter_once ( 'page' );
	if (! $cur_page) {
		$cur_page = 1;
	}
	
	$tbl_name = 'pb_posts';
	$target_page = "/pblog/action/search.php";
	$target_action = "action=category_view&cat=$category";
	$limit =10;
	
	$select_items = "post_id,post_title,DATE_FORMAT(post_modified_gmt,'%Y年%m月%d日') AS date,post_url";
	$where = "WHERE post_type='post' AND post_status=0 AND post_category='$category'";
	
	$total_pages = get_total_pages ( $link, $tbl_name, $where );
	$result = get_querry_result ( $link, $tbl_name, $select_items, $where, $cur_page );
	$pages_str = get_pages_string ( $target_page, $target_action, $total_pages, $cur_page );
	
	$arr = mysqli_fetch_assoc ( $result );
	$i = 1;
	while ( $arr ) {
			// echo "<p><pre>" . var_dump ( $obj ) . "</pre></p>";
			$post ['id'] = $arr['post_id'];
			$post ['title'] = $arr ['post_title'];
			$post ['date'] = $arr ['date'];
			$post ['url'] = $arr ['post_url'];
			
			$posts [$i ++] = $post;
		
		$arr = mysqli_fetch_assoc ( $result );
	}
	
	$info = "共找到 $total_pages 项结果，以下是第 " . (($cur_page - 1) * $limit + 1) . " - " . (($cur_page - 1) * $limit + ($i - 1)) . " 项";
	
	$_SESSION ['search_info'] = $info;
	$_SESSION ['search_list'] = $posts;
	$_SESSION ['search_pages_str'] = $pages_str;
	
	// echo "<p><pre>" . var_dump ( $posts ) . "</pre></p>";
	closeLink($link);
	header ( "Location: /pblog/search-list.php" );
}
?>