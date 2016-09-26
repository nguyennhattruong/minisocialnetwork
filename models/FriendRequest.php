<?php 

defined('ACCESS_SYSTEM') or die;

class FriendRequest extends Model
{
	function info() 
	{
		return ['table' => 'friend_request', 'pk' => 'id'];
	}
}

?>