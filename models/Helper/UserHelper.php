<?php

defined('ACCESS_SYSTEM') or die;

model('User');
model('FriendRelation');
model('FriendRequest');
model('Favorite');
model('HistoryUserAction');
model('Follow');
model('Image');

class UserHelper
{
	public static function getAbout() 
	{
		$user = new User();
		$user->select('about');
		return $user->find(self::getUserId());
	}

	public static function isFriend($user, $userto) 
	{
		$friend = new FriendRelation();
		$friend->whereRaw(sprintf("AND (user_id = %d and user_id_to = %d) OR (user_id = %d and user_id_to = %d)", $user, $userto, $userto, $user));

		return $friend->has();
	}

	/**
	 * Get request
	 * @param  int  $user
	 * @param  int  $userto
	 * @return NULL if there is no request, array('request_id', 'request_type: 1 - user send to user_to, 2 - user_to send to user')
	 */
	public static function getRequest($user, $userto) 
	{
		$friend = new FriendRequest();
		$friend->select(sprintf('id, CASE user_id WHEN %d THEN 1 ELSE 2 END request_type', $user));
		$friend->whereRaw(sprintf("AND (user_id = %d and user_id_to = %d) OR (user_id = %d and user_id_to = %d)", $user, $userto, $userto, $user));

		$result = $friend->findSingle();

		if (empty($result)) {
			return NULL;
		} else {
			return $result;
		}
	}

	public static function isFavorite($user, $userto) 
	{
		$favorite = new Favorite();
		$favorite->where([['user_id', $user],
						  ['user_id_to', $userto]]);
		return $favorite->has();
	}

	public static function isFollow($user, $userto) 
	{
		$follow = new Follow();
		$follow->where([['user_id', $user],
						['user_id_to', $userto]]);
		return $follow->has();
	}

	// Get user's id is login
	public static function getUserId() 
	{
		return Session::get('userid');
	}

	public static function isUserByUserName($username) 
	{
		if (Session::get('username') == $username) {
			return true;
		} else {
			return false;
		}
	}

	public static function isUser($id) 
	{
		if (Session::get('userid') == $id) {
			return true;
		} else {
			return false;
		}
	}

	public static function getUserInfo($username = '') 
	{
		$user = new User();

		$user->select('id', 'username', 'fullname', 'sex', 'birthday', 'address', 'map', 'email', 'avatar', 'about', 'CASE sex WHEN 1 THEN "Male" ELSE "Female" END sex_name');

		// Get User's info according to username
		if ($username == '') {
			$user->where('id', self::getUserId()); 
		} else {
			$user->where('username', $username);
		}

		return $user->findSingle();
	}

	public static function getImages($userid, $start = 0, $limit = 11) 
	{
		$image = new Image();
		$query = sprintf('SELECT img.*, IFNULL(imgl.id, 0) as liked
							FROM (SELECT * FROM image WHERE user_id = %d) img
							LEFT JOIN (SELECT * FROM image_like WHERE user_id = %d) imgl ON imgl.image_id = img.id
							LIMIT %d,%d', $userid, self::getUserId(), $start, $limit);

		return $image->query($query);
	}

	public static function getFriendQuantity($userid) 
	{
		$relation = new FriendRelation();
		$relation->whereRaw(sprintf('AND user_id = %d OR user_id_to = %d', $userid, $userid));
		return $relation->scalar();
	}

	public static function getFavoriteQuantity($userid) 
	{
		$favorite = new Favorite();
		$favorite->where('user_id', $userid);
		return $favorite->scalar();
	}

	public static function getFriendRequestQuantity($userid) 
	{
		$requestObj = new FriendRequest();
		$requestObj->where('user_id_to', $userid);
		return $requestObj->scalar();
	}

	/**
	 * Store user's action history
	 */
	public static function logHistoryUser($user_id, $action, $user_id_to) 
	{
		$history = new HistoryUserAction();
		$history->attr('user_id', $user_id);
		$history->attr('action', $action);
		$history->attr('user_id_to', $user_id_to);
		$history->save();
	}

	/**
	 * Get user by fullname, username, email
	 * @param  string   $keyword
	 * @return array()
	 */
	public static function getSearch($keyword, $start = 0, $limit = 6) 
	{
		$key = $keyword;
		if ($key != '') {
			$user = new User();
			$query = sprintf("SELECT CASE WHEN fr.user_id IS NULL THEN 0 ELSE 1 END is_confirm, rs.* 
								FROM (SELECT u.* 
										FROM user u 
										LEFT JOIN (SELECT CASE user_id WHEN %d THEN user_id_to ELSE user_id END id 
												     FROM friend_relation 
											        WHERE user_id = %d OR user_id_to = %d
											   
													UNION ALL
												 
												   	SELECT user_id_to as id
													  FROM friend_request 
													 WHERE user_id = %d) lst on u.id = lst.id
									   WHERE u.id <> %d AND lst.id IS NULL AND (fullname LIKE '%%%s%%' OR username LIKE '%%%s%%' OR email LIKE '%%%s%%') LIMIT %d, %d) rs
									   LEFT JOIN (SELECT * FROM friend_request where user_id_to = %d) fr ON fr.user_id = rs.id", self::getUserId(), self::getUserId(), self::getUserId(), self::getUserId(), self::getUserId(), $key, $key, $key, $start, $limit, self::getUserId());

			return $user->query($query);
		}
		return array();
	}
}

?>