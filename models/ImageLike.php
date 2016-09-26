<?php 

defined('ACCESS_SYSTEM') or die;

class ImageLike extends Model
{
	function info() 
	{
		return ['table' => 'image_like', 'pk' => 'id'];
	}

	function enableCreateTime()
	{
        return false;
    }
}

?>