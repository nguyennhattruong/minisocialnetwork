<?php 

defined('ACCESS_SYSTEM') or die;

model('User');

class Auth
{
	private static $_key = 'auth';

	public static function login($username, $password) 
	{
		// Check login
    	$user = new User();
        $user->where([['username', $username],
                      ['password', md5($password)]]);

        $result = $user->findBy();

        if (!empty($result)) {
            Session::set(self::$_key, 'true');
            return $result;
        }
        
        return null;
	}

	public static function has() 
	{
		if (Session::has(self::$_key)) {
			return true;
		}

		return false;
	}

	public static function logout() 
	{
		Session::clean();
	}
}

?>