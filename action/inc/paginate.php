<?php
require_once 'db.php';

/**
 * 获取所要查询数据的总数目
 *
 * @param string $tbl_name
 *        	目标数据表
 * @param string $condition
 *        	查询条件
 * @return number $total_pages 总页数
 */
function get_total_pages($tbl_name, $where = '') {
	$query = "SELECT COUNT(*) as num FROM $tbl_name " . $where;
	$total_pages = mysqli_fetch_assoc ( doQuery ( $query ) );
	$total_pages = $total_pages ['num'];
	
	return $total_pages;
}

/**
 * 获取查询的数据结果集
 *
 * @param string $tbl_name
 *        	目标数据表
 * @param string $column_name
 *        	目标数据列（用','分隔）
 * @param string $condition
 *        	查询条件
 * @param number $limit
 *        	每页显示数目
 * @param number $cur_page
 *        	当前页码
 * @return Ambigous <boolean, object> 成功返回result对象或TRUE，失败返回FALSE
 */
function get_querry_result($tbl_name, $select_items, $where = '', $limit = 10, $cur_page = 1) {
	/* 设置开始变量 */
	$start = ($cur_page - 1) * $limit;
	
	/* 获取数据 */
	$sql = "SELECT $select_items FROM $tbl_name " . $where . " LIMIT $start, $limit";
	$result = doQuery ( $sql );
	
	return $result;
}

/**
 * 获取页码HTML代码
 *
 * @param string $targetpage
 *        	目标页面
 * @param number $total_pages
 *        	页码总数
 * @param number $limit
 *        	每页显示数目
 * @param number $adjacents
 *        	每边显示的页码数
 * @param number $cur_page
 *        	当前页码
 * @return string 页码的HTML代码
 */
function get_pages_string($target_page, $target_action = '', $total_pages, $limit = 10, $adjacents = 5, $cur_page = 1) {
	
	if ('' != $target_action) {
		$target_action = '&' . $target_action;
	}
	
	/* 设置页面显示变量 */
	$prev = $cur_page - 1; // 前一页面
	$next = $cur_page + 1; // 后一页面
	$lastpage = ceil ( $total_pages / $limit ); // 最后一页
	$lpm1 = $lastpage - 1; // 倒数第二页

	/*
	 * 设置页码样式
	 */
	$pagination = "";
	if ($lastpage > 1) {
		$pagination .= "<div class=\"pagination\">";
		
		// 上一页按钮
		if ($cur_page > 1) {
			$pagination .= "<a href=\"$target_page?page=1$target_action\">首页</a>";
			$pagination .= "<a href=\"$target_page?page=$prev" . "$target_action\"><<上一页</a>";
		} else {
			$pagination .= "<span class=\"disabled\">首页</span>";
			$pagination .= "<span class=\"disabled\"><<上一页</span>";
		}
		
		// 页码显示
		if ($lastpage < 7 + ($adjacents * 2)) 		// 页码数不足则全部显示
		{
			for($counter = 1; $counter <= $lastpage; $counter ++) {
				if ($counter == $cur_page)
					$pagination .= "<span class=\"current\">$counter</span>";
				else
					$pagination .= "<a href=\"$target_page?page=$counter" . "$target_action\">$counter</a>";
			}
		} elseif ($lastpage > 5 + ($adjacents * 2)) 		// 页码数过多隐藏部分
		{
			// 靠近开始；仅隐藏后面的页面
			if ($cur_page < 1 + ($adjacents * 2)) {
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter ++) {
					if ($counter == $cur_page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"$target_page?page=$counter" . "$target_action\">$counter</a>";
				}
				$pagination .= "...";
				// $pagination .= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				// $pagination .= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
			} 			// 在中间时；隐藏前面和后面的页码
			elseif ($lastpage - ($adjacents * 2) > $cur_page && $cur_page > ($adjacents * 2)) {
				// $pagination .= "<a href=\"$targetpage?page=1\">1</a>";
				// $pagination .= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination .= "...";
				for($counter = $cur_page - $adjacents; $counter <= $cur_page + $adjacents; $counter ++) {
					if ($counter == $cur_page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"$target_page?page=$counter" . "$target_action\">$counter</a>";
				}
				$pagination .= "...";
				// $pagination .= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				// $pagination .= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
			} 			// 靠近末尾；仅隐藏前面的页面
			else {
				// $pagination .= "<a href=\"$targetpage?page=1\">1</a>";
				// $pagination .= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination .= "...";
				for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter ++) {
					if ($counter == $cur_page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"$target_page?page=$counter" . "$target_action\">$counter</a>";
				}
			}
		}
		
		// 下一页按钮
		if ($cur_page < $counter - 1) {
			$pagination .= "<a href=\"$target_page?page=$next" . "$target_action\">下一页 >></a>";
			$pagination .= "<a href=\"$target_page?page=$lastpage" . "$target_action\">尾页</a>";
		} else {
			$pagination .= "<span class=\"disabled\">下一页 >></span>";
			$pagination .= "<span class=\"disabled\">尾页</span>";
		}
		$pagination .= "</div>\n";
	}
	
	return $pagination;
}

?>
