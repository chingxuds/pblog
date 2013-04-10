<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>首页</title>
<link href="/pblog/includes/jquery/jquery-ui.min.css" rel="stylesheet"
	type="text/css">
<script src="/pblog/includes/jquery/jquery.min.js"></script>
<script src="/pblog/includes/jquery/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#add").click(function(){
		formParam= $("#f1").serialize();
		alert(formParam);
		$.ajax({
			type:'post',        
			url:'/pblog/action/doterm.php',    
			data:"action=test&"+formParam,
			success:function(data){
				alert(data);
	      	}
		});
	});
});
</script>
</head>
<body>
	<div>
		<div id="f1">
			<input type="button" id="add" value="添加"> <input type="text" id="tag"
				name="tag_name">
			<ul>
				<li><label><input type="checkbox" name="tags[]" value="1" />#心情</label></li>
				<li><label><input type="checkbox" name="tags[]" value="2" />#心情</label></li>
				<li><label><input type="checkbox" name="tags[]" value="3" />#心情</label></li>
				<li><label><input type="checkbox" name="tags[]" value="4" />#心情</label></li>
			</ul>
		</div>
	</div>
	<div id="list">
		<ul>
			<li><label><input type="checkbox" />#心情</label></li>
		</ul>
	</div>
</body>
</html>