<?php
// ** 若会话未开启，则开启之 ** //
if (session_status () == PHP_SESSION_NONE) {
	session_start ();
}

/**
 * 传入数据获取函数
 *
 * @param string $name
 *        	变量名
 * @return Ambigous <unknown, boolean> 返回值
 */
function get_parameter_once($name) {
	return isset ( $_POST [$name] ) ? $_POST [$name] : (isset ( $_GET [$name] ) ? $_GET [$name] : FALSE);
}

/**
 * 模拟全局会话函数
 *
 * @param string $key
 *        	键名
 * @param string $value
 *        	键值
 * @return boolean string
 */
function application($key = FALSE, $value = FALSE) {
	if (! $key) {
		return FALSE;
	}
	
	$ssid = session_id (); // 保存当前session_id
	session_write_close (); // 结束当前session
	ob_start (); // 禁止全局session发送header
	
	session_id ( "application" ); // 注册全局session_id
	session_start (); // 开启全局session
	if ($value) 	// 如果有第二个参数，那么表示写入全局session
	{
// 		echo '<script>alert("' . var_dump ( $value ) . '")</script>';
		$re = ($_SESSION [$key] = $value);
	} else 	// 如果只有一个参数，那么返回该参数对应的value
	{
// 		echo '<script>alert("取值")</script>';
		if (isset ( $_SESSION [$key] )) {
			$re = $_SESSION [$key];
		} else {
			$re = FALSE;
		}
	}
	session_write_close (); // 结束全局session
	
	session_id ( $ssid ); // 重新注册上面被中断的非全局session
	session_start (); // 重新开启
	ob_end_clean (); // 抛弃刚刚由于session_start产生的一些header输出
	
	return $re;
}

/**
 * 更新全局变量中的类别
 */
function update_cats_in_app($link) {
	$tbl_name = "pb_terms";
	$select_items = "term_id,term_name,term_slug,parent,count";
	$where = "WHERE taxonomy = 'category'";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	while ( $arr ) {
		$at ['id'] = $arr ['term_id'];
		$at ['name'] = $arr ['term_name'];
		$at ['slug'] = $arr ['term_slug'];
		$at ['parent'] = $arr ['parent'];
		$at ['count'] = $arr ['count'];
		
		$app_arr [$at ['parent']] ['child'] [$at ['id']] = $at ['id'];
		$app_arr [$at ['id']] = $at;
		$arr = mysqli_fetch_assoc ( $result );
	}
	
	application ( 'categories', $app_arr );
}

/**
 * 更新全局变量中的最新文章
 */
function update_posts_latest_in_app($link) {
	$tbl_name = "pb_posts";
	$select_items = "post_id,post_author,post_category,post_title,post_excerpt,post_url,DATE_FORMAT(post_modified,'%Y年%m月%d日 %H:%i') AS date,comment_count";
	$where = "WHERE post_type='post' AND post_status = '0' ORDER BY post_modified_gmt DESC LIMIT 0, 10";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $link, $sql );
	
	$arr = mysqli_fetch_assoc ( $result );
	$anonymous ['id'] = 0;
	$anonymous ['name'] = '匿名';
	$aa [0] = $anonymous;
	$i = 1;
	while ( $arr ) {
		$at ['id'] = $arr ['post_id'];
		$at ['category'] = $arr ['post_category'];
		$at ['title'] = $arr ['post_title'];
		$at ['excerpt'] = preg_replace ( "/&##&/", "'", $arr ['post_excerpt'] );
		$at ['url'] = $arr ['post_url'];
		$at ['date'] = $arr ['date'];
		$at ['comment_num'] = $arr ['comment_count'];
		
		if (! isset ( $aa [$arr ['post_author']] )) {
			$author ['id'] = $arr ['post_author'];
			$select_items = "user_displayname";
			$where = "WHERE user_id=" . $author ["id"];
			$sql = create_select_string ( $select_items, 'pb_users', $where );
			$ur = doQuery ( $link, $sql );
			$u = mysqli_fetch_assoc ( $ur );
			$author ['name'] = $u ['user_displayname'];
			$at ['author'] = $author;
			$aa [$arr ['post_author']] = $author;
		} else {
			$at ['author'] = $aa [$arr ['post_author']];
		}
		
		$app_arr [$i ++] = $at;
		$arr = mysqli_fetch_assoc ( $result );
	}
	
	application ( 'posts_latest', $app_arr );
}

/**
 * 更新按日期归档文章数函数
 */
function update_posts_archives($link) {
	$sql = "SELECT DATE_FORMAT(post_modified_gmt,'%Y年%m月') AS date,DATE_FORMAT(post_modified_gmt,'%Y') AS year,DATE_FORMAT(post_modified_gmt,'%m') AS month, COUNT(*) AS number FROM pb_posts WHERE post_type='post' GROUP BY DATE_FORMAT(post_modified_gmt,'%Y年%m月') ORDER BY post_id DESC";
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	
	$i = 1;
	while ( $arr ) {
		$archive ['date'] = $arr ['date'];
		$archive ['year'] = $arr ['year'];
		$archive ['month'] = $arr ['month'];
		$archive ['count'] = $arr ['number'];
		
		$archives [$i ++] = $archive;
		$arr = mysqli_fetch_assoc ( $result );
	}
	
	application ( 'archives', $archives );
}
?>