<?php
// ** MySQL 配置 ** //
/**
 * PBlog 数据库的名称
 */
define ( 'DB_NAME', 'pblog' );

/**
 * MySQL 数据库用户名
 */
define ( 'DB_USER', 'root' );

/**
 * MySQL 数据库密码
 */
define ( 'DB_PASSWORD', 'root' );

/**
 * MySQL 主机
 */
define ( 'DB_HOST', 'localhost' );

/**
 * 创建数据表时默认的文字编码
 */
define ( 'DB_CHARSET', 'utf8' );

// ** MySQL 连接 ** //
/**
 * 创建连接函数,成功则返回变量连接标识符$link,失败则打印信息并退出
 *
 * @return object 连接标识符
 */
function creatLink() {
	$link = mysqli_connect ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	if (mysqli_connect_errno ()) {
		printf ( "Connect failed: %s\n", mysqli_connect_error () );
		exit ();
	}
	return $link;
}

/**
 * 关闭连接函数
 *
 * @param object $link
 *        	连接标识符
 */
function closeLink($link) {
	if ($link) {
		mysqli_close ( $link );
	} else {
		echo "连接不存在或已关闭";
	}
}

/**
 * 发送SQL语句函数,成功则返回结果集$result,失败则返回FALSE
 *
 * @param object $link
 *        	连接标识符
 * @param string $sql
 *        	SQL语句
 * @return Ambigous <boolean, object> 成功返回result对象或TRUE，失败返回FALSE
 */
function doQuery($link, $sql) {
	if ($sql != '') {
		mysqli_set_charset ( $link, 'utf8' );
		$result = mysqli_query ( $link, $sql ) or die ( $sql . '<br>' . mysqli_error ( $link ) );
		return $result;
	} else {
		return FALSE;
	}
}

/**
 * SQL选择语句生成函数
 *
 * @param string $select_items
 *        	查询条目
 * @param string $tbl_name
 *        	查询表名
 * @param string $where
 *        	查询条件
 * @return string SQL选择语句
 */
function create_select_string($select_items, $tbl_name, $where = "") {
	return "SELECT " . $select_items . " FROM " . $tbl_name . " " . $where;
}

/**
 * SQL插入语句生成函数
 *
 * @param string $tbl_name
 *        	插入表名
 * @param string $set
 *        	插入数据
 * @return string SQL插入语句
 */
function create_insert_string($tbl_name, $set) {
	return "INSERT " . $tbl_name . " SET " . $set;
}

/**
 * SQL更新语句生成函数
 *
 * @param string $tbl_name
 *        	更新表名
 * @param string $set
 *        	更新数据
 * @param string $where
 *        	更新条件
 * @return string SQL更新语句
 */
function create_update_string($tbl_name, $set, $where = "") {
	return "UPDATE " . $tbl_name . " SET " . $set . " " . $where;
}

/**
 * 父类个数查询函数
 *
 * @param string $tbl_name
 *        	查询表的表名
 * @param string $col_name
 *        	查询列的列名
 * @param string $id_name
 *        	父类id的列名
 * @param int $parent_id
 *        	父类id的值
 * @return number 父类个数
 */
function find_parent_count($tbl_name, $col_name, $id_name, $parent_id) {
	if ($parent_id == 0) {
		return 0;
	} else {
		$where = "WHERE $id_name='$parent_id'";
		$sql = create_select_string ( $col_name, $tbl_name, $where );
		$arr = mysqli_fetch_assoc ( doQuery ( $link, $sql ) );
		
		return find_parent_count ( $tbl_name, $col_name, $id_name, $arr [$col_name] ) + 1;
	}
}
?>
