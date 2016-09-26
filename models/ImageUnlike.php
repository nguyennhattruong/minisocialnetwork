<?php 

defined('ACCESS_SYSTEM') or die;

class ImageUnlike extends Model
{
	function info() 
	{
		return ['table' => 'image_unlike', 'pk' => 'id'];
	}

	function enableCreateTime()
	{
        return false;
    }
}

?>