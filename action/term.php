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
	case 'check_all_cats' :
		check_all_cats ();
		break;
	case 'ajax_get_cat_detail' :
		ajax_get_cat_detail ();
		break;
	case 'ajax_update_cat' :
		ajax_update_cat ();
		break;
	case 'ajax_del_cat' :
		ajax_del_cat ();
		break;
	
	default :
		break;
}

/**
 * Ajax 分类添加函数
 */
function ajax_cat_add() {
	$link = createLink ();
	$tbl_name = "pb_terms";
	
	$name = get_parameter_once ( 'cat_name' );
	$parent = get_parameter_once ( 'cat_parent' );
	$slug = code_short ( $name, 'ca' );
	
	$select_items = "term_id";
	$where = "WHERE term_name='$name' AND parent='$parent' AND taxonomy='category'";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	if (! $arr ['term_id']) {
		$set = "term_name='$name',term_slug='$slug',taxonomy='category',parent='$parent'";
		$sql = create_insert_string ( $tbl_name, $set );
		if (doQuery ( $link, $sql )) {
			$select_items = "term_id";
			$where = "WHERE term_name='$name' AND parent='$parent' AND taxonomy='category'";
			$sql = create_select_string ( $select_items, $tbl_name, $where );
			$result = doQuery ( $link, $sql );
			$arr = mysqli_fetch_assoc ( $result );
			
			$jsn_arr ['id'] = $arr ['term_id'];
			$jsn_arr ['name'] = $name;
			$jsn_arr ['parent'] = $parent;
			$jsn_arr ['pcount'] = find_parent_count ( $link, $tbl_name, 'parent', 'term_id', $jsn_arr ['parent'] );
			
			$jsn = json_encode ( $jsn_arr );
			update_cats_in_app($link);
			echo $jsn;
		} else {
			echo FALSE;
		}
	} else {
		echo FALSE;
	}
	closeLink ( $link );
}

/**
 * 标签更新函数
 */
function tags_update() {
	$link = createLink ();
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
	closeLink ( $link );
}

/**
 * 用于Ajax的标签更新函数
 */
function ajax_tag_update() {
	$link = createLink ();
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
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	$id = $arr ['term_id'];
	if (! $id) {
		$set = "term_name='$name',term_slug='$slug',taxonomy='$taxonomy',description='$description',parent='$parent',count='$count'";
		$sql = create_insert_string ( $tbl_name, $set );
		if (doQuery ( $link, $sql )) {
			echo TRUE;
		} else {
			echo FALSE;
		}
	} else {
		$count = $arr ['count'] + 1;
		$set = "count='$count'";
		$where = "term_id='$id'";
		$sql = create_update_string ( $tbl_name, $set, $where );
		if (doQuery ( $link, $sql )) {
			echo TRUE;
		} else {
			echo FALSE;
		}
	}
	closeLink ( $link );
}

/**
 * Ajax 标签添加函数
 */
function ajax_tag_add() {
	$link = createLink ();
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
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	$id = $arr ['term_id'];
	$jsn_arr ['name'] = $name;
	if (! $id) {
		$set = "term_name='$name',term_slug='$slug',taxonomy='$taxonomy',description='$description',parent='$parent',count='$count'";
		$sql = create_insert_string ( $tbl_name, $set );
		if (doQuery ( $link, $sql )) {
			$sql = create_select_string ( $select_items, $tbl_name, $where );
			$result = doQuery ( $link, $sql );
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
	closeLink ( $link );
}

/**
 * Ajax 查看热门标签函数
 */
function ajax_tag_common() {
	$link = createLink ();
	$tbl_name = "pb_terms";
	$select_items = "term_id,term_name";
	$where = "WHERE taxonomy='tag' ORDER BY count DESC LIMIT 10";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $link, $sql );
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
	closeLink ( $link );
}

/**
 * 获取全部分类函数
 *
 * @return Array 分类数组
 */
function get_all_cats() {
	$link = createLink ();
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
	
	// echo '<pre>' . var_dump($app_arr) . '</pre>';
	closeLink ( $link );
	return $app_arr;
}

/**
 * 查看全部分类函数
 */
function check_all_cats() {
	$link = createLink ();
	
	$tbl_name = "pb_terms";
	$select_items = "term_id,term_name,parent";
	$where = "WHERE taxonomy = 'category'";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	while ( $arr ) {
		$at ['id'] = $arr ['term_id'];
		$at ['name'] = $arr ['term_name'];
		$at ['parent'] = $arr ['parent'];
		
		$app_arr [$at ['parent']] ['child'] [$at ['id']] = $at ['id'];
		$app_arr [$at ['id']] = $at;
		$arr = mysqli_fetch_assoc ( $result );
	}
	
	$_SESSION ['all_cats_overview'] = $app_arr;
	header ( "Location: /pblog/manage/category.php" );
	// echo var_dump($app_arr);
	
	closeLink ( $link );
}

/**
 * Ajax获取分类详细信息函数
 */
function ajax_get_cat_detail() {
	$link = createLink ();
	
	$id = get_parameter_once ( "id" );
	
	$tbl_name = "pb_terms";
	$select_items = "term_name AS name,term_slug AS slug,description,parent";
	$where = "WHERE term_id=$id";
	$sql = create_select_string ( $select_items, $tbl_name, $where );
	$result = doQuery ( $link, $sql );
	$arr = mysqli_fetch_assoc ( $result );
	
	echo json_encode ( $arr );
	
	closeLink ( $link );
}

/**
 * Ajax分类信息更新函数
 */
function ajax_update_cat() {
	$link = createLink ();
	
	$id = get_parameter_once ( 'id' );
	$name = get_parameter_once ( 'name' );
	$slug = get_parameter_once ( 'slug' );
	$description = get_parameter_once ( 'description' );
	$parent = get_parameter_once ( 'parent' );
	
	$tbl_name = "pb_terms";
	$set = substr ( ($name ? ",term_name='$name'" : "") . ($slug ? ",term_slug='$slug'" : "") . ($description ? ",description='$description'" : "") . ($parent ? ",parent=$parent" : ""), 1 );
	$where = "WHERE term_id=$id";
	$sql = create_update_string ( $tbl_name, $set, $where );
	$result = doQuery ( $link, $sql );
	if ($result) {
		update_cats_in_app($link);
		echo true;
	} else {
		echo false;
	}
	
	closeLink ( $link );
}

/**Ajax分类删除函数*/
 function ajax_del_cat() {
 	$link = createLink();
 	
 	$id = get_parameter_once('id');
 	
 	$tbl_name = "pb_terms";
 	$set = "taxonomy='category_del'";
 	$where = "WHERE term_id=$id";
 	$sql = create_update_string ( $tbl_name, $set, $where );
 	$result = doQuery ( $link, $sql );
 	
 	$tbl_name = "pb_terms";
 	$set = "parent=0";
 	$where = "WHERE parent=$id";
 	$sql = create_update_string ( $tbl_name, $set, $where );
 	doQuery ( $link, $sql );
 	
 	$tbl_name = "pb_posts";
 	$set = "post_category=0";
 	$where = "WHERE post_category=$id";
 	$sql = create_update_string ( $tbl_name, $set, $where );
 	doQuery ( $link, $sql );
 	
 	if ($result) {
 		update_cats_in_app($link);
 		echo true;
 	} else {
 		echo false;
 	}
 	
 	closeLink($link);
 }
?>
