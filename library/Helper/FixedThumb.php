<?php
	class Helper_FixedThumb extends Zend_Controller_Action_Helper_Abstract{		
		
		//Get geo code of any location
		//http://codewelt.com/gcar?startAt=120%20S%20Diamond%20St%20Mercer,%20PA%2016137&lat=41.2265977&lng=-80.2387818
			 
	    /**
	     * @var Zend_Loader_PluginLoader
	     */
		public $pluginLoader;
		
		/**
	     * Constructor: initialize plugin loader
	     *
	     * @return void
	     */ 
	    public function __construct()
	    {
        	$this->pluginLoader = new Zend_Loader_PluginLoader();
    	}
    	/**
    	 * Generate the XML file from the property select query
    	 * @param String $propertyQuery
    	 * @param String $xmlFileName
    	 * @return String $xmlFileName
    	 */		 
		public function getFixedThumb($file_name, $src_path , $dest_path ,$width, $height, $imageStyle) 
		{  	 	
	        $file_path = $src_path."/".$file_name;
	        
	        if (($imageStyle == '') || ($imageStyle == 'small')) {
	        	
	        	$ext = explode('.', $file_name);
	        	$new_ext_img   = $ext[0] . '.jpg';
	        	
	        	if ($imageStyle == '') {
	        		$new_file_path = $dest_path . "/" . $new_ext_img;
	        	} else {
	        		$new_file_path = $dest_path . "/" . $imageStyle . "-" . $new_ext_img;
	        	}
	            
	            
	        } else {
	        	$new_file_path = $dest_path . "/" . $imageStyle . "-" . $file_name;
	        }	
	                
	        list($img_width, $img_height) = @getimagesize($file_path);
	        
	        if (!$img_width || !$img_height) {
	            return false;
	        }
	        
	        $status = $imageStyle;
	        
	        if ($status == "actual") {
	        	
		        if($img_width > 1600) {
		            $new_width = $img_width * 2/3;
			        $new_height = $img_height * 2/3;
	        	} else {
			        $new_width = $img_width;
			        $new_height = $img_height;
	        	}
	        	
	        } else {
		        $new_width = $width;
		        $new_height = $height;
		        
		        
	            if ($img_width > $new_width) {
                    $new_width = $new_width;
                } else {
                    $new_width = $img_width;
                }
                
                
                if ($img_height > $new_height) {
                    $new_height = $new_height;
                } else {
                    $new_height = $img_height;
                }
                
	        }
	 
	        $new_img = @imagecreatetruecolor($new_width, $new_height);
	        
	        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
	            case 'jpg':
	            case 'jpeg':
	                $src_img = @imagecreatefromjpeg($file_path);
	                $write_image = 'imagejpeg';
	                 $quality = 60;
	                break;
	            case 'gif':
	                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
	                $src_img = @imagecreatefromgif($file_path);
	                $write_image = 'imagegif';
	                break;
	            case 'png':
	                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
	                @imagealphablending($new_img, false);
	                @imagesavealpha($new_img, true);
	                $src_img = @imagecreatefrompng($file_path);
	                $write_image = 'imagepng';
	                 $quality = 6;
	                break;
	            default:
	                $src_img = $image_method = null;
	        }
	        
	        if ($status == "actual") {
	        	
	        $success = $src_img && @imagecopyresampled(
	            $new_img,
	            $src_img,
	            0, 0, 0, 0,
	            $new_width,
	            $new_height,
	            $img_width,
	            $img_height
	            ) && $write_image($new_img, $new_file_path,$quality);
	            
	        } else {
	        	$success = $src_img && @imagecopyresampled(
	            $new_img,
	            $src_img,
	            0, 0, 0, 0,
	            $new_width,
	            $new_height,
	            $img_width,
	            $img_height
	           ) && imagejpeg($new_img, $new_file_path);
	        /*
	            if($img_width > $img_height){
                $biggestSide = $img_width; 
                $ratio = $img_width/$img_height;
               }           
                else{
                    $biggestSide = $img_height; 
                    $ratio = $img_height/$img_width;                 
                }
                $ratio = (float)$ratio;

                if($ratio<=1.5){
                $cropPercent = .65;
                }
                else if(1.5<$ratio && $ratio<=2){
                $cropPercent = .55;
                }
                else if(2<$ratio && $ratio<=2.5){
                $cropPercent = .45;
                }
                else if(2.5<$ratio && $ratio<3){
                $cropPercent = .35;
                }
                else if(3<$ratio && $ratio<=3.5){
                $cropPercent = .25;
                }
                else if(3.5<$ratio && $ratio<=5.5){
                $cropPercent = .2;
                }
                else{
                $cropPercent = .2;
                }
                $cropWidth   = $biggestSide*$cropPercent; 
                $cropHeight  = $biggestSide*$cropPercent; 
                                 
                //getting the top left coordinate
                $c1 = array("x"=>($img_width-$cropWidth)/2, "y"=>($img_height-$cropHeight)/2);
            
                
                $success = $src_img && @imagecopyresampled(
                $new_img,
                $src_img,
                0, 0,$c1['x'], $c1['y'],
                $new_width,
                $new_height,
                $cropWidth,
                $cropHeight
            ) && imagejpeg($new_img, $new_file_path);
	        */
	        
	        }
	        
	        
	        
	        // Free up memory (imagedestroy does not delete files):
	        @imagedestroy($src_img);
	        @imagedestroy($new_img);
	        return $success;
	 }
		
		public function direct($file_name, $src_path , $dest_path ,$width , $height ,$imageStyle){
	        return $this->getFixedThumb($file_name, $src_path , $dest_path ,$width , $height ,$imageStyle);
	    }	
	}
?>