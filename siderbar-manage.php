<div id="div_search">
	<input type="button" id="button_search" value="搜索" /> <input
		type="text" id="text_search" name="search_title" />
</div>
<div id="list" class="global-a">
	<h4 id="quick-man-h">快捷菜单</h4>
	<div id="quick-man-d">
		<ul>
			<li><a href="/pblog/dashboard.php">查看数据</a></li>
			<li><a href="/pblog/page/edit.php">撰写文章</a></li>
			<li><a href="#">审核评论</a></li>
		</ul>
	</div>
	<h4 id="user-man-h">个人管理</h4>
	<div id="user-man-d">
		<ul>
			<li><a href="/pblog/manage/?action=profile_view">编辑个人资料</a></li>
			<?php
				if (! $_SESSION ['user'] ['status']) {
			?>
			<li><a href="#">用户列表</a></li>
			<?php 
				}
			?>
		</ul>
	</div>
	<h4 id="post-man-h">文章管理</h4>
	<div id="post-man-d">
		<ul>
			<li><a href="/pblog/page/edit.php">撰写新文章</a></li>
			<li><a href="#">已发表文章</a></li>
			<li><a href="#">草稿箱</a></li>
			<?php
			if (! $_SESSION ['user'] ['status']) {
				?>
			<li><a href="#">文章列表</a></li>
			<?php
			}
			?>
		</ul>
	</div>
	<h4 id="com-man-h">评论管理</h4>
	<div id="com-man-d">
		<ul>
			<li><a href="#">待审核评论</a></li>
			<?php
				if (! $_SESSION ['user'] ['status']) {
			?>
			<li><a href="#">评论列表</a></li>
			<?php 
				}
			?>
		</ul>
	</div>
	<h4 id="type-man-h">类别管理</h4>
	<div id="type-man-d">
		<ul>
			<li><a href="/pblog/manage/category.php">分类管理</a></li>
			<li><a href="/pblog/manage/category.php">标签管理</a></li>
			<?php
				if (! $_SESSION ['user'] ['status']) {
			?>
			<li><a href="#">类别列表</a></li>
			<li><a href="#">标签列表</a></li>
			<?php 
				}
			?>
		</ul>
	</div>
</div>