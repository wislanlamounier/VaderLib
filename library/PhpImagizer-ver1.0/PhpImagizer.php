<?php
/** 
 * @author Ruslan Glick
 * @version 1.0
 * @copyright (c) 2011 - Present, Ruslan Glick
 * 
 */
require_once 'PhpImagizerException.php';

class PhpImagizer
{
    /**
     * 
     * Source file name
     * @var string
     */
	private $_srcFileName;
    
	/**
	 * 
	 * Destination file name
	 * @var string
	 */
    private $_destFileName;
    
    /**
     * 
     * Image type
     * @var int
     */
    private $_type;
    
    /**
     * 
     * Image resource
     * @var resource
     */
    private $_imageResource;
    
    /**
     * 
     * Width of an image
     * @var int
     */
    private $_width;
    
    /**
     * 
     * Height of an image
     * @var int
     */
    private $_height;
    
    /**
     * Quality of an destination image
     * 
     * @var int
     */
    private $_quality = 100;
    
    /**
     * Watermark position: Center
     * @var int
     */
    const POSITION_CENTER = 1;
    
    /**
     * Watermark position: Top Center
     * @var int
     */
    const POSITION_TOP_CENTER = 2;
    
    /**
     * Watermark position: Top Left
     * @var int
     */
    const POSITION_TOP_LEFT = 3;
    
    /**
     * Watermark position: Top Right
     * @var int
     */
    const POSITION_TOP_RIGHT = 4;
    
    /**
     * Watermark position: Bottom Center
     * @var int
     */
    const POSITION_BOTTOM_CENTER = 5;
    
    /**
     * Watermark position: Bottom Left
     * @var int
     */
    const POSITION_BOTTOM_LEFT = 6;
    
    /**
     * Watermark position: Bottom Right
     * @var int
     */
    const POSITION_BOTTOM_RIGHT = 7;
    
    /**
     * Watermark margin
     * @var int
     */
    const MARGIN = 5;
    
    /**
     * 
     * Constructor
     * @param string $filename
     * @param string $destFileName
     */
	public function __construct($filename)
    {
    	// @todo: check if GD is loaded and which version
    	$this->setSrcFileName($filename);
    	$this->_load();
    }
    
    /**
     * Destructor
     */
    public function __destruct()
    {
    	if (is_resource($this->getImageResource())) {
    		imagedestroy($this->getImageResource());
    	}
    }
    
    /**
     * Resize the image horizontally or vertically and mainain aspect ratio
     * @param int $maxSize
     */
    public function fitSize($maxSize)
    {
    	if($this->getWidth() > $this->getHeight()){
			$this->byWidth($maxSize);
		} else {
			$this->byHeight($maxSize);
		}
    }
    
    /**
     * Resize the image horizontally and mainain aspect ratio
     * @param int $maxWidth
     */
    public function byWidth($maxWidth)
    {
    	$this->_load();
    	$width = $this->getWidth();
    	if($width > $maxWidth) {
			$scale = $width / $maxWidth;
			$newWidth = $width / $scale;
			$newHeight = $this->getHeight() / $scale;
			$this->_resize($newWidth, $newHeight);
		}
    }
    
    /**
     * Resize the image vertically and mainain aspect ratio
     * @param int $maxHeight
     */
	public function byHeight($maxHeight)
    {
    	$this->_load();
    	$height = $this->getHeight();
    	if($height > $maxHeight) {
			$scale = $height / $maxHeight;
			$newWidth = $this->getWidth() / $scale;
			$newHeight = $height / $scale;
			$this->_resize($newWidth, $newHeight);
    	}
    }
    
