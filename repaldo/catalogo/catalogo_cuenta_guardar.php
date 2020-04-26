<html>
<head> 
	<link rel="stylesheet" type="text/css" href="css/principal.css" />
</head>
<body>
<center>
<?php require_once('clases/conexion.php');
session_start();


//Agregar
if (isset($_GET["txt_cuenta"]) && $_GET["modoop"]==1) {
$objCon=new Conexion();
$sql="INSERT INTO cuenta_contable(nom_cuenta,cod_cuenta,alias) VALUES ('".$_GET["txt_cuenta"]."','".$_GET["txt_codigo"]."','".$_GET["txt_alias"]."')";

//echo $sql;

$objCon->Abrir();
$objCon->Ejecutar($sql);
echo "<img src='images/agregar.jpg' border='0'>";
$objCon->Cerrar();
}





//Modificar
if (isset($_GET["txt_cuenta"]) && $_GET["modoop"]==2 && isset($_GET["id_cuenta"])) {
	$objCon=new Conexion();
	$sql="UPDATE cuenta_contable SET nom_cuenta='".$_GET["txt_cuenta"]."',
	cod_cuenta='".$_GET["txt_codigo"]."',
	alias='".$_GET["txt_alias"]."'
	WHERE id_cuenta = ".$_GET['id_cuenta'];

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