<?php
require_once '../action/inc/session.php';
require_once '../action/inc/protect.php';
$cats_arr = application ( 'categories' );

/**
 * 显示类别选择项函数
 *
 * @param array $a
 *        	当前数组
 * @param string $str
 *        	修饰字符串
 * @param array $arr
 *        	原始数组
 */
function echo_cat_option($a, $str = '', $arr) {
	if ($str != '')
		$str2 = "└";
	if ($_SESSION ["edit_post"] ['category'] == $a ['id']) {
		echo "<option selected='selected' value='" . $a ['id'] . "'>" . $str . $str2 . $a ['name'] . "</option>";
	} else {
		echo "<option value='" . $a ['id'] . "'>" . $str . $str2 . $a ['name'] . "</option>";
	}
	if (is_array ( $a ['child'] )) {
		$str .= "&nbsp;";
		foreach ( $a ['child'] as $key => $value ) {
			echo_cat_option ( $arr [$key], $str, $arr );
		}
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>修改文章</title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet"
	type="text/css">
<script src="/pblog/includes/jquery/jquery.min.js"></script>
<script src="/pblog/includes/jquery/jquery-ui.min.js"></script>
<script src="/pblog/includes/js/common.js"></script>
<script charset="utf-8"
	src="/pblog/includes/kindeditor/kindeditor-all-min.js"></script>
<script charset="utf-8" src="/pblog/includes/kindeditor/lang/zh_CN.js"></script>
<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('#post_editor', {
					width : '100%',
					height : '450px',
					resizeType : 0,
					cssPath : '/pblog/includes/kindeditor/plugins/code/prettify.css',
					uploadJson : '/pblog/includes/kindeditor/php/upload_json.php',
					fileManagerJson : '/pblog/includes/kindeditor/php/file_manager_json.php',
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

			$(function() {

				$("#list").accordion({
					active : 2
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

				$("#tabs").tabs();

				$("#cat_add_button,#post_submit_button").button();

				$("#cat_add_button").click(function() {
					cname = $("#cat_name").val();
					cparent = $("#cat_parent").val();
					data_str = "action=ajax_cat_add&cat_name=" + cname + "&cat_parent=" + cparent;
					$.ajax({
						type : 'post',
						url : '/pblog/action/term.php',
						data : data_str,
						success : function(data) {
							if (!data) {
								alert("添加失败");
							} else {
								alert(data);
								obj = json_to_object(data);
								if (obj.pcount == 0) {
									option_str = "<option value='" + obj.id + "'>" + obj.name + "</option>";
									$("#cat_select").append(option_str);
									$("#cat_parent").append(option_str);
								} else {
									var pre_nbsp = "";
									while (obj.pcount--) {
										pre_nbsp += "&nbsp;";
									}
									option_str = "<option value='" + obj.id + "'>" + pre_nbsp + "└" + obj.name + "</option>";
									$("#cat_select option[value='" + obj.parent + "']").after(option_str);
									$("#cat_parent option[value='" + obj.parent + "']").after(option_str);
								}
							}
						}
					});
				});

				$("#post_submit_button").click(function() {
					editor.sync();
					$("#post_date").val(getCurrentFormatDate());
					$("#form_post_submit").submit();
				});

			});
        </script>
</head>

<body>
	<div id="topest"></div>
        <?php
								require_once '../nav-bar.php';
								?>
        <div id="div_container">
            <?php
												require_once '../header.php';
												?>
            <div id="div_main">
			<div id="div_sider" class="global-a">
                    <?php
																				require_once '../siderbar-manage.php';
																				?>
                </div>
			<div id="div_content">
				<form id="form_post_submit" action="/pblog/action/post.php"
					method="post">
					<input type="hidden" name="action" value="update" /> 
					<input type="hidden" name="post_id" value="<?=$_SESSION['edit_post']['id']?>" /> 
					<input type="hidden" id="post_date" name="post_date" />
					<div id="tabs" class="manage-content-style">
						<ul>
							<li><a href="#new_post">撰写文章</a></li>
							<li><a href="#add_category">修改类别</a></li>
							<li style="float: right; margin: 0;"><input type="button"
								id="post_submit_button" value="更新" /></li>
						</ul>
						<div class="global-a">
							<div id="new_post" style="padding: 0;">
								<header>
									<input type="text" class="input-text"
										style="width: 100%; border-top-width: 0;" id="post_title"
										name="post_title" value="<?=$_SESSION['edit_post']['title']?> " />
								</header>
								<div>
									<textarea id="post_editor" name="post_content"><?=$_SESSION['edit_post']['content']?></textarea>
								</div>

							</div>
							<div id="add_category">
								<header>
									<p>为你的文章选择一个类别</p>
								</header>
								<div>
									<select id="cat_select" name="post_cat">
										<option value="0">未分类</option>
                                        <?php
											foreach ( $cats_arr [0] ['child'] as $key => $value ) {
												echo_cat_option ( $cats_arr [$key], '', $cats_arr );
											}
										?>
                                        </select>
								</div>
								<div>
									<p>添加新类别</p>
									<input type="button" class="post-button-style"
										id="cat_add_button" value="添加" /> <input type="text"
										id="cat_name" class="post-input-style" /> <br />
									<p>
										<span>父类别：</span> <select id="cat_parent">
											<option value="0">未分类</option>
                                                <?php
																																																foreach ( $cats_arr [0] ['child'] as $key => $value ) {
																																																	echo_cat_option ( $cats_arr [$key], '', $cats_arr );
																																																}
																																																?>
                                            </select>
									</p>
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
