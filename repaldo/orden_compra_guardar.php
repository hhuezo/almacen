<?php
	require_once('clases/conexion.php');
	$objCon=new Conexion();
	$objCon->Abrir();
	$sql="update orden_compra SET id_estatus = 1 where orden_compra = ".$_GET['orden_compra'];
	$objCon->Ejecutar($sql);
	//echo $sql;
	echo "<center><img src='images/guardar.png' border='0'></center>";
	$objCon->Cerrar();		
 ?>