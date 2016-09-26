<?php 

defined('ACCESS_SYSTEM') or die;

function url($name = '') 
{
	if ($name != '') {
		return SITE_PATH . '/' . $name;
	} else {
		return SITE_PATH;
	}
}

function assets($name = '') 
{
	if ($name != '') {
		echo SITE_PATH . '/' . $name;
	} else {
		echo SITE_PATH;
	}
}

function getAvatar($name, $thumbnail = true, $http = true) 
{
	$path = '';
	if ($http) {
		$path = SITE_PATH;
	} else {
		$path = BASE_PATH;
	}
	
	if (trim($name) != '') {
		$image = $path . '/' . AVATAR_FOLDER . '/' . $name;
		if ($thumbnail) {
			$image = $path . '/' . AVATAR_FOLDER . '/thumbnails/' . $name;
		}
	} else {
		$image = $path . '/assets/images/no-user.gif';
	}
	return $image;
}

function displayAvatar($userId, $small = true) 
{
	if ($small) {
		echo url('avatar/?img=' . $userId . '&size=small');
	} else {
		echo url('avatar/?img=' . $userId);
	}
}

function displayImage($imgId, $small = true) 
{
	if ($small) {
		echo url('img/?img=' . $imgId . '&size=small');
	} else {
		echo url('img/?img=' . $imgId);
	}
}

function getUserImage($name, $thumbnail = true, $http = true) 
{
	$path = '';
	if ($http) {
		$path = SITE_PATH;
	} else {
		$path = BASE_PATH;
	}

	if (trim($name) != '') {
		$image = $path . '/' . USER_IMAGE_FOLDER . '/' . $name;
		if ($thumbnail) {
			$image = $path . '/' . USER_IMAGE_FOLDER . '/thumbnails/' . $name;
		}
	} else {
		$image = $path . '/assets/images/no-user.gif';
	}
	return $image;
}

function route($name = '') 
{
	if ($name != '') {
		echo SITE_PATH . '/' . $name;
	} else {
		echo SITE_PATH;
	}
}

function redirect($name) 
{
	header('Location: ' . SITE_PATH . '/' . $name);
}

function import($name) 
{
	require(BASE_PATH . '/' . $name . '.php');
}

function controller($name) 
{
	require(BASE_PATH . '/controllers/' . $name . '.php');
}

function model($name) 
{
	require_once(BASE_PATH . '/models/' . $name . '.php');
}

function provider($name) 
{
	require_once(BASE_PATH . '/providers/' . $name . '.php');
}

function view($name, $var = NULL) 
{
	$content = $var;
	require(BASE_PATH . '/views/' . $name . '.php');
}

function viewMaster($name, $var = NULL, $var1 = NULL) 
{
	$content = $var;
	$result = $var1;
	require(BASE_PATH . '/views/' . $name . '.php');
}

function viewInclude($name, $var = NULL) 
{
	ob_start();
	view($name, $var);
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

function button($name, $id){
	$content = $id;
	require(BASE_PATH . '/views/html/button/' . $name . '.php');
}

function viewComposer($name) 
{
	global $registry;

	$view = $name;
	$provider = $registry->obj['viewComposer'][$name];
	
	provider($provider);

	$model = $provider::load();
	view('viewcomposers/' . $view, $model);
}

function security($name) 
{
	require(BASE_PATH . '/' . SERCURITY_FOLDER . '/' . $name . '.php');
}

function getBasePath() 
{
	return BASE_PATH;
}

function quote($key) 
{
	return addslashes(strip_tags(trim($key)));
}

// Validation
function checkLength($value, $min, $max)
{
	$len = strlen($value);
	if ($len >= $min && $len <= $max) {
		return true;
	}
	return false;
}

function checkLetter($string, $min, $max) 
{
	$pattern = "/^[a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶ" .
            "ẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợ" .
            "ụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]{" . $min . "," . $max . "}+$/";
    return preg_match($pattern, $string);
}

?>