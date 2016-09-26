<?php

$info = viewInclude('layout/user_other/info', $content);
$profile = viewInclude('layout/user_other/profile', $content);

$layout = $profile . $info;

viewMaster('master/master', $layout, $content);

?>