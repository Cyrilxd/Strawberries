<?php
if (isset($_GET['imgid'])) {
    $image = $_GET['imgid'];

    $path = "C:\\Pictures\\{$image}.jpg";
    if (is_readable($path)) {
        $info = getimagesize($path);
        if ($info !== FALSE) {
            header("Content-type: {$info['mime']}");
            readfile($path);
            exit();
        }
    }
}