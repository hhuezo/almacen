<?php 
session_start();
require_once('clases/conexion.php'); 
	
	$objCon=new Conexion();	
	$sql="update descargo set id_estatus = 1 where id_usuario = ".$_SESSION['id_usuario'];
	$objCon->Abrir();
	$objCon->Ejecutar($sql);
	$_SESSION['descargo'] = '';
	echo "<img src='images/agregar.jpg' border='0'>";
	$objCon->Cerrar();
?>