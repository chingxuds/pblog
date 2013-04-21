<?php
require_once '../action/inc/session.php';
require_once '../action/inc/protect.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>编辑个人资料</title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet"
	type="text/css">
<style type="text/css">
	.font-second {
		font-size: 14px;
		font-style: italic;
	}

	.pass_a_button {
		width: 65px;
		margin: 0;
		padding: 0;
		font-size: 16px;
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

		$(".pass_a_button").button();
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
							$("#" + id).val("已通过");
							$("#" + id).addClass("ui-state-disabled");
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
					<table>
						<thead>
							<tr>
								<td>评论人</td>
								<td>评论内容</td>
								<td>评论文章</td>
								<td>操作</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $_SESSION ['comment_unapproved'] as $index => $com ) {?>
								<tr style="border-top: black solid 1px">
								<td><a
									href="<?=$com['aid'] ? '/pblog/action/search.php?action=&id=' . $com['aid'] : 'mailto:' . $com['email'] ?>"><span><?=$com['author'] ?></span></a><br />
									<a href="mailto:<?=$com['email'] ?>"><span class="font-second"><?=$com['email'] ?></span></a><br />
									<span><?=$com['ip'] ?></span></td>
								<td><span class="font-second"><?=$com['date'] ?></span><br /> <span><?=$com['content'] ?></span></td>
								<td><a
									href="<?=$_SESSION['comment_posts'][$com['pid']]['url'] ?>"><span><?=$_SESSION['comment_posts'][$com['pid']]['title'] ?></span></a></td>
								<td><input type="button" class="pass_a_button"
									id="<?=$com['id'] ?>" value="通过" /></td>
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
