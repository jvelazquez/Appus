<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');

//include("recursos/config.php");
include("recursos/conectar.php");
//session_start();

//$_SESSION["mo"] = 0;


$usu= $_POST["usuario"];
$pass=$_POST["password"];

$md5=$_POST["md5"];
$contrase_md5=md5($md5);



$dato_usuario="SELECT * FROM  login_alumnos WHERE usuario like '$usu' and pass like '$contrase_md5'";
//echo $dato_usuario;
$result=mysql_query($dato_usuario,$conex);
$fila=mysql_fetch_array($result);


//echo ("SELECT * FROM  login_alumnos WHERE usuario like '$usu' and pass like '$contrase_md5'");
$respuesta = new stdClass();





if($fila)
{
	//echo "ok";
	$respuesta->mensaje = "ok";
	$respuesta->idalumno = $fila[9];
				
}
else{

	$respuesta->mensaje = "null";

}
 
 
/*convierte los resultados a formato json*/
//$resultadosJson = json_encode($resultados);
 echo json_encode($respuesta);
/*muestra el resultado en un formato que no da problemas de seguridad en browsers 
//echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
 */
?>