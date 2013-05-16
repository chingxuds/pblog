<?php
require_once '../action/inc/session.php';
require_once '../action/inc/protect.php';
require_once '../action/dashboard.php';
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
	echo "<option value='" . $a ['id'] . "'>" . $str . $str2 . $a ['name'] . "</option>";
	if (isset($a ['child']) && is_array ( $a ['child'] )) {
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
<title>仪表盘</title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet"
	type="text/css">
<style type="text/css">
#dash_tabs {
	margin-left: 20px;
}

.like-button-text {
	height: 40px;
	line-height: 40px;
	width: 50px;
	margin: 0px;
}

.number a {
	text-decoration: none;
}

.number span {
	font-family: Georgia, "Times New Roman", "Bitstream Charter", Times,
		serif;
	color: rgb(33, 117, 155);
}
</style>
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
					height : '200px',
					resizeType : 0,
					cssPath : '/pblog/includes/kindeditor/plugins/code/prettify.css',
					uploadJson : '/pblog/includes/kindeditor/php/upload_json.php',
					fileManagerJson : '/pblog/includes/kindeditor/php/file_manager_json.php',
					allowFileManager : true,
					afterCreate : function() {// 实现Ctrl + Enter 发表
						var self = this;
						K.ctrl(document, 13, function() {
							self.sync();
							$("#post_date").val(getCurrentFormatDate());
							K('#form_post_submit')[0].submit();
						});
						K.ctrl(self.edit.doc, 13, function() {
							self.sync();
							$("#post_date").val(getCurrentFormatDate());
							K('#form_post_submit')[0].submit();
						});
					},
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link']
				});
			});
		</script>
<script>
			$(function() {
				$("#list").accordion();

				$("#dash_tabs").tabs();

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

				$("#post_submit").button();

				$("#post_submit").click(function() {
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
				<div id="dash_tabs" style="padding: 0;">
					<ul>
						<li><a href="#overview">概况</a></li>
						<li><a href="#quickpost">快速发布</a></li>
						<li><a href="#recentcom">近期评论</a></li>
					</ul>
					<div id="overview" class="number">
						<table style="width: 100%">
							<thead>
								<tr>
									<td width="50%"
										style="border-bottom: #DDDDDD solid 1px; color: #73767D">内容&nbsp;&nbsp;<span><?=$overview['post_num']+$overview['cat_num']?></span>&nbsp;个
									</td>
									<td width="50%"
										style="border-bottom: #DDDDDD solid 1px; color: #73767D">评论&nbsp;&nbsp;<span><?=$overview['app_num']+$overview['unapp_num']?></span>&nbsp;条
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="50%"><a
										href="/pblog/action/post.php?action=self_posts_overview"><span><?=$overview['post_num']?></span>&nbsp;<span
											style="color: #73767D">文章</span></a></td>
									<td width="50%"><a><span><?=$overview['app_num']?></span>&nbsp;<span
											style="color: #008000">获准</span></a></td>
								</tr>
								<tr>
									<td width="50%"><a><span><?=$overview['cat_num']?></span>&nbsp;<span
											style="color: #73767D">分类</span></a></td>
									<td width="50%"><a><span><?=$overview['unapp_num']?></span>&nbsp;<span
											style="color: #E66F00">待审</span></a></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div id="quickpost" style="padding: 0;">
						<form id="form_post_submit" action="/pblog/action/post.php"
							method="post">
							<input type="hidden" name="action" value="publish" /> <input
								type="hidden" id="post_date" name="post_date" />
							<header>
								<input type="text" class="input-text input-text-default"
									style="width: 100%; border-top-width: 0; margin: 0;"
									id="post_title" name="post_title" value="在此键入标题" />
							</header>
							<div>
								<textarea id="post_editor" name="post_content"
									style="width: 100%; height: 200px; margin: 0; border-style: solid; border-color: #CCCCCC; border-width: 0px 0px 1px 0px;"></textarea>
							</div>
							<br />
							<div style="float: left; margin: 0px; overflow: hidden;">
								<label><span
									class="ui-button ui-widget ui-state-default ui-corner-all like-button-text"
									style="border-width: 0px;">类别</span><select id="cat_select"
									name="post_cat"
									style="height: 30px; line-height: 30px; margin-right: -20px; margin-bottom: -10px; border: 0px; cursor: pointer;">
										<option value="0">未分类</option>
                                            <?php
																																												foreach ( $cats_arr [0] ['child'] as $key => $value ) {
																																													echo_cat_option ( $cats_arr [$key], '', $cats_arr );
																																												}
																																												?>
                                        </select></label>
							</div>
							<input type="button" id="post_submit"
								style="float: right; margin: 0px;" value="发布" />
						</form>
					</div>
					<div id="recentcom" class="global-a">
					<?php if(!$overview['recent_coms']){?>
						<div class="ui-state-highlight ui-corner-all post-lists"
							style="margin-top: 20px; padding: 0 .7em;">
							<p>
								<span class="ui-icon ui-icon-info"
									style="float: left; margin-right: .3em;"></span> <strong>近期没有评论</strong>
							</p>
						</div>
						<div class="global-a">
				<?php
					} else {
						foreach ( $overview ['recent_coms'] as $id => $com ) {
							?>
					<div class="ui-state-highlight ui-corner-all post-lists">
								<strong><span style="color: #0073EA;"><?=$com['author']?></span></strong><span style="font-size: 16px;">&nbsp;发表在&nbsp;</span><strong><a
									href="<?=$com['url']?>"><span><?=$com['title']?></span></a></strong><span style="font-size: 16px;">&nbsp;于&nbsp;<?=$com['date']?></span><span style="float: right;color: #0073EA;"><?=$com['status']?></span>
							</div>
					<?php }} ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
