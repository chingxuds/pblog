<?php
require 'db-config.php';

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
 * @param $link 连接标识符        	
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
 * @param string $sql
 *        	SQL语句
 * @return Ambigous <boolean, object> 成功返回result对象或TRUE，失败返回FALSE
 */
function doQuery($sql) {
	if ($sql != '') {
		$link = creatLink ();
		mysqli_set_charset ( $link, 'utf8' );
		$result = mysqli_query ( $link, $sql );
		closeLink ( $link );
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
function create_select_string($select_items, $tbl_name, $where) {
	return "SELECT " . $select_items . " FROM " . $tbl_name . " WHERE " . $where;
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
function create_update_string($tbl_name, $set, $where) {
	return "UPDATE " . $tbl_name . " SET " . $set . " WHERE " . $where;
}
?>
