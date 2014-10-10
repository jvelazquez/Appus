<?php 
header('Access-Control-Allow-Origin: *');
class conexion{
	var $Servidor='localhost';
	var $Usuario='root';
	var $Contrasena='UTSIGSI_2014';
	var $Coneccion;
	
	function conectar(){
	$server=$this->Servidor;
	$user=$this->Usuario;
	$pass=$this->Contrasena;
	
	
	$conec=mysql_connect($server,$user,$pass);	
	$this->Coneccion=$conec;
	}
	
}

$conect= new conexion();
$conect->conectar();
$conex=$conect->Coneccion;
$seleccion=mysql_select_db("unive148_736567",$conex);


?>

