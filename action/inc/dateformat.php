<?php
// ** 时间格式化 ** //

/** 默认时间格式 
 * 0000-00-00 00:00:00 */
define('DATE_FORMAT_DEFAULT', 'Y-m-d H:i:s');

/** 时间格式化函数
 * 传入参数为秒数
 * 返回默认时间格式
 */
function dateFormat($time='0')
{
	return date(DATE_FORMAT_DEFAULT,$time);
}
?>