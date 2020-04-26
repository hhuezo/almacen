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

//Agregar
if ($_GET["modoop"]==1 ) {
$objCon=new Conexion();

$sql="INSERT INTO orden_compra(orden_compra, fecha, id_prov, para_uso,id_usuario,id_agru)
VALUES(".$_GET["orden_compra"].", '$fecha', ".$_GET["id_proveedor"].",'".$_GET["txt_uso"]."',".$_GET["id_usuario"].",".$_GET["cmb_agrupacion"].")";

//echo $sql;

$objCon->Abrir();
$objCon->Ejecutar($sql);
echo "<img src='images/agregar.jpg' border='0'>";
$objCon->Cerrar();
}


//Modificar
if ($_GET["modoop"]==2 ) {

$objCon=new Conexion();

$sql="UPDATE orden_compra
	set orden_compra='".$_GET["orden_compra"]."',
    fecha='$fecha',
    id_prov=".$_GET["id_proveedor"].",
    para_uso='".$_GET["txt_uso"]."',
	id_usuario = ".$_GET["id_usuario"].",
	id_agru = ".$_GET["cmb_agrupacion"]."
	WHERE  orden_compra = '".$_GET["ordenTemp"]."'";
//echo $sql.'<br>';
$objCon->Abrir();
$objCon->Ejecutar($sql);

$sql="UPDATE kardex set orden_compra='".$_GET["orden_compra"]."',
 fecha='$fecha' WHERE id_mov = 1 and  orden_compra = '".$_GET["ordenTemp"]."'";
 //echo $sql.'<br>';
$objCon->Ejecutar($sql);

$sql="UPDATE kardex set id_agru=".$_GET["cmb_agrupacion"]." where  orden_compra = '".$_GET["ordenTemp"]."'";
//echo $sql.'<br>';
$objCon->Ejecutar($sql);

$sql="UPDATE kardex set orden_compra=".$_GET["orden_compra"]." where  orden_compra = '".$_GET["ordenTemp"]."'";
//echo $sql.'<br>';
$objCon->Ejecutar($sql);


//echo $sql;
echo "<img src='images/modificar.jpg' border='0'>";
$objCon->Cerrar();

}
?>
</center>
</body>
</html>