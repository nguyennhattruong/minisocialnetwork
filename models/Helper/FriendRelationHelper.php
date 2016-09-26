<?php 

defined('ACCESS_SYSTEM') or die;

model('FriendRelation');

class FriendRelationHelper
{
	public static function getSuggestionList()
	{
		$relation = new FriendRelation();

		$query = sprintf("SELECT u.* FROM user u 
							LEFT JOIN
							(SELECT CASE user_id WHEN %d THEN user_id_to ELSE user_id END id 
							   FROM friend_relation 
							  WHERE user_id = %d OR user_id_to = %d
							 
							  UNION ALL
							 
							 SELECT user_id_to as id
							   FROM friend_request 
							  WHERE user_id = %d) lst on u.id = lst.id

						  WHERE u.id <> %d AND lst.id IS NULL
						  LIMIT 0, 6", UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId());

		return $relation->query($query);
	}

	public static function friendsOfUser($start = 0, $limit = 6)
	{
		$relation = new FriendRelation();

		$query = sprintf('SELECT u.* 
							FROM user u 
						   INNER JOIN (SELECT CASE user_id WHEN %d THEN user_id_to ELSE user_id END fr_id 
										 FROM friend_relation
										WHERE 1 = 1 AND (user_id = %d OR user_id_to = %d)) fr ON fr.fr_id = u.id
							LIMIT %d,%d', UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), $start, $limit);

		return $relation->query($query);
	}

	public static function friendsOfFriend($id, $start = 0, $limit = 6)
	{
		$relation = new FriendRelation();

		$query = sprintf('SELECT t.id, t.username, t.fullname, t.avatar,
								 CASE id WHEN %d THEN -1 ELSE is_friend END is_friend,
								 CASE WHEN request_type IS NULL THEN 0 ELSE request_type END is_request
							FROM (SELECT u.id, u.username, u.fullname, u.avatar,
										 CASE WHEN fr1.friend_id IS NULL THEN 0 ELSE 1 END is_friend,
										 fr2.request_type
									FROM user u
								   INNER JOIN (SELECT CASE user_id WHEN %d THEN user_id_to ELSE user_id END friend_id 
												 FROM friend_relation WHERE user_id = %d OR user_id_to = %d) fr ON fr.friend_id = u.id 
									LEFT JOIN (SELECT CASE user_id WHEN %d THEN user_id_to ELSE user_id END friend_id 
												 FROM friend_relation 
												WHERE user_id = %d OR user_id_to = %d) fr1 ON fr1.friend_id = u.id
									LEFT JOIN (SELECT CASE user_id WHEN %d THEN user_id_to ELSE user_id END user_id,
			 						 				  CASE user_id WHEN %d THEN 1 ELSE 2 END request_type
			              						 FROM friend_request
							 					WHERE user_id = %d OR user_id_to = %d) fr2 ON fr2.user_id = u.id) t
												LIMIT %d,%d', UserHelper::getUserId(), $id, $id, $id, UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), $start, $limit);
		
		return $relation->query($query);
	}

	public static function isFriend($user, $userto) 
	{
		$friend = new FriendRelation();
		$friend->whereRaw(sprintf("AND (user_id = %d and user_id_to = %d) OR (user_id = %d and user_id_to = %d)", $user, $userto, $userto, $user));

		return $friend->has();
	}

	public static function getFriendQuantity($userid) 
	{
		$relation = new FriendRelation();
		$relation->whereRaw(sprintf('AND user_id = %d OR user_id_to = %d', $userid, $userid));
		return $relation->scalar();
	}
}

?>