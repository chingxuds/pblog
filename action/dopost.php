<?php

function publish() {
    /** 获取传入数据 */
    $title = $_POST['title'];
    $content = $_POST['content'];

    echo $title;
    echo '<br />';
    echo $content;
}
?>