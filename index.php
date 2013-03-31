<?php
// ** 若会话未开启，则开启之 ** //
if (session_status () == PHP_SESSION_NONE) {
	session_start ();
	if (! isset ( $_SESSION ["isLogin"] )) {
		$_SESSION ["isLogin"] = FALSE;
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>个人博客网</title>
<link href="./includes/jquery/jquery-ui.min.css" rel="stylesheet">
<script src="./includes/jquery/jquery.min.js"></script>
<script src="./includes/jquery/jquery-ui.min.js"></script>
<script>
			$(function() {

				$("#date_picker").datepicker({
					inline : true
				});

			});
        </script>
</head>
<body>
        <?php
								if ($_SESSION ["isLogin"] === TRUE) {
									?>
        <h1>登陆成功</h1>
	<h3><?=$_SESSION["user"]["id"]?></h3>
	<h3><?=$_SESSION["user"]["displayname"]?></h3>
	<h3><?=$_SESSION["user"]["status"]?></h3>
        <?php
								} else {
									?>
        <!-- 登录表单 -->
	<form action="./action/douser.php" method="post">
		<input type="hidden" id="action" name="action" value="login" />
		<table>
			<tr>
				<td>用户名</td>
				<td><input type="text" name="username_input" id="username_input" />
				</td>
			</tr>
			<tr>
				<td>密码</td>
				<td><input type="password" name="userpass_input" id="userpass_input" />
				</td>
			</tr>
		</table>
		<input type="submit" value="登录" /> <input type="reset" value="重置" /> <a
			href="./register.html">注册</a>
	</form>
        <?php
								}
								?>
        <hr />
	<input type="text" name="date_picker" id="date_picker" />
</body>
</html>
