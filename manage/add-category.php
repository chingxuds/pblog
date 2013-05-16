<?php
require_once '../action/inc/session.php';
require_once '../action/inc/protect.php';
$cats_arr = application ( 'categories' );
/**
 * 显示类别选择项函数
 *
 * @param array $a
 *        	当前数组
 * @param string $str
 *        	修饰字符串
 * @param array $arr
 *        	原始数组
 */
function echo_cat_tr($a, $str = '', $arr) {
	if ($_SESSION ['user'] ['status'] == 0) {
		echo "<tr id='t_" . $a ['id'] . "'><td id=\"n_" . $a ['id'] . "\">" . $str . $a ['name'] . "</td><td style='float:right'><a id='" . $a ['id'] . "' class='cat_edit' href='#t_" . $a ['id'] . "'>编辑</a>&nbsp;|&nbsp;<a id='" . $a ['id'] . "' class='cat_del'>删除</a></td></tr>";
	} else {
		echo "<tr id='t_" . $a ['id'] . "'><td id=\"n_" . $a ['id'] . "\">" . $str . $a ['name'] . "</td><td style='float:right'><a id='" . $a ['id'] . "' class='cat_edit' href='#t_" . $a ['id'] . "'>编辑</a></td></tr>";
	}
	if (isset ( $a ['child'] ) && is_array ( $a ['child'] )) {
		$str .= "-";
		foreach ( $a ['child'] as $key => $value ) {
			echo_cat_tr ( $arr [$key], $str, $arr );
		}
	}
}

/**
 * 显示类别选择项函数
 *
 * @param array $a
 *        	当前数组
 * @param string $str
 *        	修饰字符串
 * @param array $arr
 *        	原始数组
 */
