<?php
require '../action/inc/session.php';
require '../action/inc/protect.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>撰写新文章</title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet"
	type="text/css">
<script src="/pblog/includes/jquery/jquery.min.js"></script>
<script src="/pblog/includes/jquery/jquery-ui.min.js"></script>
<script src="/pblog/includes/js/common.js"></script>
<script charset="utf-8"
	src="../includes/kindeditor/kindeditor-all-min.js"></script>
<script charset="utf-8" src="../includes/kindeditor/lang/zh_CN.js"></script>
<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('#post_editor', {
					width : '100%',
					height: '450px',
					resizeType: 0,
					cssPath : '../includes/kindeditor/plugins/code/prettify.css',
					uploadJson : '../includes/kindeditor/php/upload_json.php',
					fileManagerJson : '../includes/kindeditor/php/file_manager_json.php',
					allowFileManager : true,
					afterCreate : function() {// 实现Ctrl + Enter 发表
						var self = this;
						K.ctrl(document, 13, function() {
							self.sync();
							K('#doPublish')[0].submit();
						});
						K.ctrl(self.edit.doc, 13, function() {
							self.sync();
							K('#doPublish')[0].submit();
						});
					}
				});
			});
        </script>
<script>
			$(function() {

				$("#list").accordion({
					active : 1
				});

				$("#post_title").focus(function() {
					if ($(this).val() == "在此键入标题") {
						$(this).removeClass("input-text-default");
						$(this).val("");
					}
				});

				$("#post_title").blur(function() {
					if ($(this).val() == "") {
						$(this).addClass("input-text-default");
						$(this).val("在此键入标题");
					}
				});

				$( "#tabs" ).tabs();

				$("#tag_add_button,#post_submit_button").button();

// 				$("#tags_list_ul li label").hover(function(){
// 					$(this).addClass("tags-hover");
// 				},
// 				function(){
// 					$(this).removeClass("tags-hover");
// 				});

// 				$("#tags_list_ul li label").mousedown(function(){
// 					 if ( !$(this).hasClass("tags-checked") ){
// 						 $(this).addClass("tags-checked");
// 					 }else{
// 						 $(this).removeClass("tags-checked");
// 					 }
// 				});

				$("#tag_add_button").click(function(){
					tname = $("#tag_name").val();
					if(!$("#tags_"+tname).val()){
					data_str = "action=ajax_tag_add&tag_name=" + tname;
					$.ajax({
						type:'post',        
						url:'/pblog/action/doterm.php',    
						data:data_str,
						success:function(data){
							if(!data){
								alert("添加失败");
							}else{
								obj = json_to_object(data);
								li_str = "<li><label><input type='checkbox' id='tags_"+obj.name+"' name='tags[]' value='"+obj.id+"' /><a>#"+obj.name+"</a></label></li>";
								$("#tags_list_ul").append(li_str);
							}
				      	}
					});
					}else{
						alert("标签已存在");
					}
				});

				$("#tag_common").click(function(){
					$("#tags_commont_ul").empty();
					data_str = "action=ajax_tag_common";
					$.ajax({
						type:'post',        
						url:'/pblog/action/doterm.php',    
						data:data_str,
						success:function(data){
							if(!data){
								alert("查询失败");
							}else{
								obj = json_to_object(data);
								for(i=0;i<obj.length;i++){
									li_str = "<li><label><input type='checkbox' id='tags_"+obj[i].name+"' name='tags[]' value='"+obj[i].id+"' /><a>#"+obj[i].name+"</a></label></li>";
									$("#tags_commont_ul").append(li_str);
								}
							}
				      	}
					});
				});
				
			});
        </script>
</head>

<body>
	<div id="topest"></div>
        <?php include '../nav-bar.php';	?>
        <div id="div_container">
		<?php include '../header.php';?>
		<div id="div_main">
			<div id="div_sider" class="global-a">
                    <?php include '../siderbar-manage.php';?>
                </div>
			<div id="div_content">
				<form id="form_post_submit" action="pblog/action/dopost" method="post">
				<input type="hidden" name="action" value="" />
					<div id="tabs" class="manage-content-style">
						<ul>
							<li><a href="#new_post">撰写文章</a></li>
							<li><a href="#add_category">添加类别</a></li>
							<li><a href="#add_tags">添加标签</a></li>
							<li style="float: right;margin: 0;"><input type="button" id="post_submit_button" value="发表" /></li>
						</ul>
						<div class="global-a">
							<div id="new_post" style="padding: 0;">
								<header>
									<input type="text" class="input-text input-text-default"
										style="width: 100%; border-top-width: 0;" id="post_title"
										name="post_title_unchange" value="在此键入标题" />
								</header>
								<div>
									<textarea id="post_editor" name="post_editor"></textarea>
								</div>

							</div>
							<div id="add_category">
								<header><p>为你的文章选择一个类别</p></header>
								<div>
									<select>
										<option>心情</option>
										<option>└─心情</option>
										<option>心情</option>
										<option>心情</option>
										<option>心情</option>
									</select>
								</div>
							</div>
							<div id="add_tags">
								<header><p>为你的文章添加几个标签</p></header>
								<div>
									<input type="button" class="post-button-style"
										id="tag_add_button" value="添加" /> <input type="text"
										id="tag_name" class="post-input-style" />
								</div>
								<div class="add-tags-list">
									<ul id="tags_list_ul">
									</ul>
								</div>
								<div>
									<a id="tag_common">查看热门标签</a>
								</div>
								<div class="add-tags-list">
									<ul id="tags_commont_ul">
									</ul>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