    /**
     * Crop image to $width x $height
     * @param int $width
     * @param int $height
     */
    public function crop($width, $height)
    {
    	$new_x = 0;
		$new_y = 0;
		$new_w = $this->getWidth();
		$new_h = $this->getHeight();

		$tmp_scl_x = $this->getWidth() / $width;
		$tmp_scl_y = $this->getHeight() / $height;

		if($tmp_scl_x > $tmp_scl_y) {
			$new_w = $this->getWidth() * $tmp_scl_y / $tmp_scl_x;
			$new_x = ($this->getWidth() - $new_w) / 2;
		}
		if($tmp_scl_x < $tmp_scl_y) {
			$new_h = $this->getHeight() * $tmp_scl_x / $tmp_scl_y;
			$new_y = ($this->getHeight() - $new_h) / 2;
		}
		$this->_crop($new_x, $new_y, $new_w, $new_h);
		$this->_resize($width, $height);
    }
    
    /**
     * Embed watermark image into image
     * 
     * First parameter is a image filename which will be embeded into image
     * Second parameter is a position, allowed parameters are: 
     * 	POSITION_TOP_LEFT
     *  POSITION_TOP_CENTER
     * 	POSITION_TOP_RIGHT
     * 	POSITION_CENTER
     * 	POSITION_BOTTOM_LEFT
     * 	POSITION_BOTTOM_CENTER
     * 	POSITION_BOTTOM_RIGHT
     * 
     * @param string $filename
     * @param int $position
     */
    public function watermarkImage($filename, $position=self::POSITION_CENTER)
    {
    	$watermark = new PhpImagizer($filename);
    	$watermark->_load();
    	switch ($position) {
    		case self::POSITION_TOP_LEFT:
    			$destX = self::MARGIN;
    			$destY = self::MARGIN;
    			break;
    		case self::POSITION_TOP_CENTER:
    			$destX = ceil($this->getWidth() / 2 - $watermark->getWidth() / 2);
    			$destY = self::MARGIN;
    			break;
    		case self::POSITION_TOP_RIGHT:
    			$destX = $this->getWidth() - $watermark->getWidth() - self::MARGIN;
    			$destY = self::MARGIN;
    			break;
    		case self::POSITION_CENTER:
			default:
    			$destX = ceil($this->getWidth() / 2 - $watermark->getWidth() / 2);
    			$destY = ceil($this->getHeight() / 2 - $watermark->getHeight() / 2);
    			break;
			case self::POSITION_BOTTOM_LEFT:
				$destX = self::MARGIN;
				$destY = $this->getHeight() - $watermark->getHeight() - self::MARGIN;
				break;
    		case self::POSITION_BOTTOM_CENTER:
    			$destX = ceil($this->getWidth() / 2 - $watermark->getWidth() / 2);
    			$destY = $this->getHeight() - $watermark->getHeight() - self::MARGIN;
    			break;
    		case self::POSITION_BOTTOM_RIGHT:
    			$destX = $this->getWidth() - $watermark->getWidth() - self::MARGIN;
    			$destY = $this->getHeight() - $watermark->getHeight() - self::MARGIN;
    			break;
    	}
    	    	
    	imagecopymerge ( $this->getImageResource(), $watermark->getImageResource(), $destX, $destY, 0, 0, $watermark->getWidth(), $watermark->getHeight(), 100);
    	imagedestroy($watermark->getImageResource());
    }
    
