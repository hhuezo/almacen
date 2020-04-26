<?php
session_start();
require_once('conectar/conectar.php'); 


header("Content-Type: application/vnd.ms-excel");

header("Expires: 0");

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("content-disposition: attachment;filename=ReporteOficina.xls");


$var_id_dto  = $_REQUEST['id_departamento'];
$var_fecha_ini=$_REQUEST['fecha_ini'];
$var_fecha_fin=$_REQUEST['fecha_fin'];

$fecha_inicial='STR_TO_DATE(\''.$_REQUEST["fecha_ini"].'\',\'%d/%m/%Y\')';
$fecha_final='STR_TO_DATE(\''.$_REQUEST["fecha_fin"].'\',\'%d/%m/%Y\')';



/*
$sql_fechas = "select month($fecha_inicial) as MesInicial,month($fecha_final) as MesFinal, Year($fecha_inicial) as AxoInicial, Year($fecha_final) as Mesfinal";
mysql_select_db($database_cnn, $cnn);
$resultadoFechas = mysql_query($sql_fechas, $cnn) or die(mysql_error());
*/



//consulta para el while de productos
$sql = "SELECT dto.nom_dto,a.nom_art, uni.nom_med,month(k.fecha) as Mes,Year(k.fecha) as Axo,k.precio,sum(cantidad)as total_producto, sum(cantidad) * k.precio as total  FROM kardex k
INNER JOIN articulo a ON k.id_art = a.id_art
INNER JOIN uni_med uni ON a.id_um= uni.id_um
LEFT JOIN departamento dto ON k.id_dto = dto.id_dto
where k.id_dto = $var_id_dto and (k.fecha between $fecha_inicial and $fecha_final) 
GROUP BY Axo,Mes,a.id_art,precio order by Axo,Mes,a.id_art,precio desc ";
//echo $sql;
mysql_select_db($database_cnn, $cnn);
$resultado = mysql_query($sql, $cnn) or die(mysql_error());

$sql2="select * from departamento where id_dto=$var_id_dto";
mysql_select_db($database_cnn, $cnn);
$resultado2 = mysql_query($sql2, $cnn) or die(mysql_error());
$row2=mysql_fetch_array($resultado2);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>reporte_oficina</title>
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
 


<link href="css/texto_p.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table align="right" border="0"><tr>
<td><a href="reporte_oficina.php"><img src="img/atras.png"><br>
<p class="texto">ATRAS</p>
</td></tr>
</table>

<p><strong>REPORTE DE GASTOS POR OFICINA</strong></p>
<table width="58%" border="1" align="center">
    <td><center><img src="img/logo.png" height="108"></center>
    <td colspan="4" align="center"><p><span class="texto">NOMBRE DE DEPARTAMENTO:</span><br> 
   	    <span class="texto2"><?php echo $row2["nom_dto"];?></span></p><br>
	  <span class="texto">DEL <?php echo $var_fecha_ini?> AL <?php echo $var_fecha_fin?></span> <br>    
    </td>
  <tr>
  <td width="5%"><strong><P>MES</P></strong></td>
    <td width="65%"><strong><P>PRODUCTO</P></strong></td>
    <td width="19%"><strong>
      <P>UNI. MED</P></strong></td>
    <td width="16%"><strong><P>CANTIDAD</P></strong></td>
	<td width="16%"><strong><P>PRECIO</P></strong></td>
	<td width="16%"><strong><P>TOTAL</P></strong></td>
  </tr>
  <?php
  $total_general =0;
  while($row=mysql_fetch_array($resultado)){
  	$total_general = $total_general + $row["total"];
  ?>
  <tr class="texto2">
  <td align="center"><?php echo $row["Mes"];?> - <?php echo $row["Axo"];?></td>
    <td><?php echo chao_tilde($row["nom_art"]);?></td>
    <td><center><?php echo $row["nom_med"];?></center></td>
    <td><center><?php echo $row["total_producto"];?></center></td>
	<td><center><?php echo $row["precio"];?></center></td>
	<td><center><?php echo $row["total"];?></center></td>
  </tr>
  <?php
	
  } ?>
  
 <!-- <tr ><td colspan="5" align = "center">TOTAL </td>
  <td ><?php //echo $total_general?></td></tr>-->
  
</table>
<blockquote>&nbsp;</blockquote>
</body>
</html>