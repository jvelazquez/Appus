<?php 
$area="C1";

include("../sesion.php"); 

//elimina_graficas();

$colores=array("bde4ff","c4f6d9","e8cca4","d99494","c4f6d9","cfce89","edcff9");

$hoy=date("Y-m-d");

//Variables Generales para la generacion de la consulta

$campos=" participantes.status,count(participantes.id_participante) ";

$tablas=" participantes ";

$condicion=" participantes.status>0 ";

$ordenado=" ORDER BY participantes.status ";

$agrupado=" GROUP BY participantes.status ";

$titulos=array("","Solo Resgistro","Contesto Incorrectamente","Contesto Correctamente");

//Recibo de Datos

$conc=filtra($_POST["conc"]);

$f1=filtra($_POST["T1"]);

$f2=filtra($_POST["T2"]);

$sexo=filtra($_POST["sexo"]);

$status=filtra($_POST["status"]);

if(empty($sexo))
	$sexo=0;
if(empty($status))
	$st=0;
	else
		$st=$status;
	
//Valido variables para reiniciar condicion si es el caso
if($f1!="" or $f2!="" or $sexo>0 or $status>0) 
	$condicion="";


if(empty($conc)) $conc=3;


//Inicia Estructuracion de la Condicion

switch($conc){
	case 1:
		$titulo="Detalle";
		$encabezado="Filtrado Detallado";
		$agrupado="";
		$campos=" * ";
		break;
	case 2:
		$titulo="Sexo";
		$encabezado="Filtrado Sexo";
		$campos=" participantes.sexo,count(participantes.id_participante) ";
		$ordenado=" ORDER BY participantes.sexo ";
		$agrupado=" GROUP BY participantes.sexo ";
		$titulos=array("","Hombre","Mujer");
		break;
	case 3:
		$titulo="Status";
		$encabezado="Filtrado  Status";
		break;
	default:
		$titulo="Status";
		$encabezado="Filtrado  Status";
		break;
			
}


//Case de comparacion de Fechas

if($f1!="" or $f2!="")
	{
		if($f1!="" and $f2!="")
			{
	
				if($f1<$f2)
					{
						$condicion=" participantes.fecha BETWEEN '$f1' and '$f2'";
						$encabezado=$encabezado." Fecha Entre <strong>".$f1." y ".$f2."</strong>";						
					}	
				if($f1>$f2)
					{
						$condicion=" participantes.fecha BETWEEN '$f2' and '$f1'";
						$encabezado=$encabezado." Fecha Entre <strong>".$f2." y ".$f1."</strong>";						
					}	
			}	
		if($f2=="" and $f1!="")
			{
				$condicion=" participantes.fecha = '$f1' ";
				$encabezado=$encabezado." Fecha <strong>".$f1."</strong>";						
			}	
		if($f1=="" and $f2!="")
			{	
				$condicion=" participantes.fecha = '$f2'";
				$encabezado=$encabezado." Fecha ".$f2."</strong>";						
			}	
		if($f2==$f1)
			{
				$condicion=" participantes.fecha = '$f1' ";
				$encabezado=$encabezado." Fecha <strong>".$f1."</strong>";						
			}	
}

if($sexo>0){

	if($condicion!="")
		$condicion=$condicion." and participantes.sexo=$sexo ";
		else
			$condicion=" participantes.sexo=$sexo ";
}

if($status>0){

	if($condicion!="")
		$condicion=$condicion." and participantes.status=$status ";
		else
			$condicion=" participantes.status=$status ";
}

//Consulta General de Datos a mostrar

$sql_general="SELECT $campos FROM  $tablas WHERE $condicion $agrupado  $ordenado";

$busca=sql_q($sql_general,3);

$no_vacio=sql_nr($busca,3);

