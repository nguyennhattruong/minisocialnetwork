<?php

defined('ACCESS_SYSTEM') or die;

model('User');

class HomeController extends Controller
{
    public function getHome() 
    {
        $user = new User();
        
        $userid = Session::get('userid');

        // Get User's info
        $info = $user->find($userid);

        redirect('user/' . $info['username']);
    }

    public function hasLogin() {
    	return '1';
    }
}

?>