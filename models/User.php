<?php 

defined('ACCESS_SYSTEM') or die;

class User extends Model
{
	function info() 
	{
		return ['table' => 'user', 'pk' => 'id'];
	}
}

?>