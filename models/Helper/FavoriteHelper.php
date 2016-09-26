<?php 

defined('ACCESS_SYSTEM') or die;

model('Favorite');

class FavoriteHelper
{
	public static function getFavoriteOfUser($start = 0, $limit = 6)
	{
		$followObj = new Favorite();
					
		$query = sprintf('SELECT CASE WHEN uf.id is null THEN 0 ELSE 1 END is_friend, 
								 CASE WHEN re.id is null THEN 0 ELSE request_type END is_request,
								 u.* 
							FROM favorite fa 
					       INNER JOIN user u ON u.id = fa.user_id_to 
						    LEFT JOIN (SELECT CASE user_id WHEN %d THEN user_id_to ELSE user_id END id 
										 FROM friend_relation 
										WHERE user_id = %d OR user_id_to = %d) uf ON uf.id = u.id
						    LEFT JOIN (SELECT CASE user_id WHEN %d THEN user_id_to ELSE user_id END id,
											  CASE user_id WHEN %d THEN 1 ELSE 2 END request_type
										 FROM friend_request WHERE user_id = %d OR user_id_to = %d) re ON re.id = u.id      
					 	   WHERE fa.user_id = %d
					 	   LIMIT %d,%d', UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), $start, $limit);

			return $followObj->query($query);
	}

	public static function getFavoriteOfFriend($id, $start = 0, $limit = 6)
	{
		$followObj = new Favorite();
			
		$query = sprintf('SELECT CASE WHEN fa1.user_id_to IS NULL THEN 0 ELSE 1 END is_favorite,
								 CASE WHEN uf.id IS NULL THEN 0 ELSE 1 END is_friend, 
								 CASE WHEN re.id IS NULL THEN 0 ELSE request_type END is_request,
					 u.id, u.username, u.fullname, u.avatar,
					 			 CASE u.id WHEN %d THEN 1 ELSE 0 END is_user
							FROM (SELECT * 
									FROM favorite 
								   WHERE user_id = %d) fa 
						   INNER JOIN user u ON u.id = fa.user_id_to
							LEFT JOIN (SELECT * 
										 FROM favorite 
										WHERE user_id = %d) fa1 ON fa.user_id_to = fa1.user_id_to
							LEFT JOIN (SELECT CASE user_id WHEN %d THEN user_id_to ELSE user_id END id 
										 FROM friend_relation 
										WHERE user_id = %d OR user_id_to = %d) uf ON uf.id = u.id
							LEFT JOIN (SELECT CASE user_id WHEN %d THEN user_id_to ELSE user_id END id,
											  CASE user_id WHEN %d THEN 1 ELSE 2 END request_type
										 FROM friend_request 
										WHERE user_id = %d OR user_id_to = %d) re ON re.id = u.id
										LIMIT %d,%d', UserHelper::getUserId(), $id, UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), UserHelper::getUserId(), $start, $limit);

		return $followObj->query($query);
	}

	public static function isFavorite($user, $userto) {
		$favorite = new Favorite();
		$favorite->where([['user_id', $user],
						  ['user_id_to', $userto]]);
		return $favorite->has();
	}

	public static function getFavoriteQuantity($userid) {
		$favorite = new Favorite();
		$favorite->where('user_id', $userid);
		return $favorite->scalar();
	}
}

?>