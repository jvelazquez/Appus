<?php
include("recursos/config.php");
session_start();

$_SESSION["mo"] = 0;


$usu=filtra( $_POST["usuario"]);
$pass=filtra( $_POST["password"]);
$md5=filtra( $_POST["md5"]);
$contrase_md5=md5($md5);



$dato_usuario=sql_qfr("SELECT * FROM  login_alumnos WHERE usuario like '$usu' and pass like '$contrase_md5'");
//echo ("SELECT * FROM  login_alumnos WHERE usuario like '$usu' and pass like '$contrase_md5'");
$respuesta = new stdClass();


if($dato_usuario)
{
	$respuesta->mensaje = "ok";
	$respuesta->idalumno = $dato_usuario[9];
				
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