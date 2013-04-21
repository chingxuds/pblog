<?php
if (!isset($_SESSION["isLogin"])) {
    $_SESSION["isLogin"] = FALSE;
}
?>
<div id="div_top_bar" class="navbar-a">
	<div id="div_tool_bar">
		<div id="div_nav">
			<nav id="nav_user" class="navbar">
<?php
if (! $_SESSION ["isLogin"]) {
	?>
<div>
					<a href="#" id="dialog_link_login">登录</a>
				</div>
				<div style="display: block">&nbsp;</div>
				<div id="dialog_login" title="登录">
					<!-- 登录表单 -->
					<form id="dologin" action="/pblog/action/user.php" method="post">
						<input type="hidden" id="action" name="action" value="login" />
						<table>
							<tr>
								<td>用户名</td>
								<td><input type="text" class="justInput" name="username_input"
									id="username_input" /></td>
							</tr>
							<tr>
								<td>密&nbsp;&nbsp;&nbsp;码</td>
								<td><input type="password" class="justInput"
									name="userpass_input" id="userpass_input" /></td>
							</tr>
						</table>
						<span id="login_msg"
							style="font-size: 14px; color: rgb(255, 0, 132);"></span>
					</form>
				</div>
				<div id="dialog_register" title="注册" style="overflow: visible;">

					<!-- 注册表单 -->
					<form id="doRegister" name="doRegister"
						action="/pblog/action/user.php" method="post">
						<input type="hidden" id="action" name="action" value="register" />
						<input type="hidden" id="register_time" name="register_time" />
						<table>
							<tr>
								<td>用户名</td>
								<td><input type="text" class="justInput" name="username_input"
									id="reg_username_input" /></td>
								<td>*<span id="span_name" style="font-size: 14px;">6位以上的英文、数字字符</span></td>
							</tr>
							<tr>
								<td>密&nbsp;&nbsp;&nbsp;码</td>
								<td><input type="password" class="justInput"
									name="userpass_input" id="reg_userpass_input" /></td>
								<td>*<span id="span_pass" style="font-size: 14px;">6位以上字符</span></td>
							</tr>
							<tr>
								<td>确&nbsp;&nbsp;&nbsp;认</td>
								<td><input type="password" class="justInput"
									name="passcheck_input" id="reg_passcheck_input" /></td>
								<td>*<span id="span_check" style="font-size: 14px;">再次输入您的密码</span></td>
							</tr>
							<tr>
								<td>昵&nbsp;&nbsp;&nbsp;称</td>
								<td><input type="text" class="justInput" name="nicename_input"
									id="reg_nicename_input" /></td>
								<td>*<span id="span_nice" style="font-size: 14px;">起一个响亮的昵称吧</span></td>
							</tr>
							<tr>
								<td>邮&nbsp;&nbsp;&nbsp;箱</td>
								<td><input type="text" class="justInput" name="useremail_input"
									id="email_complete" /></td>
								<td>*<span id="span_email" style="font-size: 14px">请输入您的常用邮箱</span></td>
							</tr>
						</table>
					</form>
				</div>
				<script>
					$(function() {

						$("#dologin .justInput").keyup(function(event) {
							if (event.which == '13') {
								$("#login_msg").html("正在登录，请稍等...");
								data_str = "action=ajax_login&username=" + $('#username_input').val() + "&userpass=" + $('#userpass_input').val();
								$.ajax({
									type : 'post',
									url : '/pblog/action/user.php',
									data : data_str,
									success : function(data) {
										if (data) {
											$("#dologin").submit();
										} else {
											$("#login_msg").html("登录失败，请检查用户名与密码是否正确");
										}
									}
								});
							}
						});
						$("#doRegister .justInput").keyup(function(event) {
							if (event.which == '13') {
								var isOK = 5;

								if (0 == $("#reg_userpass_input").val().length) {
									$("#span_pass").html("密码不能为空");
									$("#span_pass").css("color", "rgb(255, 0, 132)");
								} else if (6 > $("#reg_userpass_input").val().length) {
									$("#span_pass").html("密码长度不足");
									$("#span_pass").css("color", "rgb(255, 0, 132)");
								} else if (!$("#reg_userpass_input").val().match(/^\S*$/)) {
									$("#span_pass").html("密码含有非法字符");
									$("#span_pass").css("color", "rgb(255, 0, 132)");
								} else {
									isOK--;
									$("#span_pass").html("通过");
									$("#span_pass").css("color", "rgb(0, 115, 234)");
								}

								if (0 == $("#reg_passcheck_input").val().length) {
									$("#span_check").html("密码不能为空");
									$("#span_check").css("color", "rgb(255, 0, 132)");
								} else if ($("#reg_passcheck_input").val() != $("#reg_userpass_input").val()) {
									$("#span_check").html("两次密码不一致");
									$("#span_check").css("color", "rgb(255, 0, 132)");
								} else {
									isOK--;
									$("#span_check").html("通过");
									$("#span_check").css("color", "rgb(0, 115, 234)");
								}

								if (0 == $("#reg_nicename_input").val().length) {
									$("#span_nice").html("昵称不能为空");
									$("#span_nice").css("color", "rgb(255, 0, 132)");
								} else {
									isOK--;
									$("#span_nice").html("通过");
									$("#span_nice").css("color", "rgb(0, 115, 234)");
								}

								if (0 == $("#email_complete").val().length) {
									$("#span_email").html("邮箱不能为空");
									$("#span_email").css("color", "rgb(255, 0, 132)");
								} else if (!$("#email_complete").val().match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/)) {
									$("#span_email").html("请输入有效的邮箱地址");
									$("#span_email").css("color", "rgb(255, 0, 132)");
								} else {
									isOK--;
									$("#span_email").html("通过");
									$("#span_email").css("color", "rgb(0, 115, 234)");
								}

								if (0 == $("#reg_username_input").val().length) {
									$("#span_name").html("用户名不能为空");
									$("#span_name").css("color", "rgb(255, 0, 132)");
								} else if (6 > $("#reg_username_input").val().length) {
									$("#span_name").html("用户名长度不足");
									$("#span_name").css("color", "rgb(255, 0, 132)");
								} else if (!$("#reg_username_input").val().match(/^[A-z0-9]*$/)) {
									$("#span_name").html("用户名含有非法字符");
									$("#span_name").css("color", "rgb(255, 0, 132)");
								} else {
									$("#span_name").html("正在检查，请稍等...");
									$("#span_name").css("color", "rgb(255, 0, 132)");
									data_str = "action=ajax_check_username&username=" + $('#reg_username_input').val();
									$.ajax({
										type : 'post',
										url : '/pblog/action/user.php',
										data : data_str,
										success : function(data) {
											if (data) {
												$("#span_name").html("用户名已存在");
												$("#span_name").css("color", "rgb(255, 0, 132)");
											} else {
												isOK--;
												$("#span_name").html("通过");
												$("#span_name").css("color", "rgb(0, 115, 234)");

												if (!isOK) {
													$("#register_time").val(getCurrentFormatDate());
													$("#doRegister").submit();
												}
											}
										}
									});
								}

							}
						});

						// 创建对话框
						$("#dialog_login").dialog({
							autoOpen : false,
							bgiframe : true,
							modal : true,
							closeOnEscape : true,
							closeText : "关闭",
							show : "puff",
							hide : "puff",
							resizable : false,
							buttons : [{
								text : "登录",
								click : function() {
									data_str = "action=ajax_login&username=" + $('#username_input').val() + "&userpass=" + $('#userpass_input').val();
									$.ajax({
										type : 'post',
										url : '/pblog/action/user.php',
										data : data_str,
										success : function(data) {
											if (data) {
												$("#dologin").submit();
											} else {
												$("#login_msg").html("登录失败，请检查用户名与密码是否正确");
											}
										}
									});
								}
							}, {
								text : "注册",
								click : function() {
									$(this).dialog("close");
									$("#dialog_register").dialog("open");
								}
							}]
						});

						$("#dialog_register").dialog({
							autoOpen : false,
							bgiframe : true,
							modal : true,
							closeOnEscape : true,
							closeText : "关闭",
							show : "puff",
							hide : "puff",
							resizable : false,
							width : 500,
							buttons : [{
								text : "注册",
								click : function() {
									var isOK = 5;

									if (0 == $("#reg_userpass_input").val().length) {
										$("#span_pass").html("密码不能为空");
										$("#span_pass").css("color", "rgb(255, 0, 132)");
									} else if (6 > $("#reg_userpass_input").val().length) {
										$("#span_pass").html("密码长度不足");
										$("#span_pass").css("color", "rgb(255, 0, 132)");
									} else if (!$("#reg_userpass_input").val().match(/^\S*$/)) {
										$("#span_pass").html("密码含有非法字符");
										$("#span_pass").css("color", "rgb(255, 0, 132)");
									} else {
										isOK--;
										$("#span_pass").html("通过");
										$("#span_pass").css("color", "rgb(0, 115, 234)");
									}

									if (0 == $("#reg_passcheck_input").val().length) {
										$("#span_check").html("密码不能为空");
										$("#span_check").css("color", "rgb(255, 0, 132)");
									} else if ($("#reg_passcheck_input").val() != $("#reg_userpass_input").val()) {
										$("#span_check").html("两次密码不一致");
										$("#span_check").css("color", "rgb(255, 0, 132)");
									} else {
										isOK--;
										$("#span_check").html("通过");
										$("#span_check").css("color", "rgb(0, 115, 234)");
									}

									if (0 == $("#reg_nicename_input").val().length) {
										$("#span_nice").html("昵称不能为空");
										$("#span_nice").css("color", "rgb(255, 0, 132)");
									} else {
										isOK--;
										$("#span_nice").html("通过");
										$("#span_nice").css("color", "rgb(0, 115, 234)");
									}

									if (0 == $("#email_complete").val().length) {
										$("#span_email").html("邮箱不能为空");
										$("#span_email").css("color", "rgb(255, 0, 132)");
									} else if (!$("#email_complete").val().match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/)) {
										$("#span_email").html("请输入有效的邮箱地址");
										$("#span_email").css("color", "rgb(255, 0, 132)");
									} else {
										isOK--;
										$("#span_email").html("通过");
										$("#span_email").css("color", "rgb(0, 115, 234)");
									}

									if (0 == $("#reg_username_input").val().length) {
										$("#span_name").html("用户名不能为空");
										$("#span_name").css("color", "rgb(255, 0, 132)");
									} else if (6 > $("#reg_username_input").val().length) {
										$("#span_name").html("用户名长度不足");
										$("#span_name").css("color", "rgb(255, 0, 132)");
									} else if (!$("#reg_username_input").val().match(/^[A-z0-9]*$/)) {
										$("#span_name").html("用户名含有非法字符");
										$("#span_name").css("color", "rgb(255, 0, 132)");
									} else {
										$("#span_name").html("正在检查，请稍等...");
										$("#span_name").css("color", "rgb(255, 0, 132)");
										data_str = "action=ajax_check_username&username=" + $('#reg_username_input').val();
										$.ajax({
											type : 'post',
											url : '/pblog/action/user.php',
											data : data_str,
											success : function(data) {
												if (data) {
													$("#span_name").html("用户名已存在");
													$("#span_name").css("color", "rgb(255, 0, 132)");
												} else {
													isOK--;
													$("#span_name").html("通过");
													$("#span_name").css("color", "rgb(0, 115, 234)");

													if (!isOK) {
														$("#register_time").val(getCurrentFormatDate());
														$("#doRegister").submit();
													}
												}
											}
										});
									}
								}
							}, {
								text : "取消",
								click : function() {
									$(this).dialog("close");
								}
							}]
						});

						// 打开对话框的链接
						$("#dialog_link_login").click(function(event) {
							$("#dialog_login").dialog("open");
							event.preventDefault();
						});

					});
		</script>
