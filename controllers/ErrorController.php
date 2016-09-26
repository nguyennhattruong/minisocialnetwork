<?php

defined('ACCESS_SYSTEM') or die;

class ErrorController extends Controller
{
    public function error404() 
    {
    	view('errors/404');
    }
}

?>