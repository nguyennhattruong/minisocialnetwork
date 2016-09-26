<?php

defined('ACCESS_SYSTEM') or die;

model('User');
model('Helper/UserHelper');

class SearchController extends Controller
{
	public function getList() 
    {
    	$list = array();
        $count = 6;

        $key = quote(str_replace('_', ' ', $_GET['key']));

    	if ($key != '') {
    		$list = UserHelper::getSearch($key);
    	}
    	
        App::setPageTitle('Search friends');

    	return view('search', compact('list', 'count', 'key'));
    }
}

?>