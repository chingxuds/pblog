<?php
if (! isset ( $_SESSION ["isLogin"] )) {
	$_SESSION ["isLogin"] = FALSE;
}
if (! $_SESSION ["isLogin"]) {
	?>
<div>
	<a href="#" id="dialog_link_login">登录</a>
</div>
<div style="display: block">&nbsp;</div>
<div id="dialog_login" title="登录">
	<!-- 登录表单 -->
	<form id="dologin" action="./action/douser.php" method="post">
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
	</form>
</div>
<script>
		$(function(){
			$( "#dialog_login" ).dialog({
				autoOpen: false,
				bgiframe: true,
				dialogClass: '',
				width: 400,
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
							location.href="register.html";
						}
					}
				]
			});

			// Link to open the dialog
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
	<a href="#"><?php echo $_SESSION["user"]["displayname"]?></a>
</div>
<div>
	<a href="#"><span class="comments_icon">&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp;&nbsp;25</span></a>
</div>
<div>
	<a href="#">写文章</a>
</div>
<div>
	<a href="action/douser.php?action=logout">登出</a>
</div>
<div style="display: block">&nbsp;</div>
<?php }?>
		