function echo_cat_option($a, $str = '', $arr) {
	$str2 = "";
	if ($str != '')
		$str2 = "└";
	echo "<option value='" . $a ['id'] . "'>" . $str . $str2 . $a ['name'] . "</option>";
	if (isset ( $a ['child'] ) && is_array ( $a ['child'] )) {
		$str .= "&nbsp;";
		foreach ( $a ['child'] as $key => $value ) {
			echo_cat_option ( $arr [$key], $str, $arr );
		}
	}
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>类别添加</title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet"
	type="text/css">
<style type="text/css">
.font-second {
	font-size: 10px;
	font-style: italic;
}

.pass_a_button {
	width: 60px;
	margin: 0;
	padding: 0;
	font-size: 14px;
	text-align: center;
}

.pass_over {
	color: #FFFFFF;
}
</style>
<script src="/pblog/includes/jquery/jquery.min.js"></script>
<script src="/pblog/includes/jquery/jquery-ui.min.js"></script>
<script src="/pblog/includes/js/common.js"></script>
<script>
	$(function() {
		$("#list").accordion({ active: 4 });

		<?php 
			if($_SESSION['user']['status'] == 0){
		?>
		$(".cat_del").click(function(){
			id = $(this).attr("id");
			data_str = "action=ajax_del_cat&id=" + id;
			$.ajax({
				type : 'post',
				url : '/pblog/action/term.php',
				data : data_str,
				success : function(data) {
					if (data) {
						$("#t_"+id).remove();
					}else{
						alert("失败");
					}
				}
			});
		});
		<?php }?>

		$(".cat_edit").click(function() {
			id = $(this).attr("id");
			data_str = "action=ajax_get_cat_detail&id=" + id;
			$.ajax({
				type : 'post',
				url : '/pblog/action/term.php',
				data : data_str,
				success : function(data) {
					if (data) {
						obj = json_to_object(data);
						table = $("#cat_edit_table");
						table.css("display","block");
						$("#cat_edit_id").val(id);
						$("#cat_edit_name").val(obj.name);
						$("#cat_edit_slug").val(obj.slug);
						$("#cat_edit_description").val(obj.description);
						$("#cat_edit_parent").val(obj.parent);
						$("#t_"+id).after(table);
					}
				}
			});
		});

		$(".cat_edit").change(function(){
			$(this).attr("id",$(this).attr("id")+"_change");
		});

		$("#cat_edit_submit").click(function(){
			id = $("#cat_edit_id").val();
			name = $("#cat_edit_name_change").val()?"&name="+$("#cat_edit_name_change").val():"";
			slug = $("#cat_edit_slug_change").val()?"&slug="+$("#cat_edit_slug_change").val():"";
			desc = $("#cat_edit_description_change").val()?"&description="+$("#cat_edit_description_change").val():"";
			pare = $("#cat_edit_parent_change").val()?"&parent="+$("#cat_edit_parent_change").val():"";

			if(name!="" || slug!="" || desc!="" || pare!=""){
			data_str = "action=ajax_update_cat&id=" + id + name + slug + desc + pare;
			$.ajax({
				type : 'post',
				url : '/pblog/action/term.php',
				data : data_str,
				success : function(data) {
					if (data) {
						if(name!=""){
							$("#n_"+id).html($("#cat_edit_name_change").val());
						}
						$("#cat_edit_table").css("display","none");
					}else{
						alert("更新失败");
					}
				}
			});
			}else{
				$("#cat_edit_table").css("display","none");
			}
		});

		$("#cat_edit_cancle").click(function() {
			$("#cat_edit_table").css("display","none");
		});

	}); 
</script>
</head>

<body>
	<div id="topest"></div>
     <?php
					require_once '../nav-bar.php';
					?>
	<div id="div_container">
		<?php
		require_once '../header.php';
		?>
		<div id="div_main">
			<div id="div_sider" class="global-a">
				<?php
				require_once '../siderbar-manage.php';
				?>
			</div>
			<div id="div_content" class="global-a">
				<table id="cat_edit_table" style="display: none;">
					<tr>
						<td><input type="hidden" id="cat_edit_id" /></td>
					</tr>
					<tr>
						<td>名称</td>
						<td><input id="cat_edit_name" class="cat_edit" /></td>
					</tr>
					<tr>
						<td>别名</td>
						<td><input id="cat_edit_slug" class="cat_edit" /></td>
					</tr>
					<tr>
						<td>描述</td>
						<td><textarea id="cat_edit_description" class="cat_edit"></textarea></td>
					</tr>
					<tr>
						<td>父类别</td>
						<td><select id="cat_edit_parent" class="cat_edit"><option
									value="0">未分类</option> <?php foreach ( $cats_arr [0] ['child'] as $key => $value ) { echo_cat_option ( $cats_arr [$key], '', $cats_arr );}?></select></td>
					</tr>
					<tr>
						<td><input type="button" id="cat_edit_submit" value="更新" /></td>
						<td><input type="button" id="cat_edit_cancle" value="取消" /></td>
					</tr>
				</table>
			<?php if(!$_SESSION['all_cats_overview']){?>
				<div class="ui-state-highlight ui-corner-all post-lists"
					style="margin-left: 20px; margin-top: 20px; padding: 0 .7em;">
					<p>
						<span class="ui-icon ui-icon-info"
							style="float: left; margin-right: .3em;"></span> <strong>尚未有人评论</strong>
					</p>
				</div>
				<?php
			} else {
				?>
					<div class="ui-state-highlight ui-corner-all post-lists"
					style="margin-left: 20px;">
					<table style="width: 100%">
						<thead>
							<tr>
								<td>分类名</td>
								<td style='float: right'>操作</td>
							</tr>
						</thead>
						<tbody>
							<?php
				$cats = $_SESSION ['all_cats_overview'];
				foreach ( $cats [0] ['child'] as $id => $cat ) {
					echo_cat_tr ( $cats [$id], '', $cats );
				}
				?>
							</tbody>
					</table>
				</div>
					<?php } ?></div>
		</div>
	</div>
</body>
</html>
