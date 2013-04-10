<?php
require './action/inc/session.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>首页</title>
<link href="./includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="./includes/css/common.css" rel="stylesheet" type="text/css">
<script src="./includes/jquery/jquery.min.js"></script>
<script src="./includes/jquery/jquery-ui.min.js"></script>
<script src="./includes/js/common.js"></script>
<script type="text/javascript">
$(function() {
	$("#current_page").hover(
		function() {
			$(this).removeClass("ui-state-active");
		},
		function() {
			$( this ).addClass( "ui-state-active" );
		}
	);
});
        </script>
</head>

<body>
	<div id="topest"></div>
     <?php include 'nav-bar.php';?>
	<div id="div_container">
		<?php include 'header.php';?>
		<div id="div_main">
			<?php include 'siderbar-list.php';?>
			<div id="div_content">
				<div class="article-style">
					<article id="article1" class="global-a">
						<header>
							<h2>
								<a href="#" title="链向 测试文章一 的固定链接" rel="bookmark">测试文章一</a>
							</h2>
							<span class="article-author"><a
								href="http://localhost/wordpress/?author=1"
								title="查看所有由 chingxuds 发布的文章" rel="author">chingxuds</a></span><span>&nbsp;@&nbsp;</span>
							<span class="article-other"><a href="#" title="下午 1:17"
								rel="bookmark"> <time datetime="2013-03-29t13:17:50+00:00"> 2013
										年 3 月 29 日 </time>
							</a></span>
						</header>
						<div>
							<p>这是第一篇测试文章!</p>
						</div>
						<footer>
							<span class="article-other"><a
								href="http://localhost/wordpress/?cat=1" title="查看 未分类 中的全部文章"
								rel="category">#未分类</a></span> <br /> <span
								class="article-other"> <a href="#" title="《测试文章一》上的评论"><span>发表回复</span></a>
							</span>
						</footer>
						<!-- .entry-meta -->
					</article>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
