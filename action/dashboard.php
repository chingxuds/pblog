<?php
require_once 'inc/db.php';

$link = createLink ();

$uid = $_SESSION ['user'] ['id'];

$sql = "SELECT COUNT(post_id) AS post_num FROM pb_posts WHERE post_author=$uid AND post_status=0";
$result = doQuery ( $link, $sql );
$arr = mysqli_fetch_assoc ( $result );
$overview ['post_num'] = $arr ['post_num'];

$sql = "SELECT COUNT(term_id) AS cat_num FROM pb_terms WHERE taxonomy='category'";
$result = doQuery ( $link, $sql );
$arr = mysqli_fetch_assoc ( $result );
$overview ['cat_num'] = $arr ['cat_num'];

$sql = "SELECT COUNT(comment_id) AS app_num FROM pb_comments WHERE comment_approved='approved' AND post_id IN (SELECT post_id FROM pb_posts WHERE post_author=$uid AND post_status=0)";
$result = doQuery ( $link, $sql );
$arr = mysqli_fetch_assoc ( $result );
$overview ['app_num'] = $arr ['app_num'];

$sql = "SELECT COUNT(comment_id) AS unapp_num FROM pb_comments WHERE comment_approved='unapproved' AND post_id IN (SELECT post_id FROM pb_posts WHERE post_author=$uid AND post_status=0)";
$result = doQuery ( $link, $sql );
$arr = mysqli_fetch_assoc ( $result );
$overview ['unapp_num'] = $arr ['unapp_num'];

$sql = "SELECT c.comment_id,c.comment_author,DATE_FORMAT(c.comment_date,'%Y年%m月%d日 %H:%i') AS date,c.comment_approved,p.post_title,p.post_url FROM pb_comments c,pb_posts p WHERE c.post_id=p.post_id AND p.post_status=0 AND p.post_author=$uid ORDER BY comment_date_gmt DESC LIMIT 0,5;";
$result = doQuery ( $link, $sql );
$arr = mysqli_fetch_assoc ( $result );
while ( $arr ) {
	$comment ['id'] = $arr ['comment_id'];
	$comment ['author'] = $arr ['comment_author'];
	$comment ['date'] = $arr ['date'];
	$comment ['status'] = ($arr ['comment_approved'] == 'approved') ? '已审核' : '未审核';
	$comment ['title'] = $arr ['post_title'];
	$comment ['url'] = $arr ['post_url'];
	
	$recent_coms[$comment ['id']] = $comment;
	$arr = mysqli_fetch_assoc ( $result );
}
$overview ['recent_coms'] = $recent_coms;

closeLink ( $link );
?>
