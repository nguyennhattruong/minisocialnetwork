<?php

defined('ACCESS_SYSTEM') or die;

class Upload
{
	private $_file;
	public $extension = array('jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF');
	public $arrOption = array('maxSize'			=> 3000000,
							  'smallWidth'		=> 250,
							  'smallHeight' 	=> 250,
							  'smallQuality' 	=> 100,
							  'mediumWidth' 	=> 500,
							  'mediumHeight' 	=> 500,
							  'mediumQuality' 	=> 100,
							  'bigWidth' 		=> 1024,
							  'bigHeight' 		=> 1024,
							  'bigQuality' 		=> 100,
							  'tempDir' 		=> 'tmp',
							  'bigDir' 			=> '',
							  'mediumDir' 		=> '',
							  'smallDir' 		=> '',
							  'isMedium'		=> false);
	
	public function __construct($file = NULL, $option = array())
	{
		$this->_file = $file;

		// Merge default array and params array
		$this->arrOption = array_merge($this->arrOption, $option);

		// Check upload max
		$maxUploadSystem = (int)ini_get('upload_max_filesize') * 1024 * 1024;

		if ($this->arrOption['maxSize'] > $maxUploadSystem) {
			$this->arrOption['maxSize'] = $maxUploadSystem;
		}
		
		// Set dir
		$this->arrOption['tempDir'] 	= getBasePath() . '/' . $this->arrOption["tempDir"];
		$this->arrOption['bigDir'] 		= getBasePath() . '/' . $this->arrOption["bigDir"];
		$this->arrOption['smallDir'] 	= $this->arrOption["bigDir"] . '/thumbnails';
		
		if ($this->arrOption['isMedium'])
		{
			$this->arrOption['smallDir'] 	= $this->arrOption["bigDir"] . '/thumbnails/sm';
			$this->arrOption['mediumDir'] 	= $this->arrOption["bigDir"] . '/thumbnails/md';
		}
	}
	
	public function uploadImage($image)
	{
		if(trim($image) == '')
			return '';
		
		// Big Directory
		if(!is_dir($this->arrOption["bigDir"])) {
			mkdir($this->arrOption["bigDir"]);
		}
		
		// Small Directory
		if(!is_dir($this->arrOption["smallDir"])) {
			mkdir($this->arrOption["smallDir"]);
		}

		// Medium Directory
		if ($this->arrOption['isMedium']) {
			if(!is_dir($this->arrOption["mediumDir"])) {
				mkdir($this->arrOption["mediumDir"]);
			}
		}
		
		$imageTemp = $this->arrOption['tempDir'] . '/' . $image;

		if (file_exists($imageTemp))
		{
			$flag = true;
			$fileName = md5($image);
			
			$fileExt = $this->getExtension($image);
			while($flag)
			{
				if(file_exists($this->arrOption["bigDir"] . "/" . $fileName . '.' . $fileExt))
				{
					$flag = true;
					$fileName = md5(rand() . $fileName);
				}
				else
					$flag = false;
			}

			$fileName = $fileName . '.' . $fileExt;
			
			// Big Image				
			if ($this->createImage($imageTemp, $this->arrOption["bigDir"]."/".$fileName, $this->arrOption["bigWidth"], $this->arrOption["bigHeight"], $this->arrOption["bigQuality"], true) === false) {
				return false;
			}
			
			// Medium Image
			if ($this->arrOption['isMedium']) {
				if ($this->createImage($imageTemp, $this->arrOption["mediumDir"]."/".$fileName, $this->arrOption["mediumWidth"], $this->arrOption["mediumHeight"], $this->arrOption["mediumQuality"]) === false) {
					return false;
				}
			}

			// Small Image
			if ($this->createImage($imageTemp, $this->arrOption["smallDir"]."/".$fileName, $this->arrOption["smallWidth"], $this->arrOption["smallHeight"], $this->arrOption["smallQuality"]) === false) {
				return false;
			}
				
			// Remove Temp Image
			if (file_exists($imageTemp)) {
				unlink($imageTemp);
			}
				
			return $fileName;
		}
		else
			return '';
	}
	
	// Upload to tmp folder
	public function uploadTemp()
	{
		if($this->isFile() == 1)
		{
			$flag = true;
			$fileName = md5(basename($this->_file["name"]));
			$fileExt = $this->getExtension($this->_file["name"]);
			while($flag)
			{
				if(file_exists($this->arrOption["tempDir"]."/" . $fileName . '.' . $fileExt))
				{
					$flag = true;
					$fileName = md5(rand() . $fileName);
				}
				else
					$flag = false;
			}
			move_uploaded_file($this->_file['tmp_name'], $this->arrOption["tempDir"] . "/" . $fileName . '.' . $fileExt);
			return array('flag' => 1, 'filename' => $fileName . '.' . $fileExt);
		} elseif ($this->isFile() == 2) {
			return array('flag' => 2, 'message' => implode(', ', $this->extension), 'fileName' => $this->_file["name"]);
		} else {
			return array('flag' => 3, 'message' => ($this->arrOption["maxSize"] / 1024) . ' MB', 'fileName' => $this->_file["name"]);
		}
		return $this->isFile();
	}

	protected function isFile()
	{
		if (!in_array($this->getExtension($this->_file["name"]), $this->extension)) {
			return 2;
		}

		if ($this->_file["size"] == 0 || $this->_file["size"] > $this->arrOption["maxSize"]) {
			return 3;
		}

		return 1;
	}
	
	protected function getExtension($str) 
	{
		return pathinfo($str, PATHINFO_EXTENSION);
	}
	
	protected function createImage($fileSrc, $fileName, $width, $height, $quality, $isRatio = false)
	{
		$flag = false;

		$ext = $this->getExtension($fileSrc);
		if(!strcmp("jpg", $ext) || !strcmp("jpeg", $ext) || !strcmp("JPEG", $ext) || !strcmp("JPG", $ext)) {
			$img = @imagecreatefromjpeg($fileSrc);
			if ($img === false) {
				return false;
			}
		}

		if(!strcmp("png", $ext) || !strcmp("PNG", $ext)) {
			$img = @imagecreatefrompng($fileSrc);
			if ($img === false) {
				return false;
			}
		}

		if(!strcmp("gif", $ext) || !strcmp("GIF", $ext)) {
			$img = @imagecreatefromgif($fileSrc);
			if ($img === false) {
				return false;
			}
		}
		
		$oldX = imagesx($img);
		$oldY = imagesy($img);
		
		//Size according to ratio
		if ($isRatio) {
			$ratio = $oldX/$width;
		
			$thumbW = $oldX/$ratio;
			$thumbH = $oldY/$ratio;		
		
			$imgDst = imagecreatetruecolor($thumbW,$thumbH);
			imagecopyresampled($imgDst,$img,0,0,0,0,$width,$thumbH,$oldX,$oldY);
		}
		else {
			$imgDst = imagecreatetruecolor($width,$height);
			imagecopyresampled($imgDst,$img,0,0,0,0,$width,$height,$oldX,$oldY);
		}
		
		if(!strcmp("png",$ext) || !strcmp("PNG",$ext)) {
			imagepng($imgDst,$fileName,9);
		} else if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext) || !strcmp("JPEG",$ext) || !strcmp("JPG",$ext)) {
			imagejpeg($imgDst,$fileName,$quality);
		} else {
			imagegif($imgDst, $fileName,$quality);
		}

		imagedestroy($imgDst);
		imagedestroy($img);
	}
}
?>