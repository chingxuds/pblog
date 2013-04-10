<?php
// ** 文本加密 ** //

/** 加密方式前缀 MD5 */
define('CODE_PREFIX_MD5', '$1$');

/** 加密方式前缀 替换 */
define('CODE_PREFIX_REPLACE', '$P$');

/** 加密函数 MD5
 * @param $text 文本明文
 * @return string 文本密文
 */
function code_md5($text = 'NULL') {
    $text_coded = crypt($text, CODE_PREFIX_MD5 . md5($text));
    return str_replace(CODE_PREFIX_MD5, CODE_PREFIX_REPLACE, $text_coded);
}

/**
 * 加密函数 短风格
 * @param string $text 文本明文
 * @param string $salt 加密盐值（"./0-9A-Za-z"字符中的两个字符）
 * @return string 文本密文
 */
function code_short($text = 'NULL',$salt = 'an'){
	return crypt($text,$salt);
}
?>