<?php
} else {
	?>
<div>
					<a href="/pblog/manage/?action=profile_view" title="查看个人资料"><span><?=$_SESSION["user"]["displayname"] ?></span></a>
				</div>
				<div>
				<?php
	$com_uap = application ( "comment_unapproved" );
	if (isset($com_uap [$_SESSION ['user'] ['id']])) {
		?>
					<a href="/pblog/manage/?action=comment_unapproved_view"
						title="<?=$com_uap[$_SESSION['user']['id']] ?>条回复"><span
						class="comments_icon">&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;<?=$com_uap[$_SESSION['user']['id']] ?></span></a>
				<?php }else{ ?>
				<a href="#" title="0条回复"><span class="comments_icon">&nbsp;&nbsp;&nbsp;&nbsp;</span></a><?php } ?></div>
				<div>
					<a href="/pblog/manage/post-new.php" title="撰写新文章"><span
						class="new_post_icon">&nbsp;&nbsp;&nbsp;&nbsp;</span><span>新建</span></a>
				</div>
				<div>
					<a href="/pblog/manage/dashboard.php" title="仪表盘"><span>仪表盘</span></a>
				</div>
				<div>
					<a href="/pblog/action/user.php?action=logout" title="退出登录"><span>登出</span></a>
				</div>
				<div style="display: block">&nbsp;</div>
<?php } ?>
</nav>
		</div>
		<div id="div_topback" class="navbar">
			<a href="#topest" title="返回到页面顶端">&nbsp;回到顶部&nbsp;</a>
		</div>
	</div>
</div>