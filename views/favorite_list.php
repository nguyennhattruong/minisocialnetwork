<?php
$info = viewInclude('layout/favorite', $content);
$profile = viewInclude('layout/profile', $content);

$layout = $profile . $info;

viewMaster('master/master', $layout, $content);
?>