<?php
require 'action/inc/paginate.php';

$cur_page = $_GET ['page'];
$targetpage = 'test.php';
$tbl_name = 'wp_usermeta';
$column_name = 'meta_key';

$total_pages = get_total_pages ( $tbl_name );
$result = get_querry_result ( $tbl_name, $column_name, '', 1, $cur_page );
$pagination = get_pages_string ( $targetpage, $total_pages, 1, 2, $cur_page );

while ( $row = mysqli_fetch_assoc ( $result ) ) {
	foreach ( $row as $key => $val ) {
		echo $key . ' => ' . $val;
	}
	// Your while loop here
}

echo $pagination;
?>

