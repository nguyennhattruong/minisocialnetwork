<?php 

defined('ACCESS_SYSTEM') or die;

class Follow extends Model
{
	function info() 
	{
		return ['table' => 'follow',
				'pk' => 'id'];
	}
}

?>