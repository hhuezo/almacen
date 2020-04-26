<?php
require_once('conectar/conectar.php');
session_start(); 


	$fecha= $_GET["fecha"];
	$anio=substr($fecha,6,4);
	$mes=substr($fecha,3,2);
	$dia=substr($fecha,0,2);
	$fecha=$anio.$mes.$dia;
	
	if($mes==1)
	$mes='ENERO';
	else if($mes==2)
	$mes='FEBRERO';
	else if($mes==3)
	$mes='MARZO';
	else if($mes==4)
	$mes='ABRIL';
	else if($mes==5)
	$mes='MAYO';
	else if($mes==6)
	$mes='JUNIO';
	else if($mes==7)
	$mes='JULIO';
	else if($mes==8)
	$mes='AGOSTO';
	else if($mes==9)
	$mes='SEPTIEMBRE';
	else if($mes==10)
	$mes='OCTUBRE';
	else if($mes==11)
	$mes='NOVIEMBRE';
	else if($mes==12)
	$mes='DICIEMBRE';

?> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Inventario</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>



<table width="716" border="0" align="center">
	<tr>
	  <td width="121"><div align="center"><img src="img/escudo.png" width="111" height="81" /></div></td>
	  <td colspan="3"><div align="center"><strong>INSTITUTO SALVADORE&Ntilde;O DE TRANSFORMACION AGRARIA<br>
	    SECCION DE TRANSPORTE Y TALLER MECANICO<br>
      INVENTARIO DE LUBRICANTES AL <?php echo $dia.'  ';?> DE <?php echo $mes.'  ';?>DE <?php echo $anio.'  ';?></strong></div></td>
	  <td width="116"><div align="center"><img src="img/logo.png" width="94" height="81"  /></div></td>
  </tr>
</table>
<br>
  <table width="716" align="center" border="1" cellspacing="0">
	<tr>
		<td width="27"><div align="center"><strong>ITEM</strong></div></td>
		<td width="60"><div align="center"><strong>CANTIDAD</strong></div></td>
		<td width="63"><div align="center"><strong>UNIDAD<br>
		MEDIDA</strong></div></td>
		<td width="170"><div align="center"><strong>CONCEPTO</strong></div></td>
		<td width="67"><div align="center"><strong>FACTURA</strong></div></td>
		<td width="62"><div align="center"><strong>PRECIO<br>
		UNITARIO</strong></div></td>
		<td width="60"><div align="center"><strong>TOTAL</strong></div></td>
	</tr>

<?php
	$sql="select a.id_art,u.nom_med,a.nom_art,c.nom_cuenta from articulo a 
	inner join cuenta_contable c ON a.id_cuenta = c.id_cuenta
	inner join uni_med u ON a.id_um = u.id_um
	where numero_bodega = 2 ";
	mysql_select_db($database_cnn, $cnn);
	$resultado = mysql_query($sql, $cnn) or die(mysql_error());
	$num=1;$Total = 0;
	
	  while($row=mysql_fetch_array($resultado))
		{
			$sqlDetalle ="select k.orden_compra,k.numero_factura,k.precio,k.cantidad-(select ifnull(sum(cantidad),0) 
			from kardex kar where kar.id_art=k.id_art and id_mov = 2
			and kar.orden_compra = k.orden_compra and kar.precio = k.precio and kar.fecha <= '$fecha') as cantidad
			from kardex k where id_mov = 1 and k.fecha <= '$fecha' and id_art = ".$row["id_art"];
			//echo $sqlDetalle.'<br>';
			mysql_select_db($database_cnn, $cnn);
			$resultadoDetalle = mysql_query($sqlDetalle, $cnn) or die(mysql_error());
			
			while($rowDetalle=mysql_fetch_array($resultadoDetalle))
			{
				if($rowDetalle["cantidad"]>0){
			?>
				<tr>
				<td><div align="center"><?php echo $num;?></div></td>
				<td><div align="center"><?php echo $rowDetalle["cantidad"];?></div></td>
				<td><div align="center"><?php echo $row["nom_med"];?></div></td>
				<td>&nbsp;<?php echo $row["nom_art"];?></td>
				<td><div align="center"><?php echo $rowDetalle["numero_factura"];?></div></td>
				<td><div align="right">$<?php echo number_format($rowDetalle["precio"],4);?></div></td>
				<td><div align="right">$<?php echo number_format($rowDetalle["precio"] * $rowDetalle["cantidad"],4);?></div></td>
				</tr>				
		<?php
				$Total=$Total +($rowDetalle["precio"] * $rowDetalle["cantidad"]);
				}
			
			$num++;
			}

		}
	mysql_close(); 

?>
<tr>
				  <td colspan="6"><div align="center"><strong>TOTAL GENERAL </strong></div></td>
				  <td><div align="right"><strong>$<?php echo number_format($Total,4);?></strong></div></td>
  </tr>
</table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div align="center">
    <table width="716">
      <tr>
        <td><div align="center">____________________________________________<br> 
        ENCARGADO DE LUBRICANTES</div></td>
        <td><div align="center">____________________________________________<br> 
        JEFE DE TRANSPORTE Y TALLER MECANICO</div></td>
      </tr>
    </table>
  </div>
<p>&nbsp;</p>
