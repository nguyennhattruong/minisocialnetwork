<?php
$info = viewInclude('layout/friend_list', $content);
$profile = viewInclude('layout/profile', $content);

$layout = $profile . $info;

viewMaster('master/master', $layout, $content);
?>