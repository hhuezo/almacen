<?php
session_start();
require_once('clases/conexion.php'); 
header("Content-Type: application/vnd.ms-excel");

header("Expires: 0");

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("content-disposition: attachment;filename=Reportes.xls");

$var_id_cuenta  = $_REQUEST['cuenta'];
//$var_nom_cuenta = $_REQUEST['nom_cuenta'];

$sql ="select * from cuenta_contable where id_cuenta = $var_id_cuenta";

//echo $sql; 

$objCon=new Conexion();
$objCon->Abrir();
$objCon->RetornarRS($result, $sql);
  if ($objCon->ExisteRegistro($sql)){
	  while($rs = $result->fetch_array())
			{
			$nom_cuenta=$rs[2];
			}
	}		



			
  
  

$total_general=0;

/*$sql_cuentas="SELECT c.id_cuenta, c.nom_cuenta
FROM kardex k
JOIN articulo a ON k.id_art = a.id_art JOIN cuenta_contable c ON a.id_cuenta = c.id_cuenta
WHERE k.id_mov =1 and k.disponible>0
GROUP BY c.id_cuenta, c.nom_cuenta*/


  

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>inventario</title>
<style type="text/css">
<!--
.texto {
	font-family: "Arial Black", Gadget, sans-serif;
	color: #000;
	font-size: 12px;
}
.texto2 {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	color: #222;
	font-size: 12px;
}
-->
</style>
</head>
<body>

<table width="60%" border="1" align="center">
  <tr>
    <td colspan="5"><p align="center" class="texto">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA<br>
    								  INVENTARIO DE EXISTENCIAS DE BIENES DE CONSUMO<br>
                                      ALMACEN DE BIENES EN EXISTENCIA<br>
                                      INVENTARIO DE <?php echo $nom_cuenta;?><br>
									  AL <?php
        // Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1
        date_default_timezone_set('UTC');
        //Imprimimos la fecha actual dandole un formato
        echo date("d/m/Y");									  
									  
									  ?>
                                    
    </p></td>
  </tr>
  <tr>
    <td width="9%"><p align="center" class="texto">UNIDAD DE <br>MEDIDA</p></td>
    <td width="52%"><p align="center" class="texto">DESCRIPCIÓN</p></td>
    <td width="13%"><p align="center" class="texto">CANT.</p></td>
    <td width="10%"><p align="center" class="texto">PRECIO<br>UNITARIO</p></td>
   
    <td width="7%"><p align="center" class="texto">TOTAL</p></td>
  </tr>
  <?php
$objCon1=new Conexion();
$objCon1->Abrir();
$sql1= "CALL spGeneraInventarioExistencias($var_id_cuenta)";

//echo $sql1;

$objCon1->RetornarRS($result1, $sql1);
$total_general=0;
  if ($objCon1->ExisteRegistro($sql1)){
	  while($rs1 = $result1->fetch_array())
	 {
		  $total_general= $total_general + $rs1[4];
		 
		 ?>
	  <tr>
			<td class="texto2"><center><?php echo $rs1[0];?></center></td><td class="texto2"><?php echo $rs1[1];?></td> 
			<td class="texto2"><center><?php echo $rs1[2];?></center></td> <td class="texto2" align='right'><?php echo number_format($rs1[3],4);?></td>  <td class="texto2" align='right'><?php echo number_format($rs1[4],4);?></td>
		</tr>
	  

	  
	  <?php 
	  }
  }
  

?>
  <tr>
  <td></td><td><center><b>TOTAL</b></center></td><td></td><td></td><td class="texto"><?php echo number_format($total_general,4);?></td>
  </tr>
</table>






</body>
</html>