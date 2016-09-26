<?php

defined('ACCESS_SYSTEM') or die;

class ImageController extends Controller
{
	private function getImage($path) 
	{
		$fileName = '';

		if (isset($_GET['img'])) {
			$fileName = $_GET['img'];
		} else {
			return '';
		}

		$filePath = $path . '/' . $fileName;
		if (isset($_GET['size'])) {
			if ($_GET['size'] == 'small') {
				$filePath = $path . '/thumbnails/' . $fileName;
			}
		}

		header('Content-Type: image/jpeg');
    	header('Content-Length: ' . filesize($filePath));
    	echo file_get_contents($filePath);
	}

	public function showImage() 
	{
		$path = BASE_PATH . '/'. USER_IMAGE_FOLDER;
		$this->getImage($path);
	}

	public function showAvatar() 
	{
		$path = BASE_PATH . '/'. AVATAR_FOLDER;
		$this->getImage($path);
	}
}

?>