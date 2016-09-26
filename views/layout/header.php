<?php
defined('ACCESS_SYSTEM') or die;
global $pageMeta;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $pageMeta['title'] ?></title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo assets('assets/bootstrap/css/bootstrap.min.css') ?>">
	<script type="text/javascript" src="<?php echo assets('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
	<!-- Angular.js -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
	<!-- Angular Xeditable -->
	<script type="text/javascript" src="<?php echo assets('assets/angular-xeditable/js/xeditable.min.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo assets('assets/angular-xeditable/css/xeditable.css') ?>">
	<script src="<?php echo assets('assets/js/core.js') ?>" type="text/javascript"></script>
	<script src="<?php echo assets('assets/js/jquery.uploadimage.js') ?>" type="text/javascript"></script>
	<script src="<?php echo assets('assets/js/avatar.js') ?>" type="text/javascript"></script>
	<script type="text/javascript"> var site_path = '<?php echo SITE_PATH ?>' </script>
	<!-- Jquery Scrollbar -->
	<script src="<?php echo assets('assets/jquery.scrollbar/jquery.scrollbar.min.js') ?>" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo assets('assets/jquery.scrollbar/jquery.scrollbar.css') ?>">

	<script type="text/javascript" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.1.3.min.js"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo assets('assets/css/core.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo assets('assets/css/style.css') ?>">
	
	<!-- Bootbox -->
	<script type="text/javascript" src="<?php echo assets('assets/js/bootbox.min.js') ?>"></script>
	<script src="<?php echo assets('assets/js/app.js') ?>" type="text/javascript"></script>

	<!-- Add fancyBox -->
	<link rel="stylesheet" href="<?php echo assets('assets/fancyBox/jquery.fancybox.css') ?>" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo assets('assets/fancyBox/jquery.fancybox.pack.js') ?>"></script>

	<!-- Add fancyBox - button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="<?php echo assets('assets/fancyBox/helpers/jquery.fancybox-buttons.css') ?>" />
	<script type="text/javascript" src="<?php echo assets('assets/fancyBox/helpers/jquery.fancybox-buttons.js') ?>"></script>

	<!-- Add fancyBox - thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="<?php echo assets('assets/fancyBox/helpers/jquery.fancybox-thumbs.css') ?>" />
	<script type="text/javascript" src="<?php echo assets('assets/fancyBox/helpers/jquery.fancybox-thumbs.js') ?>"></script>

	<!-- Add fancyBox - media helper (this is optional) -->
	<script type="text/javascript" src="<?php echo assets('assets/fancyBox/helpers/jquery.fancybox-media.js') ?>"></script>
</head>
