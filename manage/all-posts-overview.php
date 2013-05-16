<?php
require_once '../action/inc/session.php';
require_once '../action/inc/protect.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>全部文章列表</title>
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
		$("#list").accordion({ active: 2 });
		$("#pages_ul").buttonset();
		$(".pass_a_button").button();
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
			<?php if(!$_SESSION['all_posts_overview']){?>
				<div class="ui-state-highlight ui-corner-all post-lists"
					style="margin-left: 20px; margin-top: 20px; padding: 0 .7em;">
					<p>
						<span class="ui-icon ui-icon-info"
							style="float: left; margin-right: .3em;"></span> <strong>您尚未发表过文章</strong>
					</p>
				</div>
				<?php
			} else {
				?>
					<div class="ui-state-highlight ui-corner-all post-lists"
					style="margin-left: 20px;">
					<table style="width: 100%" class="table-style">
						<tbody>
							<?php foreach ( $_SESSION ['all_posts_overview'] as $id => $post ) {?>
								<tr>
								<td><a href="<?=$post['url'] ?>"><span><?=$post['title'] ?></span></a><br>
									<span><?=$post['author']['name'] ?></span>&nbsp;<span class="font-second">最后修改于<?=$post['date'] ?></span>
									<p><span><?=$post['excerpt'] ?></span></p>
								
								<td><a href="/pblog/action/post.php?action=edit_post&id=<?=$post['id'] ?>" class="pass_a_button"
									id="edit_<?=$post['id'] ?>"><span>修改</span></a><br />
								<a href="/pblog/action/post.php?action=disable_post&id=<?=$post['id'] ?>" class="pass_a_button"
									id="del_<?=$post['id'] ?>"><span>删除</span></a></td>
							</tr>
								<?php } ?>
							</tbody>
						<tfoot>
							<tr>
								<td colspan="3"><?=$_SESSION['all_posts_pagestr'] ?></td>
							</tr>
						</tfoot>
					</table>
				</div>
					<?php } ?></div>
		</div>
	</div>
</body>
</html>
