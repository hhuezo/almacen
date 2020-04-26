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

//$var_id_dto  = $_REQUEST['id_dto'];
$var_fecha_ini=$_REQUEST['fecha_ini'];
$var_fecha_fin=$_REQUEST['fecha_fin'];

$fecha_inicial='STR_TO_DATE(\''.$_REQUEST["fecha_ini"].'\',\'%d/%m/%Y\')';
$fecha_final='STR_TO_DATE(\''.$_REQUEST["fecha_fin"].'\',\'%d/%m/%Y\')';

$sql_departamento ="select Distinct k.id_dto, d.nom_dto from kardex k inner join departamento d ON k.id_dto = d.id_dto 
where k.id_dto >0 and  (k.fecha between $fecha_inicial and $fecha_final) order by id_dto";
mysql_select_db($database_cnn, $cnn);
$resultado_departamento = mysql_query($sql_departamento, $cnn) or die(mysql_error());
?>
<table border="1">
<?php
while($row_departamento=mysql_fetch_array($resultado_departamento)){
?>
  <tr>
  <td colspan="6" align="center"><b>ALMACEN DE BIENES EN EXISTENCIA <br> REPORTE DE GASTOS POR OFICINA DEL 
 <?php echo $var_fecha_ini; ?> AL <?php echo $var_fecha_fin; ?><br> 
 OFICINA: <?php echo $row_departamento["nom_dto"];?></b></td>
  </tr>
      
  <?php
	$id_dto = $row_departamento["id_dto"];
	
	$sql_detalle = "select  year(k.fecha) as Anio, Month(k.fecha) as Mes,d.nom_dto,a.nom_art ,u.nom_med,sum(k.cantidad) as cantidad,k.precio, k.total 
from kardex k inner join articulo a ON k.id_art = a.id_art
inner join uni_med u ON a.id_um = u.id_um
inner join cuenta_contable c ON a.id_cuenta = c.id_cuenta
inner join departamento d ON k.id_dto = d.id_dto 
where k.id_mov = 2 and k.id_dto = $id_dto and  (k.fecha between $fecha_inicial and $fecha_final) 
group by Anio,Mes,k.id_art,k.precio order by Anio,Mes,k.id_art
";  
	mysql_select_db($database_cnn, $cnn);
	$resultado_detalle = mysql_query($sql_detalle, $cnn) or die(mysql_error());
	$Total_departamento = 0;
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
	$Total_departamento = $Total_departamento +  $row_detalle["total"];
	

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
		echo '<tr><td colspan="5" align="right">TOTAL MENSUAL</td><td>$'.number_format($Total_mensual,4).'</td></tr>';	
		echo '<tr><td colspan="5" align="right"><b>TOTAL POR DEPARTAMENTO</b></td><td><b> $ '.number_format($Total_departamento,4).'</b></td></tr>';
		
	}

  ?>