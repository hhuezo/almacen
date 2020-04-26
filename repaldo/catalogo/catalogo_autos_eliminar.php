<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/principal.css" />
</head>
<body>
<center>

<?php 
require_once('clases/conexion.php');
//Eliminar
if (isset($_GET["id_auto"])) {
	$objCon=new Conexion();
	$sql = "DELETE FROM automovil WHERE id_auto = ".$_GET['id_auto'];
	$objCon->Abrir();
	$objCon->Ejecutar($sql);
	echo "<img src='images/eliminar.jpg' border='0'>";
	$objCon->Cerrar();
}
?>
</center>
</body>
</html>