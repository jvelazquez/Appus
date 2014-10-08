<?php

	//include("../sesion.php"); 
	include("config.php");
	session_start();
	
	$idalumno=5924;
	
	$_SESSION["mo"]=1;
	
	$foto = sql_qfr("SELECT foto FROM tbldoc_alumno WHERE iddoc_alumno=$idalumno");

	// Save the image as 'simpletext.jpg'
	$im = imagecreatefromstring($foto[0]);
	imagejpeg($im, $idalumno.'.jpg', 90);
	imagedestroy($im);
?>