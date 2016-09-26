<?php 

defined('ACCESS_SYSTEM') or die;

class HistoryUserAction extends Model
{
	function info() 
	{
		return ['table' => 'history_user_action', 'pk' => 'id'];
	}
}

?>