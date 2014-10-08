<?php

	//include("../sesion.php"); 
	include("config.php");
	session_start();
	
	if($_SESSION["rol"]==1){
		$_SESSION["mo"]=1;
	
		$foto = sql_qfr("SELECT foto FROM tbldoc_alumno WHERE iddoc_alumno=".$_SESSION["doccontrol"]);
	}else{	
		$_SESSION["mo"]=8;
	
		$foto = sql_qfr("SELECT foto FROM tbldet_colaborador WHERE iddet_colab=".$_SESSION["detcontrol"]);
	}
		
	header("Content-Type: image/jpeg");
	echo $foto[0];
	
	$_SESSION["mo"]=100;
	$prueba = sql_qfr("SELECT * FROM tbldocumentos");
?>