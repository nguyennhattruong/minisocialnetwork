<?php 

defined('ACCESS_SYSTEM') or die;

class Favorite extends Model
{
	function info() 
	{
		return ['table' => 'favorite',
				'pk' => 'id'];
	}

	function autoCreateTime()
	{
		return true;
	}
}

?>