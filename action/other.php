<?php

/**
 * 通用元信息更新函数
 *
 * @param string $object_type
 *        	对象类型
 * @param int $object_id
 *        	对象ID
 * @param string $meta_key
 *        	元信息键名
 * @param string $meta_value
 *        	元信息键值
 */
function meta_update($object_type, $object_id, $meta_key, $meta_value) {
	$link = creatLink();
	$tbl_name = "pb_meta";
	$select_items = "meta_id";
	$where = "WHERE object_type='$object_type' AND object_id='$object_id' AND meta_key='$meta_key'";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	$meta_id = $arr ['meta_id'];
	if (! $meta_id) {
		$set = "object_type='$object_type',object_id='$object_id',meta_key='$meta_key',meta_value='$meta_value'";
		$sql = create_insert_string ( $tbl_name, $set );
		doQuery ( $link, $sql );
	} else {
		$set = "meta_value='$meta_value'";
		$where = "WHERE meta_id='$meta_id'";
		$sql = create_update_string ( $tbl_name, $set, $where );
		doQuery ( $link, $sql );
	}
	closeLink($link);
}


?>