    /**
     * Embed textual watermark into image
     * 
     * First parameter is a text to embed into image
     * Second parameter is a position, allowed parameters are: 
     * 	POSITION_TOP_LEFT
     *  POSITION_TOP_CENTER
     * 	POSITION_TOP_RIGHT
     * 	POSITION_CENTER
     * 	POSITION_BOTTOM_LEFT
     * 	POSITION_BOTTOM_CENTER
     * 	POSITION_BOTTOM_RIGHT
     * Third parameter is an assosiative array. That array can contain the following keys:
     * 	'font' - The name of the TrueType font file (can be a URL). 
     * 		Depending on which version of the GD library that PHP is using, 
     * 		it may attempt to search for files that do not begin with a 
     * 		leading '/' by appending '.ttf' to the filename and searching along a library-defined font path.
     * 		(Default is: arial)
     * 	'size' - font point size (Default is: 20)
     * 	'color' - Color index (Default is: #FFFFFF)
     * 	'rotation' - The angle in degrees, with 0 degrees being left-to-right reading text. 
     * 		Higher values represent a counter-clockwise rotation. 
     * 		For example, a value of 90 would result in bottom-to-top reading text.
     * 		(Default is: 0)
     * 	'transparency' - A value between 0 and 100. 0 indicates completely opaque while 100 indicates completely transparent.
     * 		(Default is: 80)
     *  'shadow' - Shadow effect in pixels
     *  	(Default is: 1)
     * 
     * @param string $text
     * @param int $position
     * @param array $params
     * 
     */
    public function watermarkText($text, $position=self::POSITION_CENTER, $params=null)
    {
    	$font = 'arial';
    	$size = 20;
    	$color = '#FFFFFF';
    	$rotation = 0;
    	$transparency = 80;
    	$shadow = 1;
    	if (isset($params['font'])) {
    		$font = $params['font'];
    	}
    	if (isset($params['size'])) {
    		$size = $params['size'];
    	}
    	if (isset($params['color'])) {
    		$color = $params['color'];
    	}
    	if (isset($params['rotation']) && $params['rotation'] > 0 && $params['rotation'] <= 360) {
    		$rotation = $params['rotation'];
    	}
    	if (isset($params['transparency']) && $params['transparency'] >= 0 && $params['transparency'] <= 100 ) {
    		$transparency = $params['transparency'];
    	}
    	if (isset($params['shadow'])) {
    		$shadow = $params['shadow'];
    	}
    	$box = imagettfbbox($size, $rotation, $font, $text);
        $x0 = min($box[0], $box[2], $box[4], $box[6]);
        $x1 = max($box[0], $box[2], $box[4], $box[6]);
        $y0 = min($box[1], $box[3], $box[5], $box[7]);
        $y1 = max($box[1], $box[3], $box[5], $box[7]);
        $watermarkWidth = abs($x1 - $x0);
        $watermarkHeight = abs($y1 - $y0);
        switch ($position) {
            case self::POSITION_TOP_LEFT:
                $y = -$y0 + self::MARGIN;
                $x = -$x0 + self::MARGIN;
                break;
            case self::POSITION_TOP_CENTER:
                $y = -$y0 + self::MARGIN;
                $x = $this->getWidth() / 2 - $watermarkWidth / 2 - $x0;
                break;
            case self::POSITION_TOP_RIGHT:
                $y = -$y0 + self::MARGIN;
                $x = $this->getWidth() - $x1 - self::MARGIN;
                break;
            case self::POSITION_CENTER:
            default:
                $y = $this->getHeight() / 2 - $watermarkHeight / 2 - $y0;
                $x = $this->getWidth() / 2 - $watermarkWidth / 2 - $x0;
                break;
            case self::POSITION_BOTTOM_LEFT:
                $y = $this->getHeight() - $y1 - self::MARGIN;
                $x = -$x0 + self::MARGIN;
                break;
            case self::POSITION_BOTTOM_CENTER:
                $y = $this->getHeight() - $y1 - self::MARGIN;
                $x = $this->getWidth() / 2 - $watermarkWidth / 2 - $x0;
                break;
            case self::POSITION_BOTTOM_RIGHT:
                $y = $this->getHeight() - $y1 - self::MARGIN;
                $x = $this->getWidth() - $x1 - self::MARGIN;
                break;
        }
        $color = trim($color, '#');
        $red = hexdec(substr($color, 0, 2));
        $green = hexdec(substr($color, 2, 2));
        $blue = hexdec(substr($color, 4, 2));
        
        $alpha = 127 * (100 - $transparency) / 100; 
    	if ($shadow) {
        	$gray = imagecolorallocatealpha($this->getImageResource(), 0, 0, 0, $alpha);
        	imagettftext($this->getImageResource(), $size, $rotation, $x-$shadow, $y-$shadow, $gray, $font, $text);
        }
        $color = imagecolorallocatealpha($this->getImageResource(), $red, $green, $blue, $alpha);
        imagettftext($this->getImageResource(), $size, $rotation, $x, $y, $color, $font, $text);
        
    }
    
