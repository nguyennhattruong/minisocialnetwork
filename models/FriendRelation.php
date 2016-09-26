<?php 

defined('ACCESS_SYSTEM') or die;

class FriendRelation extends Model
{
	function info() 
	{
		return ['table' => 'friend_relation', 'pk' => 'id'];
	}
}