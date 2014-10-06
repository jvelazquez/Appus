<?php
/*
 * by Alex Dahlem
 * http://twitter.com/alexdahlem
 *
 * Dynamically creates a nice picture with a QR-Code on it
 *
 * Use this png as background: http://twitpic.com/5ds1iz
 * Copy the background.png in the same folder as your script
 *
 * You can use this code in any project you want. Mention me if you like it :)
 *
 * Love to qrserver.com for their API! Take a look at their services!
 *
 *** Death to false markup! *** Cheers!
 */
 
// Tell the browser this script is an image
header("Content-Type: image/png");
 
// Our imagecontainer
$imagecontainer = imagecreatetruecolor(500, 550);
// We want to use transparency, so let's tell the image
imagesavealpha ($imagecontainer, true);
// Now we fill the imagecontainer with a transparent color
$alphacolor	= imagecolorallocatealpha($imagecontainer, 0,0,0,127);
imagefill($imagecontainer,0,0,$alphacolor);
 
 
// Our background graphic
$background = imagecreatefrompng('background.png');
// Copy the background into the container
imagecopyresampled($imagecontainer, $background, 0, 0, 0, 0, 500, 550, 500, 550);
 
 
// Our QR-Code
$qrimage = imagecreatefrompng('temp/qrcode.png');
// We need a photoshop-style layer effect
//imagelayereffect($imagecontainer, IMG_EFFECT_OVERLAY);
for ($i = 0; $i < 3; $i++) {
	// Copy the QR image three time for besser contrast
	imagecopyresampled($imagecontainer, $qrimage, 115, 150, 0, 0, 265, 265, 265, 265);
}
 
// Finally render the container
imagepng($imagecontainer);
?>