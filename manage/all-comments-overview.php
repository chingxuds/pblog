<?php
require_once '../action/inc/session.php';
require_once '../action/inc/protect.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>全部评论列表</title>
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
		$("#list").accordion({ active: 3 });
		$("#pages_ul").buttonset();
		$(".pass_a_button,.del").button();

		$(".del").click(function() {
			var id = $(this).attr("id");
				data_str = "action=ajax_comment_del&id=" + id;
				$.ajax({
					type : 'post',
					url : '/pblog/action/comment.php',
					data : data_str,
					success : function(data) {
						if (data) {
							$("#td_" + id).html("已删除");
						}
					}
				});
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
			<?php if(!$_SESSION['all_comments_overview']){?>
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
					<table style="width: 100%" class="table-style">
						<thead>
							<tr>
								<td>编号</td>
								<td>内容</td>
								<td>删除</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $_SESSION ['all_comments_overview'] as $id => $com ) {?>
								<tr id="tr_<?=$com['id']?>">
								<td><?=$com['id']?></td>
								<td><?=$com['author']?>&nbsp;<?=$com['email']?>
								&nbsp;<?=$com['ip']?><br><?=$com['date']?>
								<p><?=$com['content']?></p></td>
								<td id="td_<?=$com['id']?>"><a id="<?=$com['id']?>" class="del">删除</a></td>
							</tr>
								<?php } ?>
							</tbody>
						<tfoot>
							<tr>
								<td colspan="6"><?=$_SESSION[ 'all_comments_pagestr' ]?></td>
							</tr>
						</tfoot>
					</table>
				</div>
					<?php } ?></div>
		</div>
	</div>
</body>
</html>
