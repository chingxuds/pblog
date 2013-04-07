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
	<div id="div_top_bar" class="navbar-a">
		<div id="div_tool_bar">
			<div id="div_nav">
				<nav id="nav_user" class="navbar">
                            <?php include 'nav-bar.php';?>
			 </nav>
			</div>
			<div id="div_topback" class="navbar">
				<a href="#topest">&nbsp;回到顶部&nbsp;</a>
			</div>
		</div> 
	</div>
	<div id="div_container">
		<div id="div_header">
			<header id="header">
				<hgroup id="hgroup">
					<h1>个人博客网</h1>
					<H4>用来完成毕设的个人博客网站</H4>
				</hgroup>
				<nav id="nav_menu" style="float: none">
					<ul id="nav_menu_ul">
						<li id="current_page" class="ui-state-active"><a
							href="#div_content">首页</a></li>
						<li><a href="#div_content">心情</a></li>
						<li><a href="#div_content">文章列表</a></li>
						<li><a href="#div_content">类别列表</a></li>
					</ul>
				</nav>
			</header>
		</div>
		<div id="div_main">
			<div id="div_sider" class="global-a">
				<div id="div_search">
					<input type="button" id="button_search" value="搜索" /> <input
						type="text" id="text_search" name="search_title" />
				</div>
				<div id="div_post_latest">
					<H4>近期文章</H4>
					<ul>
						<li><a>第n篇</a></li>
						<li><a>第n篇</a></li>
						<li><a>第n篇</a></li>
						<li><a>第n篇</a></li>
					</ul>
				</div>
				<div id="div_comment_latest">
					<H4>文章归档</H4>
					<ul>
						<li><a>2013年03月</a></li>
						<li><a>2013年03月</a></li>
						<li><a>2013年03月</a></li>
						<li><a>2013年03月</a></li>
					</ul>
				</div>
				<div id="div_term">
					<H4>类别</H4>
					<ul>
						<li><a>心情</a></li>
						<li><a>随笔</a></li>
						<li><a>科技</a></li>
						<li><a>八卦</a></li>
					</ul>
				</div>
			</div>
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
