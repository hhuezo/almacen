<html>
<head> 
	<link rel="stylesheet" type="text/css" href="css/principal.css" />
</head>
<body>
<center>
<?php require_once('clases/conexion.php');
session_start();


//Agregar
if (isset($_GET["txt_marca"]) && $_GET["modoop"]==1) {
$objCon=new Conexion();
$sql="INSERT INTO marca(nombre_marca) VALUES ('".$_GET["txt_marca"]."')";

//echo $sql;

$objCon->Abrir();
$objCon->Ejecutar($sql);
echo "<img src='images/agregar.jpg' border='0'>";
$objCon->Cerrar();
}





//Modificar
if (isset($_GET["txt_marca"]) && $_GET["modoop"]==2 && isset($_GET["id_marca"])) {
$objCon=new Conexion();
$sql="UPDATE marca SET nombre_marca='".$_GET["txt_marca"]."' WHERE id_marca = ".$_GET['id_marca'];

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