<?php
$name = ''; $type = ''; $size = ''; $error = '';

function compress_image($source_url, $destination_url, $quality) 
{ 
	list($width_orig, $height_orig, $type) = getimagesize($source_url);        
	
    // Get the aspect ratio
    $ratio_orig = $width_orig / $height_orig;

    //$width  = $maxSize; 
    //$height = $maxSize;
	$width  = 400; 
	$height = 260;
    // resize to height (orig is portrait) 
    if ($ratio_orig < 1) {
        $width = $height * $ratio_orig;
    } 
    // resize to width (orig is landscape)
    else {
        $height = $width / $ratio_orig;
    }
			
    // Temporarily increase the memory limit to allow for larger images
    //ini_set('memory_limit', '32M'); 
	
	$info = getimagesize($source_url); 

	if ($info['mime'] == 'image/jpeg') 
		$image = imagecreatefromjpeg($source_url); 
	elseif ($info['mime'] == 'image/gif') 
		$image = imagecreatefromgif($source_url); 
	elseif ($info['mime'] == 'image/png') 
		$image = imagecreatefrompng($source_url);
	
	imagejpeg($image, $destination_url, $quality); 
	
	$newImage = imagecreatetruecolor($width, $height);

    // Copy the old image to the new image
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	
	imagepng($newImage, $destination_url, $quality);  

    // Free memory                           
    imagedestroy($newImage);
	
	return $destination_url; 
} 
?>
