<?php 

defined('ACCESS_SYSTEM') or die;

class Image extends Model
{
	function info() 
	{
		return ['table' => 'image', 'pk' => 'id'];
	}
}

?>