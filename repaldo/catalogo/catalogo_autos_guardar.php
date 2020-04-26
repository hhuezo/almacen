<html>
<head> 
	<link rel="stylesheet" type="text/css" href="css/principal.css" />
</head>
<body>
<center>
<?php 
require_once('clases/conexion.php');
session_start();

$auto=$_GET["txt_auto"];
$equipo=$_GET["equipo"];
$placa=$_GET["placa"];
$id_marca=$_GET["id_marca"];
$marca=$_GET["txt_marca"]; 

$id_departamento=$_GET["id_departamento"];

//Agregar
if ($_GET["modoop"]==1 ) {
$objCon=new Conexion();

$sql="INSERT INTO automovil(equipo, placa, id_marca, detalle,id_dto)
VALUES('$equipo', '$placa', $id_marca,'$auto','$id_departamento')";

//echo $sql;

$objCon->Abrir();
$objCon->Ejecutar($sql);
echo "<img src='images/agregar.jpg' border='0'>";
$objCon->Cerrar();
}


//Modificar
if ($_GET["modoop"]==2 ) {

$objCon=new Conexion();

$sql="UPDATE automovil
  set equipo='$equipo',
    placa='$placa',
    id_marca=$id_marca,
    detalle='$auto',
	id_dto = '$id_departamento'
WHERE id_auto=".$_GET["id_auto"];

//echo $sql;

$objCon->Abrir();
$objCon->Ejecutar($sql);
echo "<img src='images/modificar.jpg' border='0'>";
$objCon->Cerrar();

}
?>
</center>
</body>
</html>