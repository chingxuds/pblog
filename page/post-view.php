<?php
require_once '../action/inc/session.php';
$post_view = $_SESSION ['post_view'];
$categories = application ( 'categories' );
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>查看文章—<?=$post_view['title'] ?></title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet" type="text/css">
<script src="/pblog/includes/jquery/jquery.min.js"></script>
<script src="/pblog/includes/jquery/jquery-ui.min.js"></script>
<script src="/pblog/includes/js/common.js"></script>
<script type="text/javascript">
$(function() {
});
        </script>
</head>

<body>
	<div id="topest"></div>
     <?php require_once '../nav-bar.php';?>
	<div id="div_container">
		<?php require_once '../header.php';?>
		<div id="div_main">
			<?php require_once '../siderbar-list.php';?>
			<div id="div_content">
				<div class="article-style">
					<article id="article1" class="global-a">
						<header>
							<h2>
								<a href="<?=$post_view['url'] ?>"
									title="链向 <?=$post_view['title'] ?> 的固定链接" rel="bookmark"><?=$post['title'] ?></a>
							</h2>
							<span class="article-author"><a
								href="http://localhost/wordpress/?author=<?=$post_view['author']['id'] ?>"
								title="查看所有由 <?=$post_view['author']['name'] ?> 发布的文章" rel="author"><?=$post['author']['name'] ?></a></span><span>&nbsp;@&nbsp;</span>
							<span class="article-other"><a href="#" title="下午 1:17"
								rel="bookmark"> <time datetime="2013-03-29t13:17:50+00:00"><?=$post_view['date'] ?></time>
							</a></span>
						</header>
						<div>
							<p><?=$post_view ['content'] ?></p>
						</div>
						<footer>
							<span class="article-other"><a
								href="http://localhost/wordpress/?cat=<?=$categories[$post_view['category']]['id'] ?>"
								title="查看 <?=$categories[$post_view['category']]['name'] ?> 中的全部文章"
								rel="category">#<?=$categories[$post_view['category']]['name']?></a></span>
							<br /> <span class="article-other"> <a href="#"
								title="《测试文章一》上的评论"><span>发表回复</span></a>
							</span>
							</footer>
							<div id="div_comment_post"
								style="padding-left: 10px; margin: 10px;">
								<form>
									<span>姓名：</span> <input type="text" /> <span>邮箱：</span> <input
										type="text" />
									<textarea id="comment" name="comment"
										style="width: 675px; border: 1">请书写评论...</textarea>
								</form>
							</div>
							<div id="div_comment" style="margin: 20px">
								<div class="comment-style" id="lv_1">
									<article id="comment1">
										<header>
											<h5>
												<span>1楼</span>&nbsp;&nbsp;<span class="article-author"><a
													href="http://localhost/wordpress/?author=1"
													title="查看所有由 chingxuds 发布的文章" rel="author">chingxuds</a></span><span>&nbsp;@&nbsp;</span><span
													class="article-other"><a href="#" title="下午 1:17"
													rel="bookmark"> <time datetime="2013-03-29t13:17:50+00:00">
															2013 年 3 月 29 日 </time>
												</a></span><span class="article-other" style="float: right">
													<a href="#" title="《测试文章一》上的评论"><span>回复</span></a>
												</span>
											</h5>
										</header>
										<div>
											<p>这是第一篇测试评论!</p>
										</div>
									</article>
								</div>
								<div class="comment-style" id="lv_2">
									<article id="comment1">
										<header>
											<h5>
												<span>2楼</span>&nbsp;&nbsp;<span class="article-author"><a
													href="http://localhost/wordpress/?author=1"
													title="查看所有由 chingxuds 发布的文章" rel="author">chingxuds</a></span><span>&nbsp;@&nbsp;</span><span
													class="article-other"><a href="#" title="下午 1:17"
													rel="bookmark"> <time datetime="2013-03-29t13:17:50+00:00">
															2013 年 3 月 29 日 </time>
												</a></span><span class="article-other" style="float: right">
													<a href="#" title="《测试文章一》上的评论"><span>回复</span></a>
												</span>
											</h5>
										</header>
										<div>
											<p>
												<a href="#lv_1">@1楼</a>这是第一篇测试评论!
											</p>
										</div>
									</article>
								</div>
							</div>
					</article>
				</div>
			</div>
		</div>
	</div>
	<?php include_once '../footer.php'; ?>
	<?php echo "<pre>" . var_dump($post_view) . "</pre>";?>
</body>
</html>
