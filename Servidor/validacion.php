<?php
 
/* Define los valores que seran evaluados, en este ejemplo son valores estaticos,
en una verdadera aplicacion generalmente son dinamicos a partir de una base de datos */
 
include("recursos/conectar.php");
include("recursos/config.php");
//session_start();

//$_SESSION["mo"] = 0;


$usuario=$_GET["usuario"];
$pass=$_GET["password"];
$md5=$_GET["md5"];
$contrase_md5= md5($md5);



$dato_usuario="SELECT * FROM  login_alumnos WHERE usuario like '$usuario' and pass like '$contrase_md5'";
//Echo $dato_usuario;


$result=mysql_query($dato_usuario,$conex);
$fila=mysql_fetch_array($result);


//echo ("SELECT * FROM  login_alumnos WHERE usuario like '$usu' and pass like '$contrase_md5'");



$resultados = array();
if($fila)
{
	//echo "ok";
	$resultados["mensaje"] = "ok";
	$resultados["idalumno"] = $fila[9];
				
}
else{
	$resultados["mensaje"] =  "null";

}
 /*convierte los resultados a formato json*/
$resultadosJson = json_encode($resultados);
 //echo json_encode($respuesta);
/*muestra el resultado en un formato que no da problemas de seguridad en browsers */
echo $_GET['jsoncallback'].'('.$resultadosJson.');';
 
?>



