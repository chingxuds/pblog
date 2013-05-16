<div id="div_search">
    <input type="button" id="button_search" value="搜索" />
    <input
    type="text" id="text_search" name="search_title" />
</div>
<div id="list" class="global-a">
    <h4 id="quick-man-h">快捷菜单</h4>
    <div id="quick-man-d">
        <ul>
            <li>
                <a href="/pblog/manage/dashboard.php">仪表盘</a>
            </li>
            <li>
                <a href="/pblog/manage/post-new.php">撰写文章</a>
            </li>
            <li>
                <a href="/pblog/manage/?action=comment_unapproved_view">审核评论</a>
            </li>
        </ul>
    </div>
    <h4 id="user-man-h">个人管理</h4>
    <div id="user-man-d">
        <ul>
            <li>
                <a href="/pblog/manage/?action=profile_view">编辑个人资料</a>
            </li>
            <?php
if (! $_SESSION ['user'] ['status']) {
            ?>
            <li>
                <a href="/pblog/action/user.php?action=check_all_users">用户列表</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <h4 id="post-man-h">文章管理</h4>
    <div id="post-man-d">
        <ul>
            <li>
                <a href="/pblog/manage/post-new.php">撰写新文章</a>
            </li>
            <li>
                <a href="/pblog/action/post.php?action=self_posts_overview">已发表文章</a>
            </li>
            <?php
if (! $_SESSION ['user'] ['status']) {
            ?>
            <li>
                <a href="/pblog/action/post.php?action=all_posts_overview">全部文章列表</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <h4 id="com-man-h">评论管理</h4>
    <div id="com-man-d">
        <ul>
            <li>
                <a href="/pblog/manage/?action=comment_unapproved_view">审核评论</a>
            </li>
            <?php
if (! $_SESSION ['user'] ['status']) {
            ?>
            <li>
                <a href="/pblog/action/comment.php?action=check_all_comments">评论列表</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <h4 id="type-man-h">类别管理</h4>
    <div id="type-man-d">
        <ul>
            <li>
                <a href="/pblog/action/term.php?action=check_all_cats">分类管理</a>
            </li>
        </ul>
    </div>
</div>