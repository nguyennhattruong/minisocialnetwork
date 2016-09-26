<?php

defined('ACCESS_SYSTEM') or die;

model('User');
model('Auth/Auth');

class AccountController extends Controller
{
    public function getIndex() 
    {
    	if (Auth::has()) {
            redirect('home');
        } else {
            return view('menu');
        }
    }

    public function getLogin() 
    {
        if (Auth::has()) {
            redirect('home');
        } else {
            return view('login');
        }
    }

    public function getLogout() 
    {
        Auth::logout();
        redirect('login');
    }

    public function postLogin($request) 
    {
        $result = Auth::login($request['username'], $request['password']);

        if (!empty($result)) {
            Session::set('userid', $result[0]['id']);
            Session::set('username', $result[0]['username']);

            redirect('home');
        } else {
            redirect('login', Session::flash(['error' => 'Your account is incorrect. Please try again!']));
        }
    }
}

?>