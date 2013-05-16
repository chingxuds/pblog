<?php
require_once '../action/inc/session.php';
require_once '../action/inc/db.php';

// ** 根据动作参数调用不同函数 ** //
$action = get_parameter_once('action');
if (!$action) {
    $action = 'post_view';
}
switch ($action) {
    case 'post_view' :
        post_view();
        break;
    case 'archive_view' :
        archive_view();
        break;

    default :
        break;
}

/**
 * 文章查看函数
 */
function post_view() {
    $link = createLink();
    $id = get_parameter_once('id');
    // echo "<script>alert($id);</script>";

    $tbl_name = "pb_posts";
    $select_items = "post_author,post_category,post_title,post_content,post_url,DATE_FORMAT(post_modified,'%Y年%m月%d日 %H:%i') AS date";
    $where = "WHERE post_id=$id";
    $sql = create_select_string($select_items, $tbl_name, $where);
    $result = doQuery($link, $sql);
    $arr = mysqli_fetch_assoc($result);
    if ($arr) {
        $post['id'] = $id;
        $post['category'] = $arr['post_category'];
        $post['title'] = $arr['post_title'];
        $post['content'] = preg_replace("/&##&/", "'", $arr['post_content']);
        $post['url'] = $arr['post_url'];
        $post['date'] = $arr['date'];

        $author['id'] = $arr['post_author'];
        $select_items = "user_displayname";
        $where = "WHERE user_id=" . $author["id"];
        $sql = create_select_string($select_items, 'pb_users', $where);
        $ur = doQuery($link, $sql);
        $u = mysqli_fetch_assoc($ur);
        $author['name'] = $u['user_displayname'];
        $post['author'] = $author;

        $tbl_name = "pb_comments";
        $select_items = "comment_id,comment_author,comment_author_email,DATE_FORMAT(comment_date,'%Y年%m月%d日 %H:%i') AS date,comment_content,comment_approved,user_id";
        $where = "WHERE post_id=$id";
        $sql = create_select_string($select_items, $tbl_name, $where);
        $cr = doQuery($link, $sql);
        $c = mysqli_fetch_assoc($cr);
        if ($c) {
            $i = 1;
            while ($c) {
                $comment['id'] = $c['comment_id'];
                $comment['author_name'] = $c['comment_author'];
                $comment['author_email'] = $c['comment_author_email'];
                $comment['date'] = $c['date'];
                $comment['content'] = $c['comment_content'];
                $comment['approved'] = $c['comment_approved'];
                $comment['uid'] = $c['user_id'];

                $comments[$i++] = $comment;
                $c = mysqli_fetch_assoc($cr);
            }
        } else {
            $comments = FALSE;
        }

        // 		echo "<pre>" . var_dump ( $comments ) . "</pre>";
        $_SESSION['post_view'] = $post;
        $_SESSION['comment_view'] = $comments;
    }
    closeLink($link);
    header('Location: /pblog/page/post-view.php');
}

/**
 * 归档查看函数
 */
function archive_view() {
    $link = createLink();
    $year = get_parameter_once('year');
    $month = get_parameter_once('month');
    $month_next = $month + 1;

    $tbl_name = 'pb_posts';
    $select_items = "post_id,post_title";
    $where = "WHERE UNIX_TIMESTAMP(post_modified_gmt) BETWEEN UNIX_TIMESTAMP('$year-$month-01 00:00:00') AND UNIX_TIMESTAMP('$year-$month_next-01 00:00:00')";
    $sql = create_select_string($select_items, $tbl_name, $where);
    closeLink($link);
}
?>