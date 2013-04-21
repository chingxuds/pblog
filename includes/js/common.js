// 全局js代码
function getCurrentFormatDate() { // 获取当前时间函数
	var d = new Date();
	return d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
}

function json_to_object (text) { // json格式化为js对象函数
  return eval("(" + text + ")");
}

// 全局jQuery代码
$(function() {
	
$( "#button_search" ).button();

$("#nav_menu_ul").buttonset();

$("#email_complete").focus(function(){
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
						$("#email_complete").autocomplete({
				    		source: email_tags
						});
					}
				});
			});

});