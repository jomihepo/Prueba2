<?php
/**
 * 
 ************************************************************************************** 
 * 14/04/2010
 * ARCHIVO PARA TRATAMIENTO DE IMAGENES
 *
 ************************************************************************************** 
 * 
 */

	ini_set('memory_limit','128M');

	 /* SERVIDORES DONDE ESTÁ DISPONIBLE $_SERVER['DOCUMENT_ROOT'] */
	 if(!isset($_SERVER["DOCUMENT_ROOT"])){
		$_SERVER["DOCUMENT_ROOT"]=substr($_SERVER['SCRIPT_FILENAME'] , 0 , -strlen($_SERVER['PHP_SELF'])+1 );
	}
	
	$filein = $_SERVER['DOCUMENT_ROOT'].$_GET["imagen"]; // File in
	$imagethumbsize_w = $_GET["w"]; // thumbnail size
	$imagethumbsize_h = $_GET["h"]; // thumbnail size
	$color = $_GET["color"]; // thumbnail size
	
	if($color == '')
		$color ='FFFFFF';
	

	switch ($_GET["mode"]) 
	{
		case "rxy":	resize_x_y( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h);
							break;
		case "r":		resize( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,/*rgb*/"255","255","255");
							break;
		case "rx":	resize_x( $filein,$fileout,$imagethumbsize_w);
							break;
		case "ry":	resize_y( $filein,$fileout,$imagethumbsize_h);
							break;
		case "rxm":resize_x_mod( $filein,$fileout,$imagethumbsize_w);
							break;
		case "rym":resize_y_mod( $filein,$fileout,$imagethumbsize_h);
							break;
		case "tl":	top_left( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,/*rgb*/"255","255","255");
							break;
		case "ra":	resize_ajustada($filein,$fileout,$imagethumbsize_w,$imagethumbsize_h);
							break;
		case "rc":	resize_centrada($filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,$color);
							break;
							
		default:			resize_then_crop( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,/*rgb*/"255","255","255");
							break;
	}



/*******************************************************************************************/
/*******************************************************************************************/
	function resize_x_y( $filein,$fileout,$newheight,$newwidth) 
	{
		$datosImagen = getimagesize($filein);	
		$width = $datosImagen[0];
		$height = $datosImagen[1];
		$format = $datosImagen['mime'];
	
		$ratio= $width/$height;
		if($ratio > 1 || $ratio == 1)
			resize_x_mod( $filein,$fileout,$newwidth);
		elseif($ratio < 1)
			resize_y_mod( $filein,$fileout,$newheight);
	}
/*******************************************************************************************/
/*******************************************************************************************/

/*******************************************************************************************/
/*******************************************************************************************/
	function resize_y_mod( $filein,$fileout,$newheight) 
	{
	
		$datosImagen = getimagesize($filein);	
		$width = $datosImagen[0];
		$height = $datosImagen[1];
		$format = $datosImagen['mime'];
//		$format =  image_type_to_mime_type ($datosImagen[2]);
//		$format =  image_type_to_mime_type ( exif_imagetype($filein));
	
		$ratio= $width/$height;
		if ($newheight<=$height) 
		{
			$newwidth = $newheight*$ratio;
		} 
		else 
		{
			$newwidth=$width;
			$newheight=$height;
		}
	

		switch($format) 
		{
		   case 'image/jpeg':  $image = imagecreatefromjpeg($filein);
							   break;
		   case 'image/gif';   $image = imagecreatefromgif($filein);
							   break;
		   case 'image/png':   $image = imagecreatefrompng($filein);
							   break;
		   case 'image/bmp':   $image = ImageCreateFromBMP($filein);
							   break;
		}
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		if ($fileout !="")imagejpeg($thumb, $fileout); //write to file
		header('Content-type: image/jpeg');
		imagejpeg($thumb); //output to browser
	}
/*******************************************************************************************/
/*******************************************************************************************/


