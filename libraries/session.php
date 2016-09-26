<?php

defined('ACCESS_SYSTEM') or die;

class Session
{
	public static function flash($array) 
	{
		if (!empty($array)) {
			$_SESSION['message'] = $array;
		}
	}

	public static function hasFlash($name) 
	{
		if (isset($_SESSION['message'])) {
			if (isset($_SESSION['message'][$name])) {
				return true;
			}
		} else {
			return false;
		}
	}

	public static function getFlash($name) 
	{
		if (isset($_SESSION['message'])) {
			if (isset($_SESSION['message'][$name])) {
				$tmp = $_SESSION['message'][$name];
				unset($_SESSION['message']);
				return $tmp;
			}
		} else {
			return '';
		}
	}

	public static function set($name, $value) 
	{
		$_SESSION[$name] = $value;
	}

	public static function has($name) 
	{
		if (isset($_SESSION[$name])) {
			if (isset($_SESSION[$name])) {
				return true;
			}
		} else {
			return false;
		}
	}

	public static function get($name) 
	{
		if (isset($_SESSION[$name])) {
			if (isset($_SESSION[$name])) {
				return $_SESSION[$name];
			}
		} else {
			return '';
		}
	}

	public static function clean() 
	{
		session_destroy();
	}

	public static function hasAll() 
	{
		if (isset($_SESSION['message'])) {
			return true;
		} else {
			return false;
		}
	}

	public static function getAll() 
	{
		if (isset($_SESSION['message'])) {
			$tmp = $_SESSION['message'];
			unset($_SESSION['message']);
			return $tmp;
		} else {
			return '';
		}
	}
}

?>