<?php

defined('ACCESS_SYSTEM') or die;

model('Helper/UserHelper');
model('Helper/FavoriteHelper');

class FavoriteController extends Controller
{
	public function getList($username) 
	{
		$info = UserHelper::getUserInfo($username);
		if (empty($info)) {
				redirect('error');
		}
		
		App::setPageTitle('Favorite list');

		if (UserHelper::isUserByUserName($username)) {
				$this->favoriteOfUser($username);
		} else {
				$this->favoriteOfFriend($username);
		}
	}

	private function favoriteOfUser($username) 
	{
		$user = UserHelper::getUserInfo($username);
		
		$result = ['user' => $user,
				   'friend_list_quantity'	=> UserHelper::getFriendQuantity($user['id']),
				   'favorite_quantity'		=> UserHelper::getFavoriteQuantity($user['id']),
				   'favorites'				=> FavoriteHelper::getFavoriteOfUser(0, 6)];

		return view('favorite_list', $result);
	}

	private function favoriteOfFriend($username)
	{
		$user = UserHelper::getUserInfo($username);

		$layout = 'favorite_list_other';

		// Check is friend each other
		if (UserHelper::isFriend(UserHelper::getUserId(), $user['id'])) {
			$favorites = FavoriteHelper::getFavoriteOfFriend($user['id'], 0, 6);
		} else {
			$favorites = NULL;
			$layout = 'favorite_list_other_error';
		}
		
		$result = ['user'                    => $user,
				   'friend_list_quantity'    => UserHelper::getFriendQuantity($user['id']),
				   'favorite_quantity'       => UserHelper::getFavoriteQuantity($user['id']),
				   'is_favorite'             => (int)UserHelper::isFavorite(UserHelper::getUserId(), $user['id']),
				   'is_follow'               => (int)UserHelper::isFollow(UserHelper::getUserId(), $user['id']),
				   'is_friend'               => (int)UserHelper::isFriend(UserHelper::getUserId(), $user['id']),
				   'is_request'              => UserHelper::getRequest(UserHelper::getUserId(), $user['id']),
				   'favorites'               => $favorites];

		return view($layout, $result);
	}
}

?>