<?php
require_once 'inc/paginate.php';
require_once 'inc/session.php';

if (! application ( 'categories' )) {
	update_cats_in_app ();
}

if ( application ( 'posts_latest' )) {
	update_posts_latest_in_app ();
}

if (! application ( 'archives' )) {
	update_posts_archives ();
}
?>