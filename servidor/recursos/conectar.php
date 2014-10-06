<?php

session_start();

$bd="";

$servidor="localhost";
//$usuario="unive148_5dm1n";
$usuario="root";
//$contrasena="G3N312@L";
$contrasena="UTSIGSI_2014";

$_SESSION["svr"]=$servidor;
$_SESSION["usr"]=$usuario;
$_SESSION["ctr"]=$contrasena;
$_SESSION["bdn"]=$bdname;

switch($_SESSION["mo"]){

	case 0://seguridad
	{
		$bd="unive148_736567";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
	case 1://control escolar
	{
		$bd="unive148_636573";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
	case 3://control de pagos
	{
		$bd="unive148_636f70";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		/*echo "<script language='javascript' type='text/javascript'>alert('$bd');</script>";*/
		break;
	}
	case 4://planeacion y evaluacion
	{
		$bd="unive148_636573";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		/*echo "<script language='javascript' type='text/javascript'>alert('$bd');</script>";*/
		break;
	}
	case 5://Idiomas
	{
		$bd="unive148_696469";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
	
	case 7://Servicio Social
	{
		$bd="unive148_736572";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
	case 8://recursos humanos
	{
		$bd="unive148_726568";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
	case 9://Finanzas
	{
		$bd="unive148_667a61";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
	case 16://Secretaria Academica
	{
		$bd="unive148_736163";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
	case 24://Logistica
	{
		$bd="unive148_6c6f67";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
	case 25://App_unisur
	{
		$bd="web_unisur";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
	case 26://Difusión
	{
		$bd="unive148_6e6f74";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
	case 32://Página US
	{
		$bd="unive148_757374";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}	
	case 33://Fundacion
	{
		$bd="unive148_66756e";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}	
	
	default://catalogos
	{
		$bd="unive148_677261";
		$link = mysql_connect("$servidor","$usuario","$contrasena");
		mysql_select_db("$bd",$link);
		break;
	}
}

mysql_query ("SET NAMES \'utf8\'\'");

$_SESSION["based"]=$bd;
/*echo "<script language='javascript' type='text/javascript'>alert('".$_SESSION["svr"]."');</script>";*/

?>
