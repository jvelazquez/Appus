<?php 
//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

//html PNG location prefix
$PNG_WEB_DIR = 'temp/';

include "qrlib.php";    

//ofcourse we need rights to create temp dir
if (!file_exists($PNG_TEMP_DIR))
	mkdir($PNG_TEMP_DIR);

$filename = $PNG_TEMP_DIR.'qrcode.png';

//processing form input
$errorCorrectionLevel = 'H';
$matrixPointSize = 10;

$inventario=0;

if($inventario==1)
	$codigoqr="ID:US-29-13-0001";
else
	$codigoqr="MECARD:N:ISC FELIX ETZERT ROMERO PACHECO;ADR:UNIVERSIDAD DEL SUR PLANTEL TERAN;ORG:INTEGRACION GLOBAL DE SISTEMAS DE INFORMACION;TEL:9616573108;EMAIL:sos@universidaddelsur.edu.mx;URL:http://www.universidaddelsur.edu.mx;NOTE:CARGO: PROGRAMADOR JUNIOR;;";
	
QRcode::png($codigoqr, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    

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

$white = imagecolorallocate($imagecontainer, 255, 255, 255);
$font = 'font/arialbd.ttf';

if($inventario==1){
	$text1="PLANTEL TERAN";
	$tb = imagettfbbox(17, 0, $font, $text1);
	$x1 = ceil((500 - $tb[2]) / 2); // lower left X coordinate for text
	imagettftext($imagecontainer, 17, 0, $x1, 450, $white, $font, $text1); // write text to image
	
	$text2="US-29-13-0001";
	$tb = imagettfbbox(17, 0, $font, $text2);
	$x2 = ceil((500 - $tb[2]) / 2); // lower left X coordinate for text
	imagettftext($imagecontainer, 17, 0, $x2, 490, $white, $font, $text2); // write text to image
}else{
	$plantel="PLANTEL TERAN";
	$tb = imagettfbbox(17, 0, $font, $plantel);
	$plan = ceil((500 - $tb[2]) / 2); // lower left X coordinate for text
	imagettftext($imagecontainer, 17, 0, $plan, 150, $white, $font, $plantel); // write text to image
	
	$text1="I.S.C. FÉLIX ETZERT ROMERO PACHECO";
	$tb = imagettfbbox(13, 0, $font, $text1);
	$x1 = ceil((500 - $tb[2]) / 2); // lower left X coordinate for text
	imagettftext($imagecontainer, 13, 0, $x1, 445, $white, $font, $text1); // write text to image
	
	$text2="PROGRAMADOR JUNIOR";
	$tb = imagettfbbox(13, 0, $font, $text2);
	$x2 = ceil((500 - $tb[2]) / 2); // lower left X coordinate for text
	imagettftext($imagecontainer, 13, 0, $x2, 470, $white, $font, $text2); // write text to image
	
	$text3="INTEGRACION GLOBAL DE SISTEMAS DE INFORMACION";
	$tb = imagettfbbox(13, 0, $font, $text3);
	$x3 = ceil((500 - $tb[2]) / 2); // lower left X coordinate for text
	imagettftext($imagecontainer, 13, 0, $x3, 495, $white, $font, $text3); // write text to image
}
 
// Finally render the container
imagepng($imagecontainer);
?>