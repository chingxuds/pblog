<?php
require_once 'action/inc/session.php';
require_once 'action/inc/protect.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>标签管理</title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet"
	type="text/css">
<script src="/pblog/includes/jquery/jquery.min.js"></script>
<script src="/pblog/includes/jquery/jquery-ui.min.js"></script>
<script src="/pblog/includes/js/common.js"></script>
<script>
			$(function() {
				$("#list").accordion({
					active : 4
				});
			});
        </script>
</head>

<body>
	<div id="topest"></div>
        <?php require_once '../nav-bar.php';	?>
        <div id="div_container">
		<?php require_once '../header.php';?>
		<div id="div_main">
			<div id="div_sider" class="global-a">
                    <?php require_once '../siderbar-manage.php';?>
                </div>
			<div id="div_content"></div>
		</div>
	</div>
</body>
</html>
