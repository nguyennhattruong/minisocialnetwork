<?php 

class App
{
	public static function setPageTitle($title)
	{
		global $pageMeta;
		$pageMeta['title'] = $title;
	}
}

?>