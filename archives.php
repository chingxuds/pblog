<?php
require_once 'action/inc/session.php';
require_once 'action/initialize.php';
$lists = application('archives');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>归档列表</title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<link href="/pblog/includes/css/common.css" rel="stylesheet"
	type="text/css">
<style type="text/css">
	.post-lists {
		margin-top: 5px;
		margin-left: 20px;
		padding: 5px;
	}
</style>
<script src="/pblog/includes/jquery/jquery.min.js"></script>
<script src="/pblog/includes/jquery/jquery-ui.min.js"></script>
<script src="/pblog/includes/js/common.js"></script>
<script type="text/javascript">
	$(function() {

	});
        </script>
</head>

<body>
	<div id="topest"></div>
     <?php
        require_once 'nav-bar.php';
    ?>
	<div id="div_container">
		<?php
        require_once 'header.php';
    ?>
		<div id="div_main">
			<?php
            require_once 'siderbar-list.php';
        ?>
			<div id="div_content">
				<!-- 					<div class="ui-state-highlight ui-corner-all post-lists" 
						style="margin-top: 20px; padding: 0 .7em;">
 						<p> 
 							<span class="ui-icon ui-icon-info" 
								style="float: left; margin-right: .3em;"></span> <strong><?=$_SESSION['search_info']?></strong>
						</p> 
 					</div> -->
				<div class="global-a">
				<?php
				foreach ( $lists as $index => $arc ) {
					?>
					<div class="ui-state-highlight ui-corner-all post-lists">
						<strong><a href="/pblog/action/search.php?action=archive_view_date&year=<?=$archive['year'] ?>&month=<?=$archive['month'] ?> "><?=$arc['date'] ?></a></strong>
						<span style="float: right">有&nbsp;<?=$arc['count'] ?>&nbsp;篇文章</span>
					</div>
					<?php } ?></div>
			</div>
		</div>
	</div>
	<?php
        include_once 'footer.php';
 ?>


</body>
</html>
<?php
unset($lists);
?>