<html>
<head> 
	<link rel="stylesheet" type="text/css" href="css/principal.css" />
</head>
<body>
<center>
<?php 
require_once('clases/conexion.php');
session_start();

$fecha=$_GET["txt_fecha"];

if($_GET["id_auto"] > 0)
{$id_auto=$_GET["id_auto"];}
else{$id_auto=0;}

if($_GET["id_departamento"] > 0)
{$id_dto=$_GET["id_departamento"];}
else{$id_dto=0;}


//Agregar
if ($_GET["modoop"]==1 ) {
$objCon=new Conexion();

$sql="INSERT INTO descargo(descargo, fecha, id_dto, id_auto,id_usuario,NumBodega)
VALUES('".$_GET["descargo"]."', '$fecha',$id_dto,$id_auto,".$_GET["id_usuario"].",".$_GET["cmb_bodega"].")";

//echo $sql;

$objCon->Abrir();
$objCon->Ejecutar($sql);
echo "<img src='images/agregar.jpg' border='0'>";
$objCon->Cerrar();
}


//Modificar
if ($_GET["modoop"]==2 ) {

$objCon=new Conexion();

$sql="UPDATE descargo
	set descargo=".$_GET["descargo"].",
    fecha='$fecha',
    id_dto=$id_dto,
    id_auto=$id_auto,
	id_usuario = ".$_GET["id_usuario"].",
	NumBodega = ".$_GET["cmb_bodega"].",
	descargo = ".$_GET["descargo"]."
	WHERE descargo = ".$_GET["descargoTemp"]."";
//echo $sql;

$objCon->Abrir();
$objCon->Ejecutar($sql);
if($id_dto>0)
{
	$sql="UPDATE kardex
	set descargo=".$_GET["descargo"].",
    fecha='$fecha',
    id_dto=$id_dto,
    id_auto=$id_auto,
	descargo = ".$_GET["descargo"]."
	WHERE descargo = ".$_GET["descargoTemp"]."";
}
else{
	$sql="UPDATE kardex
	set descargo=".$_GET["descargo"].",
    fecha='$fecha',
    id_dto=$id_dto,
	descargo = ".$_GET["descargo"]."
	WHERE descargo = ".$_GET["descargoTemp"]."";
}
$objCon->Ejecutar($sql);
//echo $sql;
echo "<img src='images/modificar.jpg' border='0'>";
$objCon->Cerrar();

}
?>
</center>
</body>
</html>