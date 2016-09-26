<?php

defined('ACCESS_SYSTEM') or die;

$route->get('login', 'AccountController@getLogin', 'loginGet');
$route->post('login', 'AccountController@postLogin', 'loginPost');
$route->get('logout', 'AccountController@getLogout', 'logout');
$route->get('', 'AccountController@getIndex');
$route->get('home', 'HomeController@getHome', 'home');
$route->get('user/{username}', 'UserController@getInfo', 'userInfo');
$route->get('search', 'SearchController@getList', 'search');
$route->get('friends/{username}', 'FriendController@getList', 'friends');
$route->get('favorite/{username}', 'FavoriteController@getList', 'favorite');
$route->get('friend_request', 'FriendRequestController@getList', 'friendRequest');
$route->get('follow', 'FollowController@getList', 'follow');
$route->get('img/{id}', 'ImageController@showImage', 'showImage');
$route->get('avatar/{id}', 'ImageController@showAvatar', 'showAvatar');
$route->get('uploads/avatar/thumbnails', 'FollowController@getList', 'avatar');

// Ajax route
$route->post('ajax/update/username', 'AjaxController@updateUserFullName', 'ajaxUpdateUserName');
$route->post('ajax/update/email', 'AjaxController@updateUserEmail', 'ajaxUpdateEmail');
$route->post('ajax/update/address', 'AjaxController@updateUserAddress', 'ajaxUpdateAddress');
$route->post('ajax/update/sex', 'AjaxController@updateUserSex', 'ajaxUpdateSex');
$route->post('ajax/update/birthday', 'AjaxController@updateUserBirthday', 'ajaxUpdateBirthday');
$route->post('ajax/update/intro', 'AjaxController@updateIntro', 'ajaxUpdateIntro');
$route->post('ajax/update/map', 'AjaxController@updateUserMap', 'ajaxUpdateMap');

$route->post('ajax/unfriend', 'AjaxController@unfriend', 'unFriend');
$route->post('ajax/addfriend', 'AjaxController@addFriend', 'ajaxAddFriend');
$route->post('ajax/unrequest', 'AjaxController@unRequest', 'unRequest');
$route->post('ajax/unfavorite', 'AjaxController@unfavorite', 'unFavorite');
$route->post('ajax/addfavorite', 'AjaxController@addfavorite', 'addFavorite');
$route->post('ajax/unfollow', 'AjaxController@unfollow', 'unFollow');
$route->post('ajax/addfollow', 'AjaxController@addFollow', 'addFollow');

$route->post('ajax/acceptrequest', 'AjaxController@acceptRequest', 'acceptRequest');
$route->post('ajax/removerequest', 'AjaxController@removeRequest', 'removeRequest');

$route->post('ajax/change_avatar', 'AjaxController@changeAvatar', 'changeAvatar');
$route->post('ajax/add_image', 'AjaxController@addImage', 'addImage');

$route->post('ajax/like', 'AjaxController@like', 'like');
$route->post('ajax/delete', 'AjaxController@deleteImage', 'delete');
$route->post('ajax/view', 'AjaxController@viewImage', 'view');

$route->get('ajax/searchFriend/{key}/{page}', 'AjaxController@searchFriend', 'searchFriend');
$route->get('ajax/favoriteList/{username}/{page}', 'AjaxController@favoriteList', 'favoriteList');
$route->get('ajax/followList/{page}', 'AjaxController@followList', 'followList');
$route->get('ajax/friendList/{username}/{page}', 'AjaxController@friendList', 'friendList');
$route->get('ajax/friendRequest/{page}', 'AjaxController@friendRequest', 'ajaxFriendRequest');
$route->get('ajax/imageList/{username}/{page}', 'AjaxController@imageList', 'imageList');

$route->get('ajax/countFollow', 'AjaxController@countFollow', 'countFollow');

// Check session
$route->get('checkSession', 'HomeController@hasLogin', 'hasLogin');

// Error
$route->get('error', 'ErrorController@error404');

// SERCURITY
$route->security(['logout', 'index', 'home', 'friends', 'favorite', 'userInfo', 'follow',
				  'unFriend', 'ajaxAddFriend', 'unRequest', 'unFavorite', 'addFavorite', 'unFollow', 'addFollow', 'acceptRequest', 'removeRequest', 'changeAvatar', 'addImage', 'like', 'delete', 'view', 'userAbout', 'searchFriend', 'favoriteList', 'followList', 'friendList', 'friendRequest', 'ajaxFriendRequest', 'imageList', 'showImage','showAvatar', 'ajaxUpdateUserName', 'ajaxUpdateEmail', 'ajaxUpdateAddress', 'ajaxUpdateSex', 'ajaxUpdateBirthday', 'ajaxUpdateIntro', 'ajaxUpdateMap', 'hasLogin', 'countFollow', 'avatar', 'search'], 'LoginSecurity');

?>