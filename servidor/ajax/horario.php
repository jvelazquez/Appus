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
		
	$i++;
	$_SESSION["mo"]=1;
	
	$docente = sql_qfr("SELECT * FROM tblasig_doc WHERE idasig =$stat[0] AND idasig_grupo=$asig_grado[4] AND idper_grado=$per_grado[0]");
	$calificacion=sql_qfr("SELECT * FROM tblcalificacion WHERE idper_grado=$per_grado[0] AND idasig_doc=$stat[0] AND idalumno=$asig_grado[0]");

	$_SESSION["mo"]=8;
	$ndocente = sql_qfr("SELECT ap_paterno,ap_materno,nombre FROM tblcolaborador WHERE idcolab = $docente[2]");
	
	
	$horas = sql_q("SELECT iddia,hor_ini,hor_fin,bimestre FROM tblhorario WHERE idasig_doc = $stat[0] GROUP BY iddia");
	
	echo("SELECT iddia,hor_ini,hor_fin,bimestre FROM tblhorario WHERE idasig_doc = $stat[0] GROUP BY iddia");
	
	$res="";
							$res1="";
							$res2="";
							$res3="";
							$res4="";
							$res5="";
							$res6="";
							$res7="";
							$res8="";
							$res9="";
	
		while($asig_hor=sql_fr($horas))
						{
							switch($asig_hor[0])
							{
							case 1:
								{
									$res=$asig_hor[1]."-".$asig_hor[2];
									$bim1=$asig_hor[3];
									break;
								}
							case 2:
								{
									$res1=substr($asig_hor[1],0,5)."-".substr($asig_hor[2],0,5);
									break;
								}
							case 3:
								{
									$res2=substr($asig_hor[1],0,5)."-".substr($asig_hor[2],0,5);
									break;
								}
							case 4:
								{
									$res3=substr($asig_hor[1],0,5)."-".substr($asig_hor[2],0,5);
									break;
								}
							case 5:
								{
									$res4=substr($asig_hor[1],0,5)."-".substr($asig_hor[2],0,5);
									break;
								}
							case 6:
								{
									$res5=substr($asig_hor[1],0,5)."-".substr($asig_hor[2],0,5);
									break;
								}		
							case 7:
								{
									$res7=substr($asig_hor[1],0,5)."-".substr($asig_hor[2],0,5);
									$bim1=$asig_hor[3];
									break;
								}
								
							case 8:
								{
									$res8=substr($asig_hor[1],0,5)."-".substr($asig_hor[2],0,5);
									$bim9=$asig_hor[3];
									break;
								}
								
							case 9:
								{
									$res9=substr($asig_hor[1],0,5)."-".substr($asig_hor[2],0,5);
									$bim9=$asig_hor[3];
									break;
								}
						}
		}
	
	
	
	
	
		$alumno_calificacion[] = 
			array(
				'num'=>$i, 
				'clave'=>$stat[1], 
				'asignatura'=>utf8_encode($stat[2]), 
				'docente' => utf8_encode($ndocente[0].' '.$ndocente[1].' '.$ndocente[2]), 			
				  'lunes'=>$res,
				  'martes'=>$res1,
				  'miercoles'=>$res2,
				  'jueves'=>$res3,
				  'viernes'=>$res4,
				  'sabado'=>$res5,
				  'domingo'=>$res6,
				 );

}

print json_encode($alumno_calificacion);