    /**
     * Save image to $destFileName
     * @param string $destFileName
     */
    public function saveImg($destFileName = null)
    {
        if ($destFileName) {
    		$this->setDestFileName($destFileName);
    	} else if (!$this->getDestFileName()) {
    		$this->_setDestFileName();
    	}
    	switch ($this->getType()) {
            case IMAGETYPE_GIF:
                return imagegif($this->getImageResource(), $this->getDestFileName());
                break;
            case IMAGETYPE_JPEG:
                return imagejpeg($this->getImageResource(), $this->getDestFileName(), $this->getQuality());
                break;
            case IMAGETYPE_PNG:
                return imagepng($this->getImageResource(), $this->getDestFileName());
                break;
            default:
             	throw new Exception("PhpImagizer can manipulate with images of type PNG, JPEG or GIF only");
        }
    }
    
	/**
     * Show image back to browser
     */
    public function showImg()
    {
        switch ($this->getType()) {
            case IMAGETYPE_GIF:
                return imagegif($this->getImageResource());
                break;
            case IMAGETYPE_JPEG:
                return imagejpeg($this->getImageResource(), NULL, $this->getQuality());
                break;
            case IMAGETYPE_PNG:
                return imagepng($this->getImageResource(), NULL, $this->getQuality());
                break;
            default:
             	throw new Exception("PhpImagizer can manipulate with images of type PNG, JPEG or GIF only");
        }
    }
        
  	/**
     * @return the $_srcFileName
     */
    public function getSrcFileName()
    {
        return $this->_srcFileName;
    }

	/**
     * @return the $_destFileName
     */
    public function getDestFileName()
    {
        return $this->_destFileName;
    }

	/**
     * @return the $_type
     */
    public function getType()
    {
        return $this->_type;
    }

	/**
     * @param string $srcFileName
     */
    public function setSrcFileName($srcFileName)
    {
        if (!is_readable($srcFileName)) {
        	throw new PhpImagizerException("PhpImagizer can't open source file $srcFileName. Please make sure it exists and readable");
        }
    	$this->_srcFileName = $srcFileName;
    }

	/**
     * @param string $destFileName
     */
    public function setDestFileName($destFileName)
    {
        $writable = true;
    	if (file_exists($destFileName)) {
        	if (!is_writable($destFileName)) {
        		$writable = false;
        	}
        } else {
        	// Check directory
        	$dir = substr($destFileName, 0, strrpos($destFileName, DIRECTORY_SEPARATOR));
        	if (!is_writable($dir)) {
        		$writable = false;
        	} 
        }
    	if (!$writable) {
        	throw new PhpImagizerException("PhpImagizer can't write the destination file $destFileName. Please change access privileges");
        }
    	$this->_destFileName = $destFileName;
    }

