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
	$tbl_name = "pb_meta";
	$select_items = "meta_id";
	$where = "WHERE object_type='$object_type' AND object_id='$object_id' AND meta_key='$meta_key'";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $sql );
	$arr = mysqli_fetch_assoc ( $result );
	$meta_id = $arr ['meta_id'];
	if (! $meta_id) {
		$set = "object_type='$object_type',object_id='$object_id',meta_key='$meta_key',meta_value='$meta_value'";
		$sql = create_insert_string ( $tbl_name, $set );
		doQuery ( $sql );
	} else {
		$set = "meta_value='$meta_value'";
		$where = "WHERE meta_id='$meta_id'";
		$sql = create_update_string ( $tbl_name, $set, $where );
		doQuery ( $sql );
	}
}
// function relationship_update($object_id = 0, $term_id = 0) {
// 	$tbl_name = "pb_term_relationships";
// 	$select_items = "object_id";
// 	$where = "WHERE object_id='$object_id' AND term_id='$term_id'";
// 	$sql = create_select_string ( $select_items, $tbl_name, $where );
// 	$result = doQuery ( $sql );
// 	$arr = mysqli_fetch_assoc ( $result );
// 	$meta_id = $arr ['meta_id'];
// 	if (! $meta_id) {
// 		$set = "object_id='$object_id',term_id='$term_id'";
// 		$sql = create_insert_string ( $tbl_name, $set );
// 		doQuery ( $sql );
// 	} else {
// 		$set = "meta_value='$meta_value'";
// 		$where = "WHERE meta_id='$meta_id'";
// 		$sql = create_update_string ( $tbl_name, $set, $where );
// 		doQuery ( $sql );
// 	}
// }
?>
