<?php

defined('ACCESS_SYSTEM') or die;

model('Helper/UserHelper');
model('Helper/FriendRelationHelper');
import('libraries/uploadimage');
model('Common/Common');

class UserController extends Controller
{
	public function getInfo($username)
	{
		$suggestionList = array();
		$isFavorite = 0;
		$isFollow = 0;
		$isFriend = 0;

		// Get map location
		$latitude = 0;
		$longitude = 0;

		$info = UserHelper::getUserInfo($username);

		if (empty($info)) {
			redirect('error');
		}

		// Friend suggestion
		// If counting friend <= 5
		$relationCount = UserHelper::getFriendQuantity($info['id']);

		if ($relationCount <= 5) {
			$suggestionList = FriendRelationHelper::getSuggestionList();
		}

		// If show friend then show favorite button
		if (!UserHelper::isUser($info['id'])) {
			$isFavorite = (int)UserHelper::isFavorite(UserHelper::getUserId(), $info['id']);
			$isFollow = (int)UserHelper::isFollow(UserHelper::getUserId(), $info['id']);
			$isFriend = (int)UserHelper::isFriend(UserHelper::getUserId(), $info['id']);
		}

		if (trim($info['map']) != '') {
			$arr = explode(',', $info['map']);
			$latitude = $arr[0];
			$longitude = $arr[1];
		}

		$result = ['user'                    => $info,
				   'latitude'                => $latitude,
				   'longitude'               => $longitude,
				   'images'                  => UserHelper::getImages($info['id']),
				   'is_favorite'             => $isFavorite,
				   'is_follow'               => $isFollow,
				   'is_request'				 => UserHelper::getRequest(UserHelper::getUserId(), $info['id']),
				   'is_friend'               => $isFriend,
				   'friend_list_quantity'    => $relationCount,
				   'favorite_quantity'       => UserHelper::getFavoriteQuantity($info['id']),
				   'suggestion_list'         => $suggestionList];

		App::setPageTitle('Profile');

		if (UserHelper::isUser($info['id'])) {
			return view('user', $result);
		} else {
			return view('user_other', $result);
		}
	}
}

?>