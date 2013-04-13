<?php
require_once 'action/term.php';

$arr = get_all_cats ();

echo '<select>';
foreach ( $arr [0] ['child'] as $key => $value ) {
	echo_cat_option ( $arr [$key], '', $arr );
}
echo '</select>';
function echo_cat_option($a, $str = '', $arr) {
	if ($str != '')
		$str2 = "└";
	echo "<option value='" . $a ['id'] . "'>" . $str . $str2 . $a ['name'] . "</option>";
	if (is_array ( $a ['child'] )) {
		$str .= "&nbsp;";
		foreach ( $a ['child'] as $key => $value ) {
			echo_cat_option ( $arr [$key], $str, $arr );
		}
	}
}

?>
