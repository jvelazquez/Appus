<?php

function sql_q($query,$conectar=0) {

  if($conectar==0)	
 	include("conectar.php");
	
  return $req = @mysql_query($query,$link);

}

function sql_qfr($query,$conectar=0){
	
	$res=sql_q($query,$conectar);
	
	return @mysql_fetch_row($res);
	

}

function sql_qnr($query,$conectar=0){
	
	$res=sql_q($query,$conectar);
	
	return @mysql_num_rows($res);
	
}

function sql_fr($query) {

  return $req = @mysql_fetch_row($query);

}

function sql_nr($query) {

  return $req = @mysql_num_rows($query);

}

function sql_fech($query) {

  return $req = @mysql_fetch_assoc($query);

}

function sql_ins($query,$tabla,$conectar=0){


$campos=chk_tabla($query,$tabla,$conectar);

if($campos){
	
	$sql_inserta="INSERT INTO $tabla ($campos) VALUES($query) ";
	
	$ins=sql_q($sql_inserta,$conectar);

	return true;
}

	else
		return false;
}

function sql_u($datos,$condicion,$tabla,$conectar=0){

	$upd=sql_q("UPDATE ".$tabla." SET ".$datos." WHERE ".$condicion,$conectar);
	
	return $upd;
}

function sql_ultimo(){
	
	include("conectar.php");
	
	//$ultimo=mysql_insert_id($link);
	
	$ultimox=sql_qfr("SELECT @@identity AS id");
	
	$ultimo=trim($ultimox[0]);
	
	return $ultimo;
}

function chk_tabla($query,$tabla,$conectar=0){

$info_tabla = sql_q("DESCRIBE ".$tabla,$conectar);

$campos = sql_nr($info_tabla);

$valores=explode (",'",$query);

$valores=count($valores);

if($campos!=$valores)
	return false;

else{
		$cont=0;
	
		while($col = sql_fr($info_tabla)){
		
			$cont++;
		
			if($cont==$campos)
				$retorno.=$col[0];
		
				else
					$retorno.=$col[0].",";
			}	
	
		return $retorno;	
	}
}	 
?>
