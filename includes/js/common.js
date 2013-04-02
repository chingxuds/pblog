function getCurrentFormatDate() {
	var d = new Date();
	return d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
}

$(window).scroll(function() {
  	$('#div_top_bar').css('top', $(document).scrollTop());
});

$(function() {
$( "#button_search" ).button();
$("#nav_menu_ul").buttonset();
});