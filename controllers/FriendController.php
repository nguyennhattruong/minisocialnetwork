<?php

defined('ACCESS_SYSTEM') or die;

model('Helper/UserHelper');
model('Helper/FriendRelationHelper');

class FriendController extends Controller
{
	public function getList($username)
	{
		$info = UserHelper::getUserInfo($username);
		if (empty($info)) {
			redirect('error');
		}

		App::setPageTitle('Friends');

		if (UserHelper::isUserByUserName($username)) {
			$this->friendsOfUser($username);
		} else {
			$this->friendsOfFriend($username);
		}
	}

	// User's friends
	private function friendsOfUser($username) 
	{
		$user = UserHelper::getUserInfo($username);
		
		$result = ['user'					 => $user,
				   'friend_list_quantity'    => UserHelper::getFriendQuantity($user['id']),
				   'favorite_quantity'       => UserHelper::getFavoriteQuantity($user['id']),
				   'friends'                 => FriendRelationHelper::friendsOfUser(0, 6)];

		return view('friend_list', $result);
	}

	// Friend's friends
	private function friendsOfFriend($username) 
	{
		$friend = UserHelper::getUserInfo($username);
		$userid = UserHelper::getUserId();

		$layout = 'friend_list_other';

		// Check is friend each other
		if (UserHelper::isFriend(UserHelper::getUserId(), $friend['id'])) {
			$friends = FriendRelationHelper::friendsOfFriend($friend['id'],0,6);
		} else {
			$friends = NULL;
			$layout = 'friend_list_other_error';
		}
		
		$result = ['user'                    => $friend,
				   'friend_list_quantity'    => UserHelper::getFriendQuantity($friend['id']),
				   'favorite_quantity'       => UserHelper::getFavoriteQuantity($friend['id']),
				   'is_favorite'             => (int)UserHelper::isFavorite(UserHelper::getUserId(), $friend['id']),
				   'is_follow'               => (int)UserHelper::isFollow(UserHelper::getUserId(), $friend['id']),
				   'is_friend'               => (int)UserHelper::isFriend(UserHelper::getUserId(), $friend['id']),
				   'is_request'				 => UserHelper::getRequest(UserHelper::getUserId(), $friend['id']),
				   'friends'                 => $friends];

		return view($layout, $result);
	}
}

?>