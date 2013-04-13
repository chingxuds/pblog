<?php
require_once 'inc/encrypt.php';
require_once 'inc/db.php';
require_once 'inc/session.php';
require_once 'inc/protect.php';

// ** 根据动作参数调用不同函数 ** //
$action = get_parameter_once ( 'action' );
switch ($action) {
	case 'ajax_tag_add' :
		ajax_tag_add ();
		break;
	case 'ajax_tag_common' :
		ajax_tag_common ();
		break;
	case 'get_all_cats' :
		get_all_cats ();
		break;
	case 'ajax_cat_add' :
		ajax_cat_add ();
		break;
	
	default :
		break;
}

/**
 * Ajax 分类添加函数
 */
function ajax_cat_add() {
	$tbl_name = "pb_terms";
	
	$name = get_parameter_once ( 'cat_name' );
	$parent = get_parameter_once ( 'cat_parent' );
	$slug = code_short ( $name, 'ca' );
	
	$select_items = "term_id";
	$where = "WHERE term_name='$name' AND parent='$parent' AND taxonomy='category'";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $sql );
	$arr = mysqli_fetch_assoc ( $result );
	if (! $arr ['term_id']) {
		$set = "term_name='$name',term_slug='$slug',taxonomy='category',parent='$parent'";
		$sql = create_insert_string ( $tbl_name, $set );
		if (doQuery ( $sql )) {
			$select_items = "term_id";
			$where = "WHERE term_name='$name' AND parent='$parent' AND taxonomy='category'";
			$sql = create_select_string ( $select_items, $tbl_name, $where );
			$result = doQuery ( $sql );
			$arr = mysqli_fetch_assoc ( $result );
			
			$jsn_arr ['id'] = $arr ['term_id'];
			$jsn_arr ['name'] = $name;
			$jsn_arr ['parent'] = $parent;
			$jsn_arr ['pcount'] = find_parent_count ( $tbl_name, 'parent', 'term_id', $jsn_arr ['parent'] );
			
			$jsn = json_encode ( $jsn_arr );
			echo $jsn;
		} else {
			echo FALSE;
		}
	} else {
		echo FALSE;
	}
}

/**
 * 标签更新函数
 */
function tags_update() {
	$tbl_name = "pb_terms";
	$id = get_parameter_once ( 'tag_id' );
	$name = get_parameter_once ( 'tag_name' );
	$slug = get_parameter_once ( 'tag_slug' );
	$description = get_parameter_once ( 'tag_description' );
	
	if (! $slug) {
		$slug = code_short ( $name, 'ta' );
	}
	if (! $description) {
		$description = '';
	}
	
	$set = "";
	if ($name) {
		$set .= "term_name='$name,'";
	}
	if ($slug) {
		$set .= "term_slug='$slug,'";
	}
	if ($description) {
		$set .= "description='$description'";
	}
	
	if ($set !== "") {
		$set = substr ( $set, 0, strlen ( $set ) - 1 );
		$where = "WHERE term_id='$id'";
		$sql = create_update_string ( $tbl_name, $set, $where );
	}
}

/**
 * 用于Ajax的标签更新函数
 */
function ajax_tag_update() {
	$name = get_parameter_once ( 'tag_name' );
	$slug = get_parameter_once ( 'tag_slug' );
	$description = get_parameter_once ( 'tag_description' );
	$taxonomy = 'tag';
	$parent = 0;
	$count = 0;
	
	if (! $slug) {
		$slug = code_short ( $name, 'ta' );
	}
	if (! $description) {
		$description = '';
	}
	
	$tbl_name = "pb_terms";
	$select_items = "term_id,count";
	$where = "WHERE term_name='$name' AND taxonomy='$taxonomy'";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $sql );
	$arr = mysqli_fetch_assoc ( $result );
	$id = $arr ['term_id'];
	if (! $id) {
		$set = "term_name='$name',term_slug='$slug',taxonomy='$taxonomy',description='$description',parent='$parent',count='$count'";
		$sql = create_insert_string ( $tbl_name, $set );
		if (doQuery ( $sql )) {
			echo TRUE;
		} else {
			echo FALSE;
		}
	} else {
		$count = $arr ['count'] + 1;
		$set = "count='$count'";
		$where = "term_id='$id'";
		$sql = create_update_string ( $tbl_name, $set, $where );
		if (doQuery ( $sql )) {
			echo TRUE;
		} else {
			echo FALSE;
		}
	}
}

/**
 * Ajax 标签添加函数
 */
function ajax_tag_add() {
	$name = get_parameter_once ( 'tag_name' );
	$slug = code_short ( $name, 'ta' );
	$description = '';
	$taxonomy = 'tag';
	$parent = 0;
	$count = 0;
	
	$tbl_name = "pb_terms";
	$select_items = "term_id";
	$where = "WHERE term_name='$name' AND taxonomy='$taxonomy'";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $sql );
	$arr = mysqli_fetch_assoc ( $result );
	$id = $arr ['term_id'];
	$jsn_arr ['name'] = $name;
	if (! $id) {
		$set = "term_name='$name',term_slug='$slug',taxonomy='$taxonomy',description='$description',parent='$parent',count='$count'";
		$sql = create_insert_string ( $tbl_name, $set );
		if (doQuery ( $sql )) {
			$sql = create_select_string ( $select_items, $tbl_name, $where );
			$result = doQuery ( $sql );
			$arr = mysqli_fetch_assoc ( $result );
			$jsn_arr ['id'] = $arr ['term_id'];
			$jsn = json_encode ( $jsn_arr );
			echo $jsn;
		} else {
			echo FALSE;
		}
	} else {
		$jsn_arr ['id'] = $id;
		$jsn = json_encode ( $jsn_arr );
		echo $jsn;
	}
}

/**
 * Ajax 查看热门标签函数
 */
function ajax_tag_common() {
	$tbl_name = "pb_terms";
	$select_items = "term_id,term_name";
	$where = "WHERE taxonomy='tag' ORDER BY count DESC LIMIT 10";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $sql );
	$arr = mysqli_fetch_assoc ( $result );
	$int = 0;
	while ( $arr ) {
		$at ['id'] = $arr ['term_id'];
		$at ['name'] = $arr ['term_name'];
		$jsn_arr [$int] = $at;
		$int ++;
		$arr = mysqli_fetch_assoc ( $result );
	}
	$jsn = json_encode ( $jsn_arr );
	echo $jsn;
}

/**
 * 获取全部分类函数
 * @return Array 分类数组
 */
function get_all_cats() {
	$tbl_name = "pb_terms";
	$select_items = "term_id,term_name,term_slug,parent,count";
	$where = "WHERE taxonomy = 'category'";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $sql );
	$arr = mysqli_fetch_assoc ( $result );
	while ( $arr ) {
		$at ['id'] = $arr ['term_id'];
		$at ['name'] = $arr ['term_name'];
		$at ['slug'] = $arr ['term_slug'];
		$at ['parent'] = $arr ['parent'];
		$at ['count'] = $arr ['count'];
		
		$app_arr [$at ['parent']]['child'] [$at ['id']] = $at ['id'];
		$app_arr [$at ['id']] = $at;
		$arr = mysqli_fetch_assoc ( $result );
	}
	
// 	echo '<pre>' . var_dump($app_arr) . '</pre>';
	
	return $app_arr;
}

?>
