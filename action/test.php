<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
	if (empty ( $_SESSION ['aaa'] )) {
		$_SESSION ['aaa'] = '2';
	}
}
// if (!isset($_SESSION)) {
//     session_start();
// }
echo $_SESSION['aaa'];
?>