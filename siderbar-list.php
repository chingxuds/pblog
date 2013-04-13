<?php
?>
<div id="div_sider" class="global-a">
	<div id="div_search">
		<input type="button" id="button_search" value="搜索" /> <input
			type="text" id="text_search" name="search_title" />
	</div>
	<div id="div_post_latest">
		<H4>近期文章</H4>
		<ul>
		<?php
		$posts_latest = application ( 'posts_latest' );
		foreach ( $posts_latest as $index => $post ) {
			if (is_array ( $post )) {
				?>
			<li><a href="<?=$post['url'] ?>"
				title="链向 <?=$post['title'] ?> 的固定链接" rel="bookmark">《<?=$post['title'] ?>》</a></li>
				<?php
			}
		}
		?>
		</ul>
	</div>
	<div id="div_comment_latest">
		<H4>文章归档</H4>
		<ul>
		<?php
		$archives = application ( 'archives' );
		foreach ( $archives as $index => $archive ) {
			?>
			<li><a href="?year=<?=$archive['year']?>&month=<?=$archive['month']?> "><?=$archive['date']?>（<?=$archive['count']?>）</a></li>
			<?php
		}
		?>
		</ul>
	</div>
	<div id="div_term">
		<H4>类别</H4>
		<ul>
		<?php
		$categories = application ( 'categories' );
		foreach ( $categories as $id => $cat ) {
			if (0 != $id) {
				?>
			<li><a><?=$cat['name'] ?>（<?=$cat['count'] ?>）</a></li>
		<?php
			}
		}
		?>
		</ul>
	</div>
</div>