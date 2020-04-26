<?php require_once('../clases/conexion.php'); 
session_start();
$orden_compra=$_GET['orden_compra'];

if ($orden_compra!=""){
$sql ="SELECT count(*) as cuenta FROM kardex k where orden_compra=$orden_compra";
//echo $sql; 

$objCon=new Conexion();
$objCon->Abrir();
$objCon->RetornarRS($result, $sql);
  if ($objCon->ExisteRegistro($sql)){
	  while($rs = $result->fetch_array())
		{
		$cuenta=$rs[0];
		}
  $result->free();  
  $objCon->Cerrar();	 
}

if ($cuenta>=1){
	echo "<center><img src='images/ya_existe_orden_compra.jpg'></center>";
}  
}
?>
