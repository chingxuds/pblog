<?php
require '../action/inc/session.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>首页</title>
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
});
</script>
</head>

<body>
	<div id="topest"></div>
	<div id="div_top_bar" class="navbar-a">
		<div id="div_tool_bar">
			<div id="div_nav">
				<nav id="nav_user" class="navbar">
                            <?php include '../nav-bar.php';?>
			 </nav>
			</div>
			<div id="div_topback" class="navbar">
				<a href="#topest">&nbsp;回到顶部&nbsp;</a>
			</div>
		</div>
	</div>
	<div id="div_container">
		<div id="div_header">
			<header id="header">
				<hgroup id="hgroup">
					<h1>个人博客网</h1>
					<H4>用来完成毕设的个人博客网站</H4>
				</hgroup>
				<nav id="nav_menu" style="float: none">
					<ul id="nav_menu_ul">
						<li><a href="#div_content">首页</a></li>
						<li><a href="#div_content">心情</a></li>
						<li><a href="#div_content">文章列表</a></li>
						<li><a href="#div_content">类别列表</a></li>
					</ul>
				</nav>
			</header>
		</div>
		<div id="div_main">
			<div id="div_sider" class="global-a">
				<div id="div_search">
					<input type="button" id="button_search" value="搜索" /> <input
						type="text" id="text_search" name="search_title" />
				</div>
				<div id="list" class="global-a">
					<h4 id="user-man-h">个人管理</h4>
					<div id="user-man-d">
						<ul>
							<li><a href="#">查看</a></li>
							<li><a href="#">增加</a></li>
							<li><a href="#">改变</a></li>
							<li><a href="#">删除</a></li>
						</ul>
					</div>
					<h4 id="post-man-h">文章管理</h4>
					<div id="post-man-d">
						<ul>
							<li><a href="#">查看</a></li>
							<li><a href="#">增加</a></li>
							<li><a href="#">改变</a></li>
							<li><a href="#">删除</a></li>
						</ul>
					</div>
					<h4 id="com-man-h">评论管理</h4>
					<div id="com-man-d">
						<ul>
							<li><a href="#">查看</a></li>
							<li><a href="#">增加</a></li>
							<li><a href="#">改变</a></li>
							<li><a href="#">删除</a></li>
						</ul>
					</div>
					<h4 id="type-man-h">类别管理</h4>
					<div id="type-man-d">
						<ul>
							<li><a href="#">查看</a></li>
							<li><a href="#">增加</a></li>
							<li><a href="#">改变</a></li>
							<li><a href="#">删除</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div id="div_content" class="global-a">
				<div class="manage-content-style">
					<form id="profile_update" action="/pblog/action/douser.php"
						method="post">
						<input type="hidden" name="action" value="profile_update" />
						<table>
							<tr>
								<td><span>姓</span></td>
								<td><input type="text" id="lastname" name="lastname-unchange"
									value="<?php echo isset($_SESSION["user_profile"]['lastname'])?$_SESSION["user_profile"]['lastname']:""  ?>" /></td>
							</tr>
							<tr>
								<td><span>名</span></td>
								<td><input type="text" id="firstname" name="firstname-unchange"
									value="<?php echo isset($_SESSION["user_profile"]['firstname'])?$_SESSION["user_profile"]['firstname']:""  ?>" /></td>
							</tr>
							<tr>
								<td><span>昵称</span></td>
								<td><input type="text" id="nicename" name="nicename-unchange"
									value="<?php echo isset($_SESSION["user_profile"]['nicename'])?$_SESSION["user_profile"]['nicename']:""  ?>" /></td>
							</tr>
							<tr>
								<td><span>显示名</span></td>
								<td><select id="displayname" name="displayname-unchange">
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
								<td><span>邮箱</span></td>
								<td><input type="text" id="email" name="email-unchange"
									value="<?php echo isset($_SESSION["user_profile"]['email'])?$_SESSION["user_profile"]['email']:""  ?>" /></td>
							</tr>
							<tr>
								<td><span>电话</span></td>
								<td><input type="text" id="tel" name="tel-unchange"
									value="<?php echo isset($_SESSION["user_profile"]['tel'])?$_SESSION["user_profile"]['tel']:""  ?>" /></td>
							</tr>
						</table>
						<input type="button" id="button_update" value="更新" />
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
