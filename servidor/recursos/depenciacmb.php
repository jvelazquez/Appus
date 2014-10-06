<?php

session_start();

class MySQL

{
  var $conexion;

  function MySQL()
  {
  	if(!isset($this->conexion))
	{
		$servidor=$_SESSION["svr"];
		$usuario=$_SESSION["usr"];
		$contrasena=$_SESSION["ctr"];
		$bdname=$_SESSION["based"];	
		
  		$this->conexion = (mysql_connect("$servidor","$usuario","$contrasena")) or die(mysql_error());
  		mysql_select_db("$bdname",$this->conexion) or die(mysql_error());
		mysql_query ("SET NAMES \'utf8\'\'");
  	}
  }

 function consulta($consulta)
 {
	$resultado = mysql_query($consulta,$this->conexion);
  	if(!$resultado)
	{
  		echo 'MySQL Error: ' . mysql_error();
	    exit;
	}
  	return $resultado; 
  }
  
 function fetch_array($consulta)
 { 
  	return mysql_fetch_array($consulta);
 }
 
 function num_rows($consulta)
 { 
 	 return mysql_num_rows($consulta);
 }
 
 function fetch_row($consulta)
 { 
 	 return mysql_fetch_row($consulta);
 }
 function fetch_assoc($consulta)
 { 
 	 return mysql_fetch_assoc($consulta);
 } 
}

class selects extends MySQL
{

	var $code = "";
	
	function cardatos()
	{	
		$codigo = stripslashes($this->llave);
		$consulta = parent::consulta("SELECT ".$this->cam." FROM ".$this->tabla."  WHERE ".$codigo." = '".$this->code."' ORDER BY ".$this->llapri);
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$datos = array();
			while($dato = parent::fetch_row($consulta))
			{
				$id = $dato[0];	
				$name = $dato[1];				
				$datos[$id]=$name;
			}
			return $datos;
		}
		else
		{
			return false;
		}
	}	
	
	function cardato()
	{	
		$codigo = stripslashes($this->llave);
		$consulta = parent::consulta("SELECT ".$this->cam." FROM ".$this->tabla."  WHERE ".$codigo." = '".$this->code."' ORDER BY ".$this->llapri);
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$datos = array();
			while($dato = parent::fetch_row($consulta))
			{
				$id = $dato[0];	
				$name = $dato[1];				
				$datos[$id]=$name;
			}
			return $datos;
		}
		else
		{
			return false;
		}
	}
	
	function cardatonom()
	{	
		$codigo = stripslashes($this->llave);
		//echo "<option value=\"$key\">SELECT ".$this->cam." FROM ".$this->tabla."  WHERE ".$codigo." = '".$this->code."' ORDER BY ".$this->llapri."</option>";
		$consulta = parent::consulta("SELECT ".$this->cam." FROM ".$this->tabla."  WHERE ".$codigo." = '".$this->code."' ORDER BY ".$this->llapri);
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$datos = array();
			while($dato = parent::fetch_row($consulta))
			{
				$id = $dato[0];	
				$name = $dato[1].' '.$dato[2].' '.$dato[3];				
				$datos[$id]=$name;
			}
			return $datos;
		}
		else
		{
			return false;
		}
	}
	
	function cardat()
	{	
		$consulta = parent::consulta("SELECT * FROM ".$this->tabla." ORDER BY ".$this->llapri);
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		{
			$datos = array();
			while($dato = parent::fetch_row($consulta))
			{
				$id = $dato[0];
				$name = $dato[1];				
				$datos[$id]=$name;
			}
			return $datos;
		}
		else
		{
			return false;
		}
	}

}	
	
$datos = new selects();
$datos->tabla = $_GET["tabla"];
$datos->llapri = $_GET["llapri"];

if($_GET["inte"]=="X")
{
	$datos->llave = $_GET["llave"];
	$datos->code = $_GET["code"];
	$datos->cam = $_GET["cam"];
	$datos = $datos->cardatonom();
	
	if($datos==true)
		foreach($datos as $key=>$value)
		{
			echo "<option value=\"$key\">$value</option>";
		}
}
elseif($_GET["code"]=="0")
{
	$datos->llave = $_GET["llave"];
	$datos = $datos->cardat();
	
	foreach($datos as $key=>$value)
	{
		echo "<option value=\"$key\">$value</option>";
	}
}
else
{
	$datos->llave = $_GET["llave"];
	$datos->code = $_GET["code"];
	$datos->cam = $_GET["cam"];
	
	if($_GET["inte"]==1)
	{
		$datos = $datos->cardato();

		if($datos==true)
			foreach($datos as $key=>$value)
			{
				echo "<input type='checkbox' value='1' name='d$key' id='d$key'>$value.&nbsp;&nbsp;&nbsp;&nbsp;";
			}
	}else{
	
		$datos = $datos->cardatos();
			
		foreach($datos as $key=>$value)
		{
			echo "<option value=\"$key\">$value</option>";
		}
	}
}


?>
