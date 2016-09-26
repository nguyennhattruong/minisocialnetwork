<?php

$info = viewInclude('layout/info', $content);
$profile = viewInclude('layout/profile', $content);

$layout = $profile . $info;

viewMaster('master/master', $layout, $content);

?>