<?php 

model('HistoryUserAction');

class HistoryUserActionHelper
{
	/**
	 * Store user's action history
	 */
	public static function logHistoryUser($user_id, $action, $user_id_to) 
	{
		$history = new HistoryUserAction();
		$history->attr('user_id', $user_id);
		$history->attr('action', $action);
		$history->attr('user_id_to', $user_id_to);
		$history->save();
	}
}

?>