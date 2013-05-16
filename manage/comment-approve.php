<?php
require_once '../action/inc/session.php';
require_once '../action/inc/protect.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>评论审核页面</title>
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
	width: 100px;
	margin: 0;
	padding: 0;
	font-size: 16px;
	text-align: center;
}

.del_a_button {
	width: 100px;
	margin: 0;
	padding: 0;
	font-size: 16px;
	text-align: center;
}

.pass_over {
	width: 100px;
	margin: 0;
	padding: 0;
	text-align: center;
}

.del_over {
	width: 100px;
	margin: 0;
	padding: 0;
	text-align: center;
	color: rgb(255, 0, 132);
}
</style>
<script src="/pblog/includes/jquery/jquery.min.js"></script>
<script src="/pblog/includes/jquery/jquery-ui.min.js"></script>
<script src="/pblog/includes/js/common.js"></script>
<script>
	$(function() {
		$("#list").accordion({ active: 3 });

		$(".pass_a_button,.del_a_button").button();

		$(".pass_a_button").click(function() {
			var id = $(this).attr("id");
			if (!$(this).hasClass("ui-state-disabled")) {
				data_str = "action=ajax_comment_approve&id=" + id;
				$.ajax({
					type : 'post',
					url : '/pblog/action/comment.php',
					data : data_str,
					success : function(data) {
						if (data) {
							$("#operation_" + id).html("<span id=\"pass_over_"+id+"\" class=\"pass_over\">已通过</span>");
							$("#pass_over_" + id).button();
							$("#pass_over_" + id).addClass("ui-state-disabled");
						}
					}
				});
			}
		});

		$(".del_a_button").click(function() {
			var id = $(this).attr("id");
			if (!$(this).hasClass("ui-state-disabled")) {
				data_str = "action=ajax_comment_del&id=" + id;
				$.ajax({
					type : 'post',
					url : '/pblog/action/comment.php',
					data : data_str,
					success : function(data) {
						if (data) {
							$("#operation_" + id).html("<span id=\"del_over_"+id+"\" class=\"del_over\">已删除</span>");
							$("#del_over_" + id).button();
							$("#del_over_" + id).addClass("ui-state-disabled");
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
			<?php if(!$_SESSION['comment_unapproved']){?>
				<div class="ui-state-highlight ui-corner-all post-lists"
					style="margin-left: 20px; margin-top: 20px; padding: 0 .7em;">
					<p>
						<span class="ui-icon ui-icon-info"
							style="float: left; margin-right: .3em;"></span> <strong>没有未审批的评论</strong>
					</p>
				</div>
				<?php
			} else {
				?>
					<div class="ui-state-highlight ui-corner-all post-lists"
					style="margin-left: 20px;">
					<table style="width: 100%">
						<thead style="width: 100%">
							<tr>
								<td>评论人</td>
								<td>评论详情</td>
								<td style="width: 100px;">操作</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $_SESSION ['comment_unapproved'] as $index => $com ) {?>
								<tr bgcolor="#cccccc">
								<td style="background-color: #ffffff; border-top-color: #cccccc; border-top-style: solid; border-top-width: thin;"><a
									href="<?=$com['aid'] ? '/pblog/action/search.php?action=&id=' . $com['aid'] : 'mailto:' . $com['email'] ?>"><span><?=$com['author'] ?></span></a><br />
									<a href="mailto:<?=$com['email'] ?>"><span class="font-second"><?=$com['email'] ?></span></a><br />
									<span><?=$com['ip'] ?></span></td>
								<td style="background-color: #ffffff; border-top-color: #cccccc; border-top-style: solid; border-top-width: thin;"><a
									href="<?=$_SESSION['comment_posts'][$com['pid']]['url'] ?>"
									title="<?=$_SESSION['comment_posts'][$com['pid']]['title']?>"><span
										class="font-second"><?=$_SESSION['comment_posts'][$com['pid']]['title']?></span></a><br />
									<span class="font-second"><?=$com['date'] ?></span>
									<p>
										<span><?=$com['content'] ?></span>
									</p></td>
								<td style="background-color: #ffffff; border-top-color: #cccccc; border-top-style: solid; border-top-width: thin;" id="operation_<?=$com['id'] ?>"><input
									type="button" class="pass_a_button" id="<?=$com['id'] ?>"
									value="通过" /><br /> <input type="button" class="del_a_button"
									id="<?=$com['id'] ?>" value="删除" /></td>
							</tr>
								<?php } ?>
							</tbody>
					</table>
				</div>
					<?php } ?></div>
		</div>
	</div>
</body>
</html>
