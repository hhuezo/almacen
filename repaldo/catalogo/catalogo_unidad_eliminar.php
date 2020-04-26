<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/principal.css" />
</head>
<body>
<center>

<?php 
require_once('clases/conexion.php');
//Eliminar
if (isset($_GET["id_unidad"])) {
	$objCon=new Conexion();
	$sql = "DELETE FROM uni_med WHERE id_um = ".$_GET['id_unidad'];
	$objCon->Abrir();
	$objCon->Ejecutar($sql);
	echo "<img src='images/eliminar.jpg' border='0'>";
	$objCon->Cerrar();
}
?>
</center>
</body>
</html>