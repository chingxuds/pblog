<?php
require_once '../action/inc/session.php';
require_once '../action/inc/protect.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>全部用户列表</title>
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
		$("#list").accordion({ active: 1 });
		$("#pages_ul").buttonset();
		$(".pass_a_button").button();

		$(".update_status").click(function(){
			obj = $(this);
			id = obj.attr("title");
			method = obj.html();
			if(method == "更改"){
				str = "<select id=\"select_"+id+"\"><option value=\"0\">管理员</option><option value=\"1\">用户</option></select>";
				$("#status_"+id).html(str);
				obj.html("确认");
			}else if(method == "确认"){
				key = $("#select_"+id).val();
				val = $("#select_"+id+" option[value='"+key+"']").html();
				$("#status_"+id).html("更新中&hellip;");
				data_str = "action=ajax_update_status&uid="+id+"&status="+key;
				$.ajax({
					type : 'post',
					url : '/pblog/action/user.php',
					data : data_str,
					success : function(data) {
						if (data) {
							$("#status_"+id).html(val);
							obj.html("更改");
						}else{
							$("#status_"+id).html("失败");
							obj.html("重试");
						}
					}
				});
			}else if(method == "重试"){
				$("#status_"+id).html("更新中&hellip;");
				date_str = "action=ajax_update_status&uid="+id+"&status="+key;
				$.ajax({
					type : 'post',
					url : '/pblog/action/user.php',
					data : data_str,
					success : function(data) {
						if (data) {
							$("#status_"+id).html(val);
							$(this).html("更改");
						}else{
							$("#status_"+id).html("失败");
							$(this).html("重试");
						}
					}
				});
			}
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
			<?php if(!$_SESSION['users_list']){?>
				<div class="ui-state-highlight ui-corner-all post-lists"
					style="margin-left: 20px; margin-top: 20px; padding: 0 .7em;">
					<p>
						<span class="ui-icon ui-icon-info"
							style="float: left; margin-right: .3em;"></span> <strong>没有用户</strong>
					</p>
				</div>
				<?php
			} else {
				?>
					<div class="ui-state-highlight ui-corner-all post-lists"
					style="margin-left: 20px;">
					<table style="width: 100%" class="table-style">
						<thead>
							<tr>
								<td>编号</td>
								<td>用户名</td>
								<td>昵称</td>
								<td>邮箱</td>
								<td>注册时间</td>
								<td>级别</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $_SESSION ['users_list'] as $id => $u ) {?>
								
							
							<tr>
								<td><?=$u['id']?></td>
								<td><?=$u['name']?></td>
								<td><?=$u['nicename']?></td>
								<td><?=$u['email']?></td>
								<td><?=$u['time']?></td>
								<td><span id="status_<?=$u['id']?>"><?php
					switch ($u ['status']) {
						case 0 :
							echo '管理员';
							break;
						case 1 :
							echo '用户';
							break;
						
						default :
							echo '非法';
					}
					?></span><span style="float: right;"><a class="update_status"
										title="<?=$u['id']?>">更改</a></span></td>
							</tr>
								<?php } ?>
							</tbody>
						<tfoot>
							<tr>
								<td colspan="6"><?=$_SESSION['all_users_pagestr'] ?></td>
							</tr>
						</tfoot>
					</table>
				</div>
					<?php } ?></div>
		</div>
	</div>
</body>
</html>