	/**
     * @param string $_type
     */
    public function setType($type)
    {
        if (!in_array($type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
        	throw new Exception("PhpImagizer can manipulate with images of type PNG, JPEG or GIF only");
        }
        $this->_type = $type;
        
    }
    
    /**
     * @return the $_imageResource
     */
    public function getImageResource()
    {
        return $this->_imageResource;
    }

	/**
     * @param resource $_imageResource
     */
    public function setImageResource($imageResource)
    {
        $this->_imageResource = $imageResource;
    }
    
    /**
     * @return the $_width
     */
    public function getWidth()
    {
        return $this->_width;
    }

	/**
     * @return the $_height
     */
    public function getHeight()
    {
        return $this->_height;
    }

	/**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->_width = $width;
    }

	/**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->_height = $height;
    }
    
    /**
     * @return the $_quality
     */
    public function getQuality()
    {
        return $this->_quality;
    }

	/**
     * @param int $quality
     */
    public function setQuality($quality)
    {
        $this->_quality = $quality;
    }
	
    /**
     * Load image
     */
	protected function _load()
    {
        if (is_resource($this->getImageResource())) {
        	return;
        }
    	if (!$this->getType()) {
            $this->_imageType();
        }
        $type = $this->getType();
        switch ($type) {
            case IMAGETYPE_GIF:
                $im = imagecreatefromgif($this->getSrcFileName());
                break;
            case IMAGETYPE_JPEG:
                $im = imagecreatefromjpeg($this->getSrcFileName());
                break;
            case IMAGETYPE_PNG:
                $im = imagecreatefrompng($this->getSrcFileName());
                break;
        }
        if (is_resource($im)) {
        	$this->setImageResource($im);
        }
        
        $this->_setDimensions();
        
    }
    
    /**
     * Set width and height of image resource
     */
    protected function _setDimensions()
    {
    	$this->setWidth(imagesx($this->getImageResource()));
        $this->setHeight(imagesy($this->getImageResource()));
    }
    
    /**
     * Get image type of source file
     * Method will try to get image type from exif extension first 
     * as it faster than GD's getimagesize
     */
    protected function _imageType()
    {
    	// Since exif is much faster than "getimagesize" trying to get information from it
    	if (function_exists('exif_imagetype')) {
    		$this->setType(exif_imagetype($this->getSrcFileName()));
    	} else {
    		$imageData = getimagesize($this->getSrcFileName());
    		$this->setType($imageData[2]);
    	}
    }
    
    /**
     * Resize image to $width and $height
     * @param int $width
     * @param int $height
     */
    protected function _resize($width, $height)
	{
		$imgTemp = ImageCreateTrueColor($width, $height);
	    $bgc = ImageColorAllocate($imgTemp, 0xD0 , 0xD0, 0xB8);
        ImageFilledRectangle($imgTemp, 0, 0, $width, $height, $bgc);
        imagecopyresampled($imgTemp, $this->getImageResource(), 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->setImageResource($imgTemp);
		$this->_setDimensions();
	}
	
	/**
	 * 
	 * Crop image
	 * @param int $trg_x
	 * @param int $trg_y
	 * @param int $trg_w
	 * @param int $trg_h
	 */
	protected function _crop($trg_x, $trg_y, $trg_w, $trg_h)
	{
		$src_w = $trg_w;
		$src_h = $trg_h;
		$img_temp = ImageCreateTrueColor($trg_w, $trg_h);
	    $bgc = ImageColorAllocate($img_temp, 0xD0 , 0xD0, 0xB8);
      	ImageFilledRectangle($img_temp, 0, 0, $trg_w, $trg_h, $bgc);
		imagecopyresampled($img_temp, $this->getImageResource(), 0, 0, $trg_x, $trg_y, $trg_w, $trg_h, $src_w, $src_h);
		$this->setImageResource($img_temp);
		$this->_setDimensions();
	}
    
    public function crop_Eu($trg_x, $trg_y, $trg_w, $trg_h)
    {
      $src_w = $trg_w;
		$src_h = $trg_h;
		$img_temp = ImageCreateTrueColor($trg_w, $trg_h);
	    $bgc = ImageColorAllocate($img_temp, 0xD0 , 0xD0, 0xB8);
      	ImageFilledRectangle($img_temp, 0, 0, $trg_w, $trg_h, $bgc);
		imagecopyresampled($img_temp, $this->getImageResource(), 0, 0, $trg_x, $trg_y, $trg_w, $trg_h, $src_w, $src_h);
		$this->setImageResource($img_temp);
		$this->_setDimensions();
    }
	
	/**
	 * Set default destination file name
	 * Method will set file name based on dimension of target image, 
	 * so if source for file is "Penguins.gif" and target image size is 300x400,
	 * destination file name would be: Penguins300x400.gif
	 */
	protected function _setDestFileName()
	{
		$srcFilename = $this->getSrcFileName();
		$destFilename = preg_replace('/(.*)(\..{3})$/', '${1}' . $this->getWidth() . 'x' . $this->getHeight() . '${2}', $srcFilename);
		$this->setDestFileName($destFilename);
	}
}