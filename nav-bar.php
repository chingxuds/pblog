<?php
if (! isset ( $_SESSION ["isLogin"] )) {
	$_SESSION ["isLogin"] = FALSE;
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
					<form id="dologin" action="/pblog/action/douser.php" method="post">
						<input type="hidden" id="action" name="action" value="login" />
						<table>
							<tr>
								<td>用户名</td>
								<td><input type="text" name="username_input" id="username_input" />
								</td>
							</tr>
							<tr>
								<td>密码</td>
								<td><input type="password" name="userpass_input"
									id="userpass_input" /></td>
							</tr>
						</table>
					</form>
				</div>
				<div id="dialog_register" title="注册">

					<!-- 注册表单 -->
					<form id="doRegister" name="doRegister"
						action="/pblog/action/douser.php" method="post">
						<input type="hidden" id="action" name="action" value="register" />
						<input type="hidden" id="register_time" name="register_time" />
						<table>
							<tr>
								<td>用户名</td>
								<td><input type="text" name="username_input" id="username_input" />
								</td>
							</tr>
							<tr>
								<td>密码</td>
								<td><input type="password" name="userpass_input"
									id="userpass_input" /></td>
							</tr>
							<tr>
								<td>昵称</td>
								<td><input type="text" name="nicename_input" id="nicename_input" />
								</td>
							</tr>
							<tr>
								<td>邮箱</td>
								<td><input type="text" name="useremail_input"
									id="useremail_input" /></td>
							</tr>
						</table>
					</form>
				</div>
				<script>
		$(function(){
			
			// 创建对话框
			$( "#dialog_login" ).dialog({
				autoOpen: false,
				bgiframe: true,
				buttons: [
					{
						text: "登录",
						click: function() {
							$("#dologin").submit();
						}
					},
					{
						text: "注册",
						click: function() {
							$(this).dialog( "close" );
							$( "#dialog_register" ).dialog( "open" );
						}
					}
				]
			});

			$( "#dialog_register" ).dialog({
				autoOpen: false,
				bgiframe: true,
				buttons: [
					{
						text: "注册",
						click: function() {
							$("#register_time").val(getCurrentFormatDate());
							$("#doRegister").submit();
						}
					},
					{
						text: "取消",
						click: function() {
							$(this).dialog( "close" );
						}
					}
				]
			});

			// 打开对话框的链接
			$( "#dialog_link_login" ).click(function( event ) {
				$( "#dialog_login" ).dialog( "open" );
				event.preventDefault();
			});

		});
		</script>
<?php
} else {
?>
<div>
					<a href="/pblog/manage/?action=profile_view" title="查看个人资料"><span><?php echo $_SESSION["user"]["displayname"]?></span></a>
				</div>
				<div>
					<a href="#" title="N条回复"><span class="comments_icon">&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;25</span></a>
				</div>
				<div>
					<a href="/pblog/page/edit.php#div_content" title="撰写新文章"><span
						class="new_post_icon">&nbsp;&nbsp;&nbsp;&nbsp;</span><span>新建</span></a>
				</div>
				<div>
					<a href="/pblog/dashboard.php" title="仪表盘"><span>仪表盘</span></a>
				</div>
				<div>
					<a href="/pblog/action/douser.php?action=logout" title="退出登录"><span>登出</span></a>
				</div>
				<div style="display: block">&nbsp;</div>
<?php }?>
</nav>
		</div>
		<div id="div_topback" class="navbar">
			<a href="#topest" title="返回到页面顶端">&nbsp;回到顶部&nbsp;</a>
		</div>
	</div>
</div>