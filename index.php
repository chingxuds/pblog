<?php
require_once 'action/inc/session.php';
require_once 'action/initialize.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>首页</title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet"
	type="text/css">
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
     <?php
        require_once 'nav-bar.php';
    ?>
	<div id="div_container">
		<?php
        require_once 'header.php';
    ?>
		<div id="div_main">
			<?php
            require_once 'siderbar-list.php';
        ?>
			<div id="div_content">
				<?php
				$posts_latest = application ( 'posts_latest' );
				$categories = application ( 'categories' );
				foreach ( $posts_latest as $index => $post ) {
					if (is_array ( $post )) {
						?>
				<div class="article-style">
					<article id="article1" class="global-a">
						<header>
							<h2>
								<a href="<?=$post['url'] ?>"
									title="链向 <?=$post['title'] ?> 的固定链接" rel="bookmark"><?=$post['title'] ?></a>
							</h2>
							<span class="article-author"><a
								href="/pblog/action/search.php?action=author&author=<?=$post['author']['id'] ?>"
								title="查看所有由 <?=$post['author']['name'] ?> 发布的文章" rel="author"><?=$post['author']['name'] ?></a></span><span>&nbsp;@&nbsp;</span>
							<span class="article-other"><time datetime="<?=$post['date'] ?>"><?=$post['date'] ?></time>
							</span>
						</header>
						<div>
							<p><?=$post['excerpt'] ?></p>
						</div>
						<footer>
							<span class="article-other"><a
								href="/pblog/action/search.php?action=category_view&cat=<?=$post['category'] ? $categories[$post['category']]['id'] : 0 ?>"
								title="查看 <?=$post['category'] ? $categories[$post['category']]['name'] : "未分类" ?> 中的全部文章"
								rel="category">#<?=$post['category'] ? $categories[$post['category']]['name'] : "未分类" ?></a></span>
							<br /> <span class="article-other"> <a href="<?=$post['url'] ?>"
								title="《测试文章一》上的评论"> <span><?=$post['comment_num'] ? $post['comment_num'] . "&nbsp;条回复" : "发表回复" ?>
								</span>
							</a>
							</span>
						</footer>
					</article>
				</div>			
				<?php
                }
                }
				?>
				<footer class="global-a" style="float: right; margin-right: 10px;">
					<a href="/pblog/action/search.php?action=post">查看全部 >></a>
				</footer>
			</div>
		</div>
	</div>
	<?php
        include_once 'footer.php';
 ?>
</body>
</html>
