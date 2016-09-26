<?php
$info = viewInclude('layout/user_other/favorite_error', $content);
$profile = viewInclude('layout/user_other/profile', $content);

$layout = $profile . $info;

viewMaster('master/master', $layout, $content);
?>