/*******************************************************************************************/
/*******************************************************************************************/
	function resize_x_mod( $filein,$fileout,$newwidth) 
	{
		$datosImagen = getimagesize($filein);	
		$width = $datosImagen[0];
		$height = $datosImagen[1];
		$format = $datosImagen['mime'];
//		$format =  image_type_to_mime_type ($datosImagen[2]);
//		$format =  image_type_to_mime_type ( exif_imagetype($filein));	
	
		$ratio= $height/$width;
		if ($newwidth<=$width) 
		{
			$newheight = $newwidth*$ratio;
		} 
		else 
		{
			$newwidth=$width;
			$newheight=$height;
		}
		
		switch($format) 
		{
		   case 'image/jpeg':  $image = imagecreatefromjpeg($filein);
							   break;
		   case 'image/gif';   $image = imagecreatefromgif($filein);
							   break;
		   case 'image/png':   $image = imagecreatefrompng($filein);
							   break;
		   case 'image/bmp':   $image = ImageCreateFromBMP($filein);
							   break;
		}
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		if ($fileout !="")imagejpeg($thumb, $fileout); //write to file
		header('Content-type: image/jpeg');
		imagejpeg($thumb); //output to browser
	}
/*******************************************************************************************/
/*******************************************************************************************/

/*******************************************************************************************/
/*******************************************************************************************/
	function resize_y( $filein,$fileout,$newheight) 
	{

		$datosImagen = getimagesize($filein);	
		$width = $datosImagen[0];
		$height = $datosImagen[1];
		$format = $datosImagen['mime'];
//		$format =  image_type_to_mime_type ($datosImagen[2]);
//		$format =  image_type_to_mime_type ( exif_imagetype($filein));

		$ratio= $width/$height;
		$newwidth = $newheight*$ratio;
	
		switch($format) 
		{
		   case 'image/jpeg':  $image = imagecreatefromjpeg($filein);
							   break;
		   case 'image/gif';   $image = imagecreatefromgif($filein);
							   break;
		   case 'image/png':   $image = imagecreatefrompng($filein);
							   break;
		   case 'image/bmp':   $image = ImageCreateFromBMP($filein);
							   break;
		}
		
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		
		// Resize
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		if ($fileout !="")imagejpeg($thumb, $fileout); //write to file
		header('Content-type: image/jpeg');
		imagejpeg($thumb); //output to browser
	}
/*******************************************************************************************/
/*******************************************************************************************/

/*******************************************************************************************/
/*******************************************************************************************/
	function resize_x( $filein,$fileout,$newwidth) 
	{

		$datosImagen = getimagesize($filein);	
		$width = $datosImagen[0];
		$height = $datosImagen[1];
		$format = $datosImagen['mime'];
//		$format =  image_type_to_mime_type ($datosImagen[2]);
//		$format =  image_type_to_mime_type ( exif_imagetype($filein));

		$ratio= $height/$width;
		$newheight = $newwidth*$ratio;

		switch($format) 
		{
		   case 'image/jpeg':  $image = imagecreatefromjpeg($filein);
							   break;
		   case 'image/gif';   $image = imagecreatefromgif($filein);
							   break;
		   case 'image/png':   $image = imagecreatefrompng($filein);
							   break;
		   case 'image/bmp':   $image = ImageCreateFromBMP($filein);
							   break;
		}

		$thumb = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		if ($fileout !="")imagejpeg($thumb, $fileout); //write to file
		header('Content-type: image/jpeg');
		imagejpeg($thumb); //output to browser		
		
	}
/*******************************************************************************************/
/*******************************************************************************************/

