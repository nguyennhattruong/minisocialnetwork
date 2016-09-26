<?php 

defined('ACCESS_SYSTEM') or die;

model('FriendRequest');

class FriendRequestHelper
{
	public static function getList($start = 0, $limit = 5)
	{
		$requestObj = new FriendRequest();

		$query = sprintf("SELECT fr.id AS request_id, u.id, u.avatar, u.username, u.fullname, u.birthday, u.address,
								 CASE u.sex WHEN 1 THEN 'Male' ELSE 'Female' END sex 
							FROM `friend_request` fr 
					 	   INNER JOIN `user` u ON fr.user_id = u.id 
					       WHERE fr.user_id_to = %d AND u.group_id = 3
					       LIMIT %d,%d", UserHelper::getUserId(), $start, $limit);

		return $requestObj->query($query);
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

	public static function getFriendRequestQuantity($userid) 
	{
		$requestObj = new FriendRequest();
		$requestObj->where('user_id_to', $userid);
		return $requestObj->scalar();
	}
}

?>