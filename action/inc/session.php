<?php
// ** 若会话未开启，则开启之 ** //
if (session_status () == PHP_SESSION_NONE) {
	session_start ();
}
?>