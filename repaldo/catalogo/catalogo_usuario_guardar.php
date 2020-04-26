<html>
<head> 
	<link rel="stylesheet" type="text/css" href="css/principal.css" />
</head>
<body>
<center>
<?php 
require_once('clases/conexion.php');
session_start();

$txt_usuario=$_GET["txt_usuario"];
$txt_clave=$_GET["txt_clave"];
$id_rol=$_GET["id_rol"];

//Agregar
if ($_GET["modoop"]==1 ) {
	$objCon=new Conexion();

	$sql="INSERT INTO usuarios(username, password, id_tipo,estado)
	VALUES('$txt_usuario', '$txt_clave', '$id_rol','1')";

	//echo $sql;

	$objCon->Abrir();
	$objCon->Ejecutar($sql);
	echo "<img src='images/agregar.jpg' border='0'>";
	$objCon->Cerrar();
}


//Modificar
if ($_GET["modoop"]==2 ) {

	$objCon=new Conexion();

	$sql="UPDATE usuarios
	set username='$txt_usuario',
	password='$txt_clave',
	id_tipo=$id_rol,
	estado='".$_GET["cmb_estado"]."'
	WHERE id_usuario= ".$_GET["id_usuario"];

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