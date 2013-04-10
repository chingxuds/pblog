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

});