/*******************************************************************************************/
/*******************************************************************************************/
	function resize( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,$red,$green,$blue) 
	{
	
		$datosImagen = getimagesize($filein);	
		$width = $datosImagen[0];
		$height = $datosImagen[1];
		$format = $datosImagen['mime'];
//		$format =  image_type_to_mime_type ($datosImagen[2]);
//		$format =  image_type_to_mime_type ( exif_imagetype($filein));

		$width_orig = $width;
		$height_orig = $height;	
	
		$new_width = $width * $percent;
		$new_height = $height * $percent;
		
		$width = $imagethumbsize_w ;
		$height = $imagethumbsize_h ;		

	
		switch($format) 
		{
		   case 'image/jpeg':  $image = imagecreatefromjpeg($filein);
							   break;
		   case 'image/gif';   $image = imagecreatefromgif($filein);
							   break;
		   case 'image/png':   $image = imagecreatefrompng($filein);
							   break;
		   case 'image/bmp':   $image = ImageCreateFromBMP($filein);
							   break;
		}

	
		$thumb = imagecreatetruecolor($width , $height); 
		$bgcolor = imagecolorallocate($thumb, $red, $green, $blue); 
		ImageFilledRectangle($thumb, 0, 0, $width, $height, $bgcolor);
		imagealphablending($thumb, true);
		imagecopyresized($thumb, $image, 0, 0, 0, 0,$width, $height, $width_orig, $height_orig);
		$thumb2 = imagecreatetruecolor($imagethumbsize_w , $imagethumbsize_h);
		$bgcolor = imagecolorallocate($thumb2, $red, $green, $blue); 
		ImageFilledRectangle($thumb2, 0, 0,
		$imagethumbsize_w , $imagethumbsize_h , $white);
		imagealphablending($thumb2, true);
		imagecopyresampled($thumb2, $thumb, 0,0, $w1, $h1,	$imagethumbsize_w , $imagethumbsize_h ,$imagethumbsize_w, $imagethumbsize_h);

		if ($fileout !="")imagejpeg($thumb2, $fileout);
		header('Content-type: image/jpeg');
		imagejpeg($thumb2);
	}
/*******************************************************************************************/
/*******************************************************************************************/

/*******************************************************************************************/
/*******************************************************************************************/
	function top_left( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,$red,$green,$blue) 
	{
	
		$datosImagen = getimagesize($filein);	
		$width = $datosImagen[0];
		$height = $datosImagen[1];
		$format = $datosImagen['mime'];
//		$format =  image_type_to_mime_type ($datosImagen[2]);
//		$format =  image_type_to_mime_type ( exif_imagetype($filein));

		$width_orig = $width;
		$height_orig = $height;	
		
		if ($width_orig < $imagethumbsize_w) 
			$imagethumbsize_w = $width_orig;
		if ($height_orig < $imagethumbsize_h) 
			$imagethumbsize_h = $height_orig;
		
		
		switch($format) 
		{
		   case 'image/jpeg':  $image = imagecreatefromjpeg($filein);
							   break;
		   case 'image/gif';   $image = imagecreatefromgif($filein);
							   break;
		   case 'image/png':   $image = imagecreatefrompng($filein);
							   break;
		   case 'image/bmp':   $image = ImageCreateFromBMP($filein);
							   break;
		}
		

		$thumb = imagecreatetruecolor($width , $height); 
		$bgcolor = imagecolorallocate($thumb, $red, $green, $blue); 
		ImageFilledRectangle($thumb, 0, 0, $width, $height, $bgcolor);
		imagealphablending($thumb, true);
		imagecopyresized($thumb, $image, 0, 0, 0, 0,	$width, $height, $width_orig, $height_orig);
		$thumb2 = imagecreatetruecolor($imagethumbsize_w , $imagethumbsize_h);
		$bgcolor = imagecolorallocate($thumb2, $red, $green, $blue); 
		ImageFilledRectangle($thumb2, 0, 0,
		$imagethumbsize_w , $imagethumbsize_h , $white);
		imagealphablending($thumb2, true);
		imagecopyresampled($thumb2, $thumb, 0,0, $w1, $h1,	$imagethumbsize_w , $imagethumbsize_h ,$imagethumbsize_w, $imagethumbsize_h);
	
		if ($fileout !="")imagejpeg($thumb2, $fileout); //write to file
		header('Content-type: image/jpeg');
		imagejpeg($thumb2); //output to browser
	}
/*******************************************************************************************/
/*******************************************************************************************/

