<?php
session_start();
include('../recursos/config.php');
$colab = $_POST['idalum'];
//$colab=$_SESSION["iduser"];
$_SESSION["mo"]=1;

//obtenemos el idasig_grupo
$asig_grado=sql_qfr("SELECT * FROM tblalumno WHERE idalumno=$colab");

//obtenemos el idgrado
$grades=sql_qfr("SELECT idgrado,idasist,idgen FROM tblasig_grupo WHERE idasig_grupo=$asig_grado[4]");



//obtenemos el pergrado
$per_grado=sql_qfr("SELECT idper_grado,idperesc FROM tblper_grado WHERE idasig_grupo=$asig_grado[4] AND idgrado=$grades[0]");

//buscamos la generacion
$gen=sql_qfr("SELECT idgen,idplanest FROM tblgeneracion WHERE idgen=$grades[2]");

$_SESSION["mo"]=100;
//buscamos la asignatura
$asignatura=sql_q("SELECT * FROM tblasignatura WHERE idplanest=$gen[1] AND idgrado=$grades[0]");

while($stat=sql_fr($asignatura))
	{
		$_SESSION["mo"]=1;
		$calificacion=sql_qfr("SELECT * FROM tblcalificacion WHERE idper_grado=$per_grado[0] AND idasig_doc=$stat[0] AND idalumno=$asig_grado[0]");

		$alumno_calificacion[] = array('asignatura'=>utf8_encode($stat[2]), 'p1' => $calificacion[4], 'i1'=>$calificacion[5],'p2'=>$calificacion[6],'i2'=>$calificacion[7],'p3'=>$calificacion[8],'i3'=>$calificacion[9],'p4'=>$calificacion[10],'i4'=>$calificacion[11],'p_final'=>$calificacion[12],'i_final'=>$calificacion[13]);

}

print json_encode($alumno_calificacion);