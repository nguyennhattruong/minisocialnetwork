<?php

defined('ACCESS_SYSTEM') or die;

Model('Auth/Auth');

class LoginSecurity
{
	public static function check() 
	{
		if (!Auth::has()) {
			redirect('login');
		}
	}
}

?>