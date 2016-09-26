<?php

defined('ACCESS_SYSTEM') or die;

model('Helper/UserHelper');
model('Helper/FriendRequestHelper');

class FriendRequestController extends Controller
{
    public function getList()
    {
    	$result = ['request' => FriendRequestHelper::getList(),
                   'user'    => UserHelper::getUserInfo()];

        App::setPageTitle('Friend request');

    	return view('friend_request', $result);
    }
}

?>