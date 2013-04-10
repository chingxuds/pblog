<?php
require '../action/inc/session.php';
require '../action/inc/protect.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>编辑个人资料</title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet"
	type="text/css">
<script src="/pblog/includes/jquery/jquery.min.js"></script>
<script src="/pblog/includes/jquery/jquery-ui.min.js"></script>
<script src="/pblog/includes/js/common.js"></script>
<script>
$(function() {
		
		$( "#list" ).accordion({ active: 0 });
		
		$("#type a[text='asd']").addClass("");

     	

		$("#displayname").val('<?php echo $_SESSION['user']['displayname']?>');

		$("#button_update").button();

		$("#button_update").click(function(){
			$("#profile_update").submit();
		});

		$("#lastname,#firstname,#nicename,#displayname,#email,#tel").change(function(){
			$("#"+this.id).attr("name",this.id);
			
			if(this.id=="lastname"||this.id=="firstname"||this.id=="nicename"){
				$("#displayname").empty();
				var ln = $("#lastname").val();
				var fn = $("#firstname").val();
				var nn = $("#nicename").val();
				$("#displayname").append("<option value='"+nn+"'>"+nn+"</option>");
				$("#displayname").append("<option value='"+ln+"'>"+ln+"</option>");
				$("#displayname").append("<option value='"+fn+"'>"+fn+"</option>");
				$("#displayname").append("<option value='"+fn+" "+ln+"'>"+fn+" "+ln+"</option>");
				$("#displayname").append("<option value='"+ln+" "+fn+"'>"+ln+" "+fn+"</option>");
				$("#displayname").attr("name","displayname");
			}

		});

			$("#email").focus(function(){
				$(this).keypress(function(event){
// 					var reg = /^@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
					var email_title = $(this).val();
					if(email_title.match(/@[^]*$/,email_title)){
						email_title = email_title.replace(/@[^]*$/,"");
						var email_tags= [
			         			email_title+"@gmail.com",
			         			email_title+"@qq.com",
			         			email_title+"@sina.com",
			         			email_title+"@163.com",
			         			email_title+"@126.com",
			         			email_title+"@yeah.net",
			         			email_title+"@yahoo.com",
			         			email_title+"@live.cn",
			         			email_title+"@live.com",
			         			email_title+"@hotmail.com",
			         			email_title+"@icloud.com"
			         			];
						$("#email").autocomplete({
				    		source: email_tags
						});
					}
				});
			});
});
</script>
</head>

<body>
	<div id="topest"></div>
     <?php include '../nav-bar.php';?>
	<div id="div_container">
		<?php include '../header.php';?>
		<div id="div_main">
			<div id="div_sider" class="global-a">
				<?php include '../siderbar-manage.php';?>
			</div>
			<div id="div_content" class="global-a">
				<div class="manage-content-style">
					<form id="profile_update" action="/pblog/action/douser.php"
						method="post">
						<input type="hidden" name="action" value="profile_update" />
						<table>
							<tr>
								<td class="input-label" style="width: 100px"><span>姓</span></td>
								<td><input type="text" class="input-text" style="width: 400px;"
									id="lastname" name="lastname-unchange"
									value="<?php echo isset($_SESSION["user_profile"]['lastname'])?$_SESSION["user_profile"]['lastname']:""  ?>" /></td>
							</tr>
							<tr>
								<td class="input-label" style="width: 100px"><span>名</span></td>
								<td><input type="text" class="input-text" style="width: 400px;"
									id="firstname" name="firstname-unchange"
									value="<?php echo isset($_SESSION["user_profile"]['firstname'])?$_SESSION["user_profile"]['firstname']:""  ?>" /></td>
							</tr>
							<tr>
								<td class="input-label" style="width: 100px"><span>昵称</span></td>
								<td><input type="text" class="input-text" style="width: 400px;"
									id="nicename" name="nicename-unchange"
									value="<?php echo isset($_SESSION["user_profile"]['nicename'])?$_SESSION["user_profile"]['nicename']:""  ?>" /></td>
							</tr>
							<tr>
								<td class="input-label" style="width: 100px"><span>显示名</span></td>
								<td><select class="input-text" style="width: 408px;"
									id="displayname" name="displayname-unchange">
							<?php
							$ln = FALSE;
							$fn = FALSE;
							if (isset ( $_SESSION ["user_profile"] ['nicename'] )) {
								$value = $_SESSION ["user_profile"] ['nicename'];
								echo "<option value='$value'>" . $value . "</option>";
							}
							if (isset ( $_SESSION ['user_profile'] ['firstname'] )) {
								$value = $_SESSION ['user_profile'] ['firstname'];
								echo "<option value='$value'>" . $value . "</option>";
								$ln = TRUE;
							}
							if (isset ( $_SESSION ['user_profile'] ['lastname'] )) {
								$value = $_SESSION ['user_profile'] ['lastname'];
								echo "<option value='$value'>" . $value . "</option>";
								$fn = TRUE;
							}
							if ($ln & $fn) {
								$value = $_SESSION ['user_profile'] ['firstname'] . ' ' . $_SESSION ['user_profile'] ['lastname'];
								echo "<option value='$value'>" . $value . "</option>";
								$value = $_SESSION ['user_profile'] ['lastname'] . ' ' . $_SESSION ['user_profile'] ['firstname'];
								echo "<option value='$value'>" . $value . "</option>";
							}
							?>
							</select></td>
							</tr>
							<tr>
								<td class="input-label" style="width: 100px"><span>邮箱</span></td>
								<td><input type="text" class="input-text" style="width: 400px;"
									id="email" name="email-unchange"
									value="<?php echo isset($_SESSION["user_profile"]['email'])?$_SESSION["user_profile"]['email']:""  ?>" /></td>
							</tr>
							<tr>
								<td class="input-label" style="width: 100px"><span>电话</span></td>
								<td><input type="text" class="input-text" style="width: 400px;"
									id="tel" name="tel-unchange"
									value="<?php echo isset($_SESSION["user_profile"]['tel'])?$_SESSION["user_profile"]['tel']:""  ?>" /></td>
							</tr>
							<tr>
								<td colspan="2"><input type="button" style="width: 103px;"
									id="button_update" value="更新" /></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