/*******************************************************************************************/
/*******************************************************************************************/
	function resize_then_crop( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,$red,$green,$blue) 
	{
		$datosImagen = getimagesize($filein);	
		$width = $datosImagen[0];
		$height = $datosImagen[1];
		$format = $datosImagen['mime'];
//		$format =  image_type_to_mime_type ($datosImagen[2]);
//		$format =  image_type_to_mime_type ( exif_imagetype($filein));

		
		$width_orig = $width;
		$height_orig = $height;

		$new_width = $width * $percent;
		$new_height = $height * $percent;
		
		$width = $imagethumbsize_w ;
		$height = $imagethumbsize_h ;	
		
		if ($width_orig < $height_orig) 
		  $height = ($imagethumbsize_w / $width_orig) * $height_orig;
		else
		   $width = ($imagethumbsize_h / $height_orig) * $width_orig;
		
		
		if ($width < $imagethumbsize_w)
		{
			$width = $imagethumbsize_w;
			$height = ($imagethumbsize_w/ $width_orig) * $height_orig;
		}
		
		if ($height < $imagethumbsize_h)
		{
			$height = $imagethumbsize_h;
			$width = ($imagethumbsize_h / $height_orig) * $width_orig;
		}			
	
	
		switch($format) 
		{
		   case 'image/jpeg':  $image = imagecreatefromjpeg($filein);
							   break;
		   case 'image/gif';   $image = imagecreatefromgif($filein);
							   break;
		   case 'image/png':   $image = imagecreatefrompng($filein);
							   break;
		   case 'image/bmp':   $image = ImageCreateFromBMP($filein);
							   break;
		}
	
		
		$thumb = imagecreatetruecolor($width , $height); 
		$bgcolor = imagecolorallocate($thumb, $red, $green, $blue); 
		ImageFilledRectangle($thumb, 0, 0, $width, $height, $bgcolor);
		imagealphablending($thumb, true);		
		imagecopyresampled($thumb, $image, 0, 0, 0, 0,$width, $height, $width_orig, $height_orig);
		$thumb2 = imagecreatetruecolor($imagethumbsize_w , $imagethumbsize_h);
		$bgcolor = imagecolorallocate($thumb2, $red, $green, $blue); 
		ImageFilledRectangle($thumb2, 0, 0,	$imagethumbsize_w , $imagethumbsize_h , $white);
		imagealphablending($thumb2, true);
		$w1 =($width/2) - ($imagethumbsize_w/2);
		$h1 = ($height/2) - ($imagethumbsize_h/2);
		imagecopyresampled($thumb2, $thumb, 0,0, $w1, $h1,$imagethumbsize_w , $imagethumbsize_h ,$imagethumbsize_w, $imagethumbsize_h);	

		if ($fileout !="")imagejpeg($thumb2, $fileout);
		header('Content-type: image/jpeg');
		imagejpeg($thumb2,NULL,90);	
	}

/*******************************************************************************************/
/*******************************************************************************************/

/*******************************************************************************************/
/*******************************************************************************************/
function resize_ajustada( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h) {
	//list($width_orig, $height_orig) = getimagesize($filein);
	
		$datosImagen = getimagesize($filein);	
		$width_orig = $datosImagen[0];
		$height_orig = $datosImagen[1];
		$format = $datosImagen['mime'];	
		
	//var_dump($filein.' ' .$datosImagen);
	
	$newwidth=$imagethumbsize_w;
	$newheight = $height_orig*$imagethumbsize_w/$width_orig;
	if ($newheight > $imagethumbsize_h) {
		$newheight = $imagethumbsize_h;
	    $newwidth = $width_orig*$imagethumbsize_h/$height_orig;
	}
	$newwidth=intval($newwidth);
	$newheight=intval($newheight);
	//dimensiones
	// Load
	//$format = mime_content_type($filein);
	switch($format) {
	   case 'image/jpeg':
		   $image = imagecreatefromjpeg($filein);
		   break;
	   case 'image/gif';
		   $image = imagecreatefromgif($filein);
		   break;
	   case 'image/png':
		   $image = imagecreatefrompng($filein);
		   break;
	   case 'image/bmp':
		   $image = ImageCreateFromBMP($filein);
		   break;
   }
   $thumb = imagecreatetruecolor($newwidth, $newheight);
	
	// Resize
	imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newwidth, $newheight, $width_orig, $height_orig);
	
	if ($fileout !="")imagejpeg($thumb, $fileout);
	header('Content-type: image/jpeg');
	imagejpeg($thumb,NULL,90);		
}

/*******************************************************************************************/
/*******************************************************************************************/


