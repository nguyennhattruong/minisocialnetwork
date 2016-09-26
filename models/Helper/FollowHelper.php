<?php 

defined('ACCESS_SYSTEM') or die;

model('Follow');

class FollowHelper
{
	public static function getList($start = 0, $limit = 10)
	{
		$followObj = new Follow();
		$query = sprintf("SELECT * 
							FROM (SELECT CASE WHEN (fo.regist_datetime < hu.regist_datetime) AND 
													((u2.read_follow_from IS NOT NULL AND u2.read_follow_to IS NOT NULL AND (u2.read_follow_to < hu.regist_datetime OR u2.read_follow_from > hu.regist_datetime))
														OR (u2.read_follow_from IS NOT NULL AND u2.read_follow_to IS NULL AND u2.read_follow_from > hu.regist_datetime)  
														OR (u2.read_follow_from IS NULL AND u2.read_follow_to IS NOT NULL AND u2.read_follow_to < hu.regist_datetime)
														OR (u2.read_follow_from IS NULL AND u2.read_follow_to IS NULL)) THEN 1 ELSE 0 END is_new, 
										 u.username, u.fullname, u.avatar, hu.regist_datetime,
										 CASE hu.action WHEN 1 THEN 'add friend' WHEN 2 THEN 'was unfriend' ELSE 'sent request make friend to' END action,
										 u1.username AS username1, u1.fullname AS fullname1, u1.avatar AS avatar1 
									FROM (SELECT * FROM follow WHERE user_id = %d) fo
								   INNER JOIN (SELECT * FROM history_user_action) hu ON hu.user_id = fo.user_id_to
								   INNER JOIN user u ON u.id = hu.user_id
								   INNER JOIN user u1 ON u1.id = hu.user_id_to
								   INNER JOIN user u2 ON u2.id = %d
								   WHERE fo.regist_datetime < hu.regist_datetime) t 
					       ORDER BY is_new DESC, regist_datetime DESC
					       LIMIT %d,%d", UserHelper::getUserId(), UserHelper::getUserId(), $start, $limit);
		return $followObj->query($query);
	}

	public static function isFollow($user, $userto) 
	{
		$follow = new Follow();
		$follow->where([['user_id', $user],
						['user_id_to', $userto]]);
		return $follow->has();
	}

	public static function getFollowQuantity($userid) 
	{
		$followObj = new Follow();
		$result = $followObj->query(sprintf('SELECT COUNT(*) c
											   FROM (SELECT * FROM follow WHERE user_id = %d) fo
											  INNER JOIN (SELECT * FROM history_user_action) hua ON hua.user_id = fo.user_id_to
											  INNER JOIN user u ON u.id = fo.user_id
											  WHERE (fo.regist_datetime < hua.regist_datetime) AND 
													((u.read_follow_from IS NOT NULL AND u.read_follow_to IS NOT NULL AND (u.read_follow_to < hua.regist_datetime OR u.read_follow_from > hua.regist_datetime))
														  OR (u.read_follow_from IS NOT NULL AND u.read_follow_to IS NULL AND u.read_follow_from > hua.regist_datetime)
														  OR (u.read_follow_from IS NULL AND u.read_follow_to IS NOT NULL AND u.read_follow_to < hua.regist_datetime)
														  OR (u.read_follow_from IS NULL AND u.read_follow_to IS NULL))', $userid));
		return $result[0]['c'];
	}
}

?>