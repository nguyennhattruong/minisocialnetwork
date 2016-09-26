<?php 

defined('ACCESS_SYSTEM') or die;

model('User');
model('Helper/UserHelper');
model('Helper/FollowHelper');

class ToolbarProvider
{
	public static function load() 
	{
        $user = new User();

        $user->select('username', 'fullname', 'avatar');
		$user->where('id', UserHelper::getUserId());

		// Get search key
		$key = strip_tags(trim($_GET['key']));

        return array('user' 					=> $user->findSingle(),
					 'friend_request_quantity' 	=> UserHelper::getFriendRequestQuantity(UserHelper::getUserId()),
					 'follow_quantity' 			=> FollowHelper::getFollowQuantity(UserHelper::getUserId()),
					 'keyword' 					=> $key); 
	}
}

?>