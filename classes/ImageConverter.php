<?php                                              
/*
Resizes an image and converts it to PNG returning the PNG data as a string
Taken From
http://stackoverflow.com/questions/22259/how-do-i-resize-and-convert-an-uploaded-image-to-a-png-using-gd

But the Nice One is
http://stackoverflow.com/questions/8550015/convert-jpg-gif-image-to-png-in-php

*/
function imageToPng($srcFile, $wd = 200, $ht=60) {  
    list($width_orig, $height_orig, $type) = getimagesize($srcFile);        
	
    // Get the aspect ratio
    $ratio_orig = $width_orig / $height_orig;

    //$width  = $maxSize; 
    //$height = $maxSize;
	$width  = $wd; 
	$height = $ht;
    // resize to height (orig is portrait) 
    if ($ratio_orig < 1) {
        $width = $height * $ratio_orig;
    } 
    // resize to width (orig is landscape)
    else {
        $height = $width / $ratio_orig;
    }
			
    // Temporarily increase the memory limit to allow for larger images
    ini_set('memory_limit', '32M'); 

	//Image Name
	$now = new DateTime();
	$name = $now->getTimestamp(); 
	//$ext = pathinfo($fname, PATHINFO_EXTENSION);
	$ext = 'png';
	$uname = preg_replace('/\s+/', '', $name);
	$filename = $uname.".".$ext;		
	$path = "documents/".$filename;
		
    switch ($type) 
    {
        case IMAGETYPE_GIF: 
            $image = imagecreatefromgif($srcFile); 
            break;   
        case IMAGETYPE_JPEG:  
            $image = imagecreatefromjpeg($srcFile); 
            break;   
        case IMAGETYPE_PNG:  
            $image = imagecreatefrompng($srcFile);
            break; 
        default:
            throw new Exception('Unrecognized image type ' . $type);
    }

    // create a new blank image
    $newImage = imagecreatetruecolor($width, $height);

    // Copy the old image to the new image
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

    // Output to a temp file
    $destFile = tempnam();
    imagepng($newImage, $path);  

    // Free memory                           
    imagedestroy($newImage);
	unlink($destFile);    
	return $filename;
    /*
	if ( is_file($destFile) ) {
        $f = fopen($destFile, 'rb');   
        $data = fread($f);       
        fclose($f);

        // Remove the tempfile
        unlink($destFile);    
        return $data;
    }
	throw new Exception('Image conversion failed.');
	*/
}