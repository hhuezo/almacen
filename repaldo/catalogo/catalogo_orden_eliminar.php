<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/principal.css" />
</head>
<body>
<center>

<?php 
require_once('clases/conexion.php');
//Eliminar
if (isset($_GET["orden_compra"])) {
	$objCon=new Conexion();
	$sql = "DELETE FROM orden_compra WHERE orden_compra = ".$_GET['orden_compra'];
	$objCon->Abrir();
	$objCon->Ejecutar($sql);
	echo "<img src='images/eliminar.jpg' border='0'>";
	$objCon->Cerrar();
}
?>
</center>
</body>
</html>