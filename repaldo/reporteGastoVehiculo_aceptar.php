<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>reporte_oficina</title>
</head>

<?php
session_start();
require_once('conectar/conectar.php'); 

header("Content-Type: application/vnd.ms-excel");

header("Expires: 0");

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("content-disposition: attachment;filename=ReporteOficina.xls");


$var_fecha_ini=$_REQUEST['fecha_ini'];
$var_fecha_fin=$_REQUEST['fecha_fin'];

$fecha_inicial='STR_TO_DATE(\''.$_REQUEST["fecha_ini"].'\',\'%d/%m/%Y\')';
$fecha_final='STR_TO_DATE(\''.$_REQUEST["fecha_fin"].'\',\'%d/%m/%Y\')';

$sql_automovil ="select Distinct k.id_auto,a.equipo,a.placa from kardex k inner join automovil a ON k.id_auto = a.id_auto 
where k.id_auto >0 and  (k.fecha between $fecha_inicial and $fecha_final) order by id_auto";
mysql_select_db($database_cnn, $cnn);
$resultado_automovil = mysql_query($sql_automovil, $cnn) or die(mysql_error());
//echo $sql_automovil;
?>
<table border="1">
<?php
while($row_automovil=mysql_fetch_array($resultado_automovil)){
?>
  <tr>
  <td colspan="6" align="center"><b>ALMACEN DE BIENES EN EXISTENCIA <br> REPORTE DE GASTOS POR AUTOMOVIL DEL 
 <?php echo $var_fecha_ini; ?> AL <?php echo $var_fecha_fin; ?><br> 
 EQUIPO: <?php echo $row_automovil["equipo"];?> PLACA: <?php echo $row_automovil["placa"];?> </b></td>
  </tr>
      
  <?php
	$id_auto = $row_automovil["id_auto"];
	
	$sql_detalle = "select  year(k.fecha) as Anio, Month(k.fecha) as Mes,d.equipo,a.nom_art ,u.nom_med,
	sum(k.cantidad) as cantidad,k.precio, k.total 
from kardex k inner join articulo a ON k.id_art = a.id_art
inner join uni_med u ON a.id_um = u.id_um
inner join cuenta_contable c ON a.id_cuenta = c.id_cuenta
inner join automovil d ON k.id_auto = d.id_auto 
where k.id_mov = 2 and k.id_auto = $id_auto and  (k.fecha between $fecha_inicial and $fecha_final) 
group by Anio,Mes,k.id_art,k.precio order by Anio,Mes,k.id_art
";  
	mysql_select_db($database_cnn, $cnn);
	$resultado_detalle = mysql_query($sql_detalle, $cnn) or die(mysql_error());
	$Total_automovil = 0;
	$Var_mes=0;
	$Var_anio=0;
	$Total_mensual=0;
	?>
	<tr>
			<td align="center">FECHA</td>
			<td align="center">ARTICULO</td>
			<td align="center">U/M</td>
			<td align="center">CANTIDAD</td>
			<td align="center">PRECIO</td>
			<td align="center">TOTAL</td>
		</tr>	
	<?php
	
	
	while($row_detalle=mysql_fetch_array($resultado_detalle)){
	$Total_automovil = $Total_automovil +  $row_detalle["total"];
	

	if($Var_mes >0 && $Var_mes!=$row_detalle["Mes"] && $Var_anio= $row_detalle["Anio"])
		{
			echo '<tr><td colspan="5" align="right">TOTAL MENSUAL</td><td>$'.number_format($Total_mensual,4).'</td></tr>';
			$Total_mensual = 0;
		}
		
		?>
		<tr>
			<td align="center"><?php echo $row_detalle["Mes"];?>-<?php echo $row_detalle["Anio"];?></td>
			<td width="60%"><?php echo $row_detalle["nom_art"];?></td>
			<td align="center"><?php echo $row_detalle["nom_med"];?></td>
			<td align="center"><?php echo $row_detalle["cantidad"];?></td>
			<td align="right">$ <?php echo  number_format($row_detalle["precio"],4);?></td>
			<td align="right">$ <?php echo  number_format($row_detalle["total"],4);?></td>
		</tr>	
	<?php
		//echo '<tr><td>'.$Var_mes.'<td><tr>';
		$Var_mes=$row_detalle["Mes"];
		$Total_mensual = $Total_mensual + $row_detalle["total"];
		//echo '<tr><td>'.$Var_mes.'<td><tr>';
		}
		echo '<tr><td colspan="5" align="right">TOTAL MENSUAL</td><td  align="right">$'.number_format($Total_mensual,4).'</td></tr>';	
		echo '<tr><td colspan="5" align="right"><b>TOTAL POR EQUIPO</b></td><td  align="right"><b> $ '.number_format($Total_automovil,4).'</b></td></tr>';
		
	}

  ?>