if(!empty($no_vacio)){
//Inicia el almacen de datos a presentar

if($conc!=1){

		$respuesta="<div id='tabla'>
			<table width='100%' >
			<thead>
				<tr>
				<td colspan='2'>$encabezado</td>
				</tr>
				<tr>
					<td width='35%' >$titulo</td>
					<td width='15%' >Cantidad</td>
				</tr>
				</thead>
				<tbody>
		";
		 
		$no=0;
		
		//Variables para Graficas
		
		$cuantos=sql_nr($busca);
		
		while($datos=sql_fr($busca)){
		
			$color="#".$colores[$no];
			
			$nombre=$titulos[$datos[0]];
			
		
		//Condiciones para marcar por colores si anterior es igual a actual
			
			$respuesta.="
				<tr bgcolor='".$color."' class='desglose'>
						<td>$nombre</td>
						<td align='center'>$datos[1]</td>
						</tr>";
		
			$total+=$datos[1];
			
			$nombres[$no]=$nombre;
			
			$valores[$no]=$datos[1];
			
			$no++;
		}
		
		$respuesta.="<tr>
					<td><strong>Total</strong></td>
					<td align='center'><strong>$total</strong></td>
				</tr>
		</div>
		";
		
		$graficas=graficar($nombres,$valores);
		
		$act_grafica=$graficas[0];
		
		$graficas=$graficas[0].",".$graficas[1].",".$graficas[2];

	$respuesta.="<div id='grafica'>
						<a href='#' onclick='javascript:ver_graficas(-1)'><img src='../img/bt_ad.png' />&nbsp;&nbsp;Anterior</a>
						<a href='#' onclick='javascript:ver_graficas(1)'>&nbsp;&nbsp;&nbsp;Siguiente&nbsp;<img src='../img/bt_at.png' /></a>
						<br /><br /><img id='imagen_grafica' src='grafica/".$act_grafica.".jpg' >
					</div>";
}

else{
		
		$no=0;
		
		$respuesta="
			<table width='99%' >
			<thead>
				<tr>
				<td colspan='7'>$encabezado</td>
				</tr>
				<tr>
					<td width='7%' >Codigo</td>
					<td width='30%' >Nombre</td>
					<td width='5%' >Edad</td>
					<td width='25%' >Correo</td>
					<td width='15%' >Telefono</td>
					<td width='15%' >Celular</td>
					<td width='5%' >Status</td>
				</tr>
				</thead>
				<tbody>
		";
		while($datos=sql_fr($busca)){
			
				if($no%2==0) $color="#C5DDF1";
	
				else $color="#FFFFFF"; 
				
				$status=$titulos[$datos[8]];
				
				if($datos[8]==2)
					$codigo="
						<a href='detalle_respuestas.php?id=".$datos[0]."TB_=savedValues&TB_iframe=true&height=400&width=650' 
						title='Detalle de Respuestas Incorrectas' class='thickbox' target='_parent'>
						<strong>$datos[7]</strong>
						</a>&nbsp;
						";
					else	
						$codigo=$datos[7];

				
				
				$respuesta.="<tr bgcolor='".$color."' class='desglose'>
						<td>
								$codigo
						</td>
						<td>$datos[1]</td>
						<td align='center'>$datos[4]</td>
						<td >$datos[3]</td>
						<td >$datos[5]</td>
						<td >$datos[6]</td>
						<td >$status</td>
						</tr>";
						
			$no++;			
		}
	}	
}
else
$respuesta="
	<table width='100%' >
	<thead>
		<tr>
		<td>No Existen Registros Que Coincidan con las Condiciones Deseadas.</td>
		</tr>
		</thead>
		<tbody>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Inicio</title>
<link href="../sisadminus/estilo/reset.css" rel="stylesheet" type="text/css" />
<link href="../sisadminus/estilo/estilo.css" rel="stylesheet" type="text/css" />
<link href="../sisadminus/estilo/ie.css" rel="stylesheet" type="text/css" />

<!--[if IE]>
	<link href="estilo/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->

<script language="javascript" type="text/javascript" src="../js/cal.js"></script>

<link rel="stylesheet" href="../css/estilo_tb.css" type="text/css" media="screen" />

<script type="text/javascript" src="../js/jq.js"></script>
<script type="text/javascript" src="../js/tb.js"></script>
<script language="javascript" type="text/javascript" src="../js/cal.js"></script>


<script language="javascript" type="text/javascript">

var ID;

	addCalendar("Calendar1", "Selecciona Fecha", "T1", "form_datos");
	addCalendar("Calendar2", "Selecciona Fecha", "T2", "form_datos");
	setWidth(90, 1, 15, 1);
	setFormat("yyyy-mm-dd");


function gen_concentrado(donde){
	document.forms["form_datos"].action=donde;
	document.forms["form_datos"].submit();
}

function ver_graficas(valor,tipo){

var actual=document.forms["form_datos"].elements["actual_grafica"].value;
var graficas=document.forms["form_datos"].elements["nombre_graficas"].value;

var nombres = graficas.split(",");

var cuantos=nombres.length;

for(var i=0;i<cuantos;i++){
	
	if(nombres[i]==actual){
		
		i=i+valor;
		
		if(i==cuantos) i=0;
		
		if(i<0) i=cuantos-1;
		
		document.getElementById("imagen_grafica").src="grafica/"+nombres[i]+".jpg";

		document.forms["form_datos"].elements["actual_grafica"].value=nombres[i];
		
		break
	}
}
if(tipo=="dinamico")
	ID=window.setTimeout("ver_graficas(1,'dinamico')",5000)
else
	window.clearTimeout(ID);
	
}
</script>

</head>

<body>
<form name="form_datos" action="#" method="post">
	<fieldset style="width:99%">
	<legend><span class="form_Legend">Filtros</span></legend>
	<table border="0" class="tablas" width="100%">	
	<tr><td style="height:5px;"></td></tr>
	<tr align="left">
	<td><input name="conc" type="radio" value="1" id="r1" />				
		<span class="form">Reporte Detallado.</span> 
	</td>
	<td>		
		<span class="form">Fecha Inicial:</span> 
	</td>
	<td>
		<input name="T1" type="text" class="txt" size="10" readonly value="<?php echo $f1; ?>">
		<a href="javascript:showCal('Calendar1');" > <img src="../img/cal.png" width=24 height=22 border=0></a>
	</td>	
	<td>	
		<span class="form">Fecha Final:</span> 
	</td>
	<td>	
		<input name="T2" type="text" class="txt" size="10" readonly value="<?php echo $f2; ?>">
		<a href="javascript:showCal('Calendar2');" > <img src="../img/cal.png" width=24 height=22 border=0></a>
	</td>	
</tr>
<tr height="15px"><td></td></tr>
<tr>
<td colspan="2"><input name="conc" type="radio" value="2" id="r2"/>	
	<span class="form">Sexo :</span> &nbsp;&nbsp;
	<select name="sexo" style="width:190px;" onchange="fill(this)">
		<option value="0"  id="se0">Ambos Sexos</option>
		<option value="1" id="se1">Hombre</option>
		<option value="2" id="se2">Mujer</option>
	</select>
</td>
<td colspan="2"><input name="conc" type="radio" value="3" id="r3" />	
	<span class="form">Status :</span> &nbsp;&nbsp;
	<select name="status" style="width:190px;" onchange="fill(this)">
		<option value="0" id="st0">Todos los Status</option>
		<option value="1" id="st1">Solo Registro</option>
		<option value="2" id="st2">Contesto Incorrectamente</option>
		<option value="3" id="st3">Contesto Correctamente</option>
	</select>
</td>

</tr>
<tr height="15px"><td></td></tr>
<tr >
	<td colspan="6" align="center">
		<input name="nombre_graficas" type="hidden" value="<?php echo $graficas; ?>" />
		<input name="actual_grafica" type="hidden" value="<?php echo $act_grafica; ?>" />
		<input name="respuesta" type="hidden" value="<?php echo "$respuesta"; ?>" />
		<input name="limpia" type="button" class="txt" value="Limpiar Filtros"  onclick="javascript:limpiar();" style="width:130px;"/>
		&nbsp;&nbsp;<input name="aceptar" type="button" class="txt" value="Generar Reporte" style="width:130px;" onclick="javascript:gen_concentrado('reporte_general.php');">			
		&nbsp;&nbsp;<input name="generar_excel"  type="button" value="Exportar a Excel" style="width:130px;"  onclick="javascript:gen_concentrado('../recursos/envia_excel.php')">			
		&nbsp;&nbsp;<input name="guardar_grupo" type="button" value="Exportar a PDF" style="width:130px;" onclick="javascript:gen_concentrado('guarda_grupo.php')" disabled="disabled" >			
	</td>
</tr>	
<tr height="15px"><td></td></tr>
</table>
</fieldset>
</form>
<br />
<?php echo $respuesta; ?>
 </tbody>
 </table>	
</body>
<script language="javascript">
	
	var valor=<?php echo $conc; ?>;
	var se=<?php echo $sexo; ?>;
	var st=<?php echo $st; ?>;

	document.getElementById("r"+valor).checked="checked";
	document.getElementById("st"+st).selected="selected";
	document.getElementById("se"+se).selected="selected";
	
	if(valor!=1)
		ver_graficas(0,"dinamico");	
</script>
</html>
