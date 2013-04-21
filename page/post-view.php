<?php
require_once '../action/inc/session.php';
$post_view = $_SESSION['post_view'];
$comment_view = $_SESSION['comment_view'];
$cats = application('categories');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>查看文章—<?=$post_view['title'] ?></title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet"
	type="text/css">
<style type="text/css">
	.like-button-text {
		height: 38px;
		line-height: 38px;
		width: 75px;
		margin-bottom: 3px;
		margin-right: 0;
	}

	.like-button-input {
		font-size: 18px;
		width: 200px;
		height: 34px;
		line-height: 34px;
		margin-left: 0;
		margin-right: 10px;
		border-left: none;
		border-top: none;
		border-right: none;
		border-bottom-color: #DDDDDD;
		border-bottom-style: solid;
		border-bottom-width: 1px;
		height: 34px;
	}
</style>
<script src="/pblog/includes/jquery/jquery.min.js"></script>
<script src="/pblog/includes/jquery/jquery-ui.min.js"></script>
<script src="/pblog/includes/js/common.js"></script>
<script type="text/javascript">
	$(function() {
		$("#comment_submit").button();

		$("#comment_submit").click(function() {
			$("#comment_date").val(getCurrentFormatDate());
			$("#comment_form").submit();
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
			<?php
            require_once '../siderbar-list.php';
        ?>
			<div id="div_content">
				<div class="article-style">
					<article id="article1" class="global-a">
						<header>
							<h2>
								<a href="<?=$post_view['url'] ?>"
									title="链向 <?=$post_view['title'] ?> 的固定链接" rel="bookmark"><?=$post_view['title'] ?></a>
							</h2>
							<span class="article-author"><a
								href="http://localhost/wordpress/?author=<?=$post_view['author']['id'] ?>"
								title="查看所有由 <?=$post_view['author']['name'] ?> 发布的文章"
								rel="author"><?=$post_view['author']['name'] ?></a></span><span>&nbsp;@&nbsp;</span>
							<span class="article-other"><a href="#" title="下午 1:17"
								rel="bookmark"> <time datetime="2013-03-29t13:17:50+00:00"><?=$post_view['date'] ?></time>
							</a></span>
						</header>
						<div style="overflow: visible;">
							<p><?=$post_view['content'] ?></p>
						</div>
						<footer>
							<span class="article-other"><a
								href="/pblog/action/search.php?action=category_view&cat=<?=$post_view['category'] ? $cats[$post_view['category']]['id'] : 0 ?>"
								title="查看 <?=$post_view['category'] ? $cats[$post_view['category']]['name'] : "未分类" ?> 中的全部文章"
								rel="category">#<?=$post_view['category'] ? $cats[$post_view['category']]['name'] : "未分类" ?></a></span>
							<!-- <br /> <span class="article-other"> <a href="#"
								title="《测试文章一》上的评论"><span>发表回复</span></a>
							</span> -->
						</footer>
					</article>
				</div>
				<div id="div_comment_post" style="padding-left: 10px; margin: 10px;">
					<form id="comment_form" action="/pblog/action/comment.php">
						<input type="hidden" name="pid" value="<?=$post_view['id'] ?>" /> <input
							type="hidden" name="action" value="comment_submit" /><input
							type="hidden" id="comment_date" name="comment_date" /> <input
							type="button" id="comment_submit" style="float: right" value="提交" /> 
					<?php
					if ($_SESSION ['isLogin']) {
						?>
					<input type="hidden" name="author"
							value="<?=$_SESSION['user']['id'] ?>" /> <input type="hidden"
							name="author_name" value="<?=$_SESSION['user']['displayname'] ?>" />
						<input type="hidden" name="author_email"
							value="<?=$_SESSION['user']['email'] ?>" />
						<div style="float: left; height: 40px; line-height: 40px;font-size: 18px;">
							<span>您将以&nbsp;<?=$_SESSION['user']['displayname'] ?>&nbsp;的身份评论此文章</span>
						</div>
					<?php }else{ ?>
							
							<label style="float: left"> <span
							class="ui-button ui-widget ui-state-default ui-corner-all like-button-text">邮箱</span>
							<input type="text" class="like-button-input" name="author_email" /></label>
						<label style="float: left"> <span
							class="ui-button ui-widget ui-state-default ui-corner-all like-button-text">姓名</span>
							<input type="text" class="like-button-input" name="author_name" /></label>
					<?php } ?>
						<textarea id="comment" name="comment_content"
							style="width: 663px; border: 1">请书写评论...</textarea>
					</form>
				</div>
				<div id="div_comment" class="global-a" style="margin: 20px">
				<?php
				if ($comment_view) {
					$lv = 0;
					foreach ( $comment_view as $index => $comment ) {
						++ $lv;
						?>
				<div class="comment-style" id="lv_<?=$lv ?>">
						<article id="comment<?=$lv ?>">
							<header>
								<h5>
									<span><?=$lv ?>楼</span>&nbsp;&nbsp;<span class="article-author"><a
										href="/pblog/page/?author=1" title="查看所有由 chingxuds 发布的文章"
										rel="author"><?=$comment['author_name'] ?></a></span><span>&nbsp;@&nbsp;</span><span
										class="article-other"><a href="#" title="下午 1:17"
										rel="bookmark"> <time datetime="2013-03-29t13:17:50+00:00">
												<?=$comment['date'] ?></time>
									</a></span>
									<!-- <span class="article-other" style="float: right"> <a
 										href="#" title="《测试文章一》上的评论"><span>回复</span></a>
									</span> -->
								</h5>
							</header>
							<div>
								<p><?=$comment['content'] ?></p>
							</div>
						</article>
					</div>
				<?php }} ?>
		</div>

			</div>
		</div>
	</div>
	<?php
        include_once '../footer.php';
 ?>
</body>
</html>
<?php
unset($post_view, $comment_view, $cats);
?>