<?php
// ** 文本加密 ** //

/** 加密方式前缀 MD5 */
define('CODE_PREFIX_MD5', '$1$');

/** 加密方式前缀 替换 */
define('CODE_PREFIX_REPLACE', '$P$');

/** 加密函数 MD5,传入文本,返回加密文本
 * @param $text
 */
function code_md5($text = 'NULL') {
    $text_coded = crypt($text, CODE_PREFIX_MD5 . md5($text));
    return str_replace(CODE_PREFIX_MD5, CODE_PREFIX_REPLACE, $text_coded);
}
?>
