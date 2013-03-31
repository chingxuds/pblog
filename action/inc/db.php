<?php
require 'action/inc/db-config.php';

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
?>
