<?php
require_once '../action/inc/db.php';
require_once '../action/inc/session.php';
require_once '../action/other.php';
require_once '../action/inc/protect.php';

// ** 根据动作参数调用不同函数 ** //
$action = get_parameter_once('action');
switch ($action) {
    case 'profile_view' :
        profile_view();
        break;
    case 'comment_unapproved_view' :
        comment_unapproved_view();
        break;

    default :
        break;
}

/**
 * 查看个人资料函数
 */
function profile_view() {
    $link = createLink();
    $object_id = $_SESSION['user']['id'];

    $select_items = "meta_key,meta_value";
    $where = "WHERE object_type='user' AND object_id='$object_id'";
    $sql = create_select_string($select_items, "pb_meta", $where);
    $result = doQuery($link, $sql);

    if ($result) {
        $arr = mysqli_fetch_assoc($result);
        while ($arr) {
            $user_profile[$arr['meta_key']] = $arr['meta_value'];
            $arr = mysqli_fetch_assoc($result);
        }
    }

    $select_items = "user_nicename,user_email";
    $where = "WHERE user_id='$object_id'";
    $sql = create_select_string($select_items, "pb_users", $where);
    // echo $sql . '<br>';
    $result = doQuery($link, $sql);

    if ($result) {
        $arr = mysqli_fetch_assoc($result);
        $user_profile['nicename'] = $arr['user_nicename'];
        $user_profile['email'] = $arr['user_email'];
    }

    $_SESSION['user_profile'] = $user_profile;
    closeLink($link);
    header('Location:./profile.php');
}

/**
 * 未审核评论查看函数
 */
function comment_unapproved_view() {
    $link = createLink();
    $id = $_SESSION['user']['id'];

    $sql = "SELECT comment_id,post_id,comment_author,comment_author_email,comment_author_IP,DATE_FORMAT(comment_date,'%Y年%m月%d日 %H:%i') AS date,comment_content,user_id FROM pb_comments WHERE comment_approved='unapproved' AND post_id IN (SELECT post_id FROM pb_posts WHERE post_author=$id)";
    $result = doQuery($link, $sql);
    $arr = mysqli_fetch_assoc($result);
    if ($arr) {
        $i = 1;
        $j = 0;
        while ($arr) {
            // echo "<pre>" . var_dump ( $arr ) . "</pre>";
            $com['id'] = $arr['comment_id'];
            $com['author'] = $arr['comment_author'];
            $com['aid'] = $arr['user_id'];
            $com['email'] = $arr['comment_author_email'];
            $com['ip'] = $arr['comment_author_IP'];
            $com['date'] = $arr['date'];
            $com['content'] = $arr['comment_content'];
            $com['pid'] = $arr['post_id'];
            if (!$j) {
                $posts[$j++] = "'" . $com['pid'] . "'";
            } elseif (!in_array("'" . $com['pid'] . "'", $posts)) {
                $posts[$j++] = "'" . $com['pid'] . "'";
            }

            $coms[$i++] = $com;
            $arr = mysqli_fetch_assoc($result);
        }

        $pids = implode(",", $posts);
        $sql = "SELECT post_id,post_title,post_url FROM pb_posts WHERE post_id IN (" . $pids . ")";
        $pr = doQuery($link, $sql);
        $pa = mysqli_fetch_assoc($pr);
        while ($pa) {
            $pos[$pa['post_id']]['id'] = $pa['post_id'];
            $pos[$pa['post_id']]['title'] = $pa['post_title'];
            $pos[$pa['post_id']]['url'] = $pa['post_url'];

            $pa = mysqli_fetch_assoc($pr);
        }

        // echo "<pre>" . var_dump ( $pos ) . "</pre>";

        $_SESSION['comment_unapproved'] = $coms;
        $_SESSION['comment_posts'] = $pos;
    } else {
        $_SESSION['comment_unapproved'] = FALSE;
    }
    // echo "<pre>" . var_dump ( $_SESSION ['comment_unapproved'] ) . "</pre>";
    closeLink($link);

    header('Location:./comment-approve.php');
}
?>
