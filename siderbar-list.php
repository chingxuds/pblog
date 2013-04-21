<?php
$posts_latest = application('posts_latest');
$archives = application('archives');
$categories = application('categories');
?>
<div id="div_sider" class="global-a">
    <div id="div_search">
        <form action="/pblog/action/search.php" method="post" >
            <input type="hidden" name="action" value="post" />
            <input type="submit" id="button_search" value="搜索" />
            <input
            type="text" id="text_search" name="key" />
        </form>
    </div>
    <div id="div_post_latest">
        <H4>近期文章</H4>
        <ul>
            <?php
foreach ( $posts_latest as $index => $post ) {
if (is_array ( $post )) {
            ?>
            <li>
                <a href="<?=$post['url'] ?>"
                title="链向 <?=$post['title'] ?> 的固定链接" rel="bookmark">《<?=$post['title'] ?>》
                </a>
            </li>
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
foreach ( $archives as $index => $archive ) {
            ?>
            <li>
                <a
                href="/pblog/action/search.php?action=archive_view_date&year=<?=$archive['year'] ?>&month=<?=$archive['month'] ?> "><?=$archive['date'] ?>（
                <?=$archive['count'] ?>）
                </a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div id="div_term">
        <H4>类别</H4>
        <ul>
            <?php
foreach ( $categories as $id => $cat ) {
if (0 != $id) {
            ?>
            <li>
                <a href="/pblog/action/search.php?action=category_view&cat=<?=$cat['id'] ?>"><?=$cat['name'] ?>（
                <?=$cat['count'] ?>）
                </a>
            </li>
            <?php
            }
            }
            ?>
        </ul>
    </div>
</div>
<?php
unset($posts_latest, $archives, $categories);
?>