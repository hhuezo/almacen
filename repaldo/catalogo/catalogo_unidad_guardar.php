<html>
<head> 
	<link rel="stylesheet" type="text/css" href="css/principal.css" />
</head>
<body>
<center>
<?php require_once('clases/conexion.php');
session_start();


//Agregar
if (isset($_GET["txt_unidad"]) && $_GET["modoop"]==1) {
$objCon=new Conexion();
$sql="INSERT INTO uni_med(nom_med) VALUES ('".$_GET["txt_unidad"]."')";

//echo $sql;

$objCon->Abrir();
$objCon->Ejecutar($sql);
echo "<img src='images/agregar.jpg' border='0'>";
$objCon->Cerrar();
}





//Modificar
if (isset($_GET["txt_unidad"]) && $_GET["modoop"]==2 && isset($_GET["id_unidad"])) {
$objCon=new Conexion();
$sql="UPDATE uni_med SET nom_med='".$_GET["txt_unidad"]."' WHERE id_um = ".$_GET['id_unidad'];

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