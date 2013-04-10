<?php
// ** 若会话未开启，则开启之 ** //
if (session_status () == PHP_SESSION_NONE) {
	session_start ();
}

function get_parameter_once($name){
	return isset ( $_POST [$name] ) ? $_POST [$name] : (isset ( $_GET [$name] ) ? $_GET [$name] : FALSE);
}
?>