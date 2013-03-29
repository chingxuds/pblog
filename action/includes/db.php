<?php

function creatLink() {
    $link = mysqli_connect("localhost", "root", "root", "pblog");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    return $link;
}

function closeLink($link) {
    if ($link) {
        mysqli_close($link);
    } else {
        echo "连接不存在或已关闭";
    }
}

function doQuery($sql) {
    if ($sql != '') {
        $link = creatLink();
        mysqli_set_charset($link, 'utf8');
        $result = mysqli_query($link, $sql);
        closeLink($link);
        return $result;
    } else {
        return FALSE;
    }
}
?>