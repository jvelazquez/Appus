<?php
session_start();
include('../recursos/config.php');


$_SESSION["mo"] = 1;

$idalumno = $_POST['idalum'];

//echo $idbeca;
$fila = sql_qfr("SELECT * FROM tblalumno WHERE idalumno=$idalumno AND idstatus!='4'");
$matricula=sql_qfr("SELECT matricula FROM tblmatricula WHERE idalumno=$idalumno");

$asig_grado=sql_qfr("SELECT * FROM tblalumno WHERE idalumno=$idalumno");
$grades=sql_qfr("SELECT idgrado FROM tblasig_grupo WHERE idasig_grupo=$asig_grado[4]");
$per_grado=sql_qfr("SELECT idper_grado FROM tblper_grado WHERE idasig_grupo=$asig_grado[4] AND idgrado=$grades[0]");
$dato_alumno=sql_qfr("SELECT * FROM tblasig_grupo WHERE idasig_grupo=$asig_grado[4]");


$_SESSION["mo"]=100;

$buscarr=sql_qfr("SELECT * FROM tblcarrera WHERE idcarr=$dato_alumno[2]");
$busniv=sql_qfr("SELECT * FROM tblnivacad WHERE idnivacad=$buscarr[2]");
$busasi=sql_qfr("SELECT * FROM tblasisten WHERE idasist=$dato_alumno[5]");
$busgra=sql_qfr("SELECT * FROM tblgrado WHERE idgrado=$dato_alumno[7]");
$busgru=sql_qfr("SELECT * FROM tblgrupo WHERE idgrupo=$dato_alumno[1]");
$bustur=sql_qfr("SELECT * FROM tblturno WHERE idtur=$dato_alumno[6]");





$respuesta = new stdClass();

//$fila = sql_fr($consulta);
$respuesta->matricula = $matricula[0];
$respuesta->nombre = $fila[3]." ".$fila[2]." ".$fila[1];
$respuesta->nivelcad = $busniv[1]." en ".$buscarr[1];
$respuesta->asistencia = $busasi[1];
$respuesta->grupo = $busgra[0]." ".$busgru[1];
$respuesta->turno = $bustur[1];


echo json_encode($respuesta);


/*
$matricula = $_GET['term'];
$consulta =sql_q("SELECT idalumno,nombre, ap_paterno, ap_materno FROM tblalumno WHERE idalumno = '$matricula'");
$result = sql_nr($consulta);
//echo $result;

if($result >0){
    while($fila = sql_fr($consulta)){
       // print_r ($fila);
        $matriculas[] = $fila[0];
       
        //echo si;
}
echo json_encode($matriculas);
}



*/

/*



if($result >0){
    while($fila = sql_fr($consulta)){
       // print_r ($fila);
        $matriculas[] = $fila[0];
       
        //echo si;
}
echo json_encode($matriculas);
*/