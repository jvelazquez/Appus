<?php
$respuesta=$_POST["respuesta"];

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte.xls");

echo $respuesta;
?> 