/*******************************************************************************************/
/*******************************************************************************************/
function resize_centrada( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,$color ='FFFFFF') {
	//list($width_orig, $height_orig) = getimagesize($filein);
	
		$datosImagen = getimagesize($filein);	
		$width_orig = $datosImagen[0];
		$height_orig = $datosImagen[1];
		$format = $datosImagen['mime'];		
	
	$newwidth=$imagethumbsize_w;
	$newheight = $height_orig*$imagethumbsize_w/$width_orig;
	if ($newheight > $imagethumbsize_h) {
		$newheight = $imagethumbsize_h;
	    $newwidth = $width_orig*$imagethumbsize_h/$height_orig;
	}
	$newwidth=intval($newwidth);
	$newheight=intval($newheight);
	//dimensiones
	// Load
	//$format = mime_content_type($filein);
	switch($format) {
	   case 'image/jpeg':
		   $image = imagecreatefromjpeg($filein);
		   break;
	   case 'image/gif';
		   $image = imagecreatefromgif($filein);
		   break;
	   case 'image/png':
		   $image = imagecreatefrompng($filein);
		   break;
	   case 'image/bmp':
		   $image = ImageCreateFromBMP($filein);
		   break;
   }
    $thumb = imagecreatetruecolor($imagethumbsize_w, $imagethumbsize_h);
   
	$colorRelleno = imagecolorallocate($thumb, hexdec (substr($color,0,2)),hexdec (substr($color,2,2)), hexdec (substr($color,4,2)));
	imagefill($thumb, 0, 0, $colorRelleno);
	
	// Resize
	$destX = ($imagethumbsize_w - $newwidth) / 2;
	$destY = ($imagethumbsize_h - $newheight) / 2;
	imagecopyresampled($thumb, $image, $destX, $destY, 0, 0, $newwidth, $newheight, $width_orig, $height_orig);
	
	
	if ($fileout !="")imagejpeg($thumb, $fileout);
	header('Content-type: image/jpeg');
	imagejpeg($thumb,NULL,90);		
}

/*******************************************************************************************/
/*******************************************************************************************/

/*******************************************************************************************/
/*******************************************************************************************/
function ImageCreateFromBMP($filename) 
{
 //Ouverture du fichier en mode binaire
   if (! $f1 = fopen($filename,"rb")) return FALSE;

   $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
   if ($FILE['file_type'] != 19778) return FALSE;

   $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
                 '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
                 '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
   $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
   if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
   $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
   $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
   $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
   $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
   $BMP['decal'] = 4-(4*$BMP['decal']);
   if ($BMP['decal'] == 4) $BMP['decal'] = 0;

  //3 : Chargement des couleurs de la palette
   $PALETTE = array();
   if ($BMP['colors'] < 16777216)  {
	   $PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
   }

   $IMG = fread($f1,$BMP['size_bitmap']);
   $VIDE = chr(0);

   $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
   $P = 0;
   $Y = $BMP['height']-1;
   while ($Y >= 0)  {
   $X=0;
   while ($X < $BMP['width'])  {
     if ($BMP['bits_per_pixel'] == 24) {
       $COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
	  } elseif ($BMP['bits_per_pixel'] == 16) { 
       $COLOR = unpack("n",substr($IMG,$P,2));
       $COLOR[1] = $PALETTE[$COLOR[1]+1];
     } elseif ($BMP['bits_per_pixel'] == 8) { 
       $COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
       $COLOR[1] = $PALETTE[$COLOR[1]+1];
     } elseif ($BMP['bits_per_pixel'] == 4) {
       $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
       if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
       $COLOR[1] = $PALETTE[$COLOR[1]+1];
     } elseif ($BMP['bits_per_pixel'] == 1)  {
       $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
       if    (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
       elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
       elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
       elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
       elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
       elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
       elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
       elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
       $COLOR[1] = $PALETTE[$COLOR[1]+1];
     } else return FALSE;
     imagesetpixel($res,$X,$Y,$COLOR[1]);
     $X++;
     $P += $BMP['bytes_per_pixel'];
   }
   $Y--;
   $P+=$BMP['decal'];
   }

 //Fermeture du fichier
   fclose($f1);

	return $res;
}
/*******************************************************************************************/
/*******************************************************************************************/

?>