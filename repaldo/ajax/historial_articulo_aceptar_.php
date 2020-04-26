<head>

<!--

-->
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<script type="text/javascript" src="Ajax/Ajax.js"></script>
<link rel="stylesheet" type="text/css" href="css/principal.css">
<link rel="stylesheet" href="../css/style.css" type="text/css" />
	<!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


    <style type="text/css">
<!--
.Style1 {
	border: thin solid #333333;
}
-->
    </style>
    </head>
<?php 
	require_once('../clases/conexion.php'); 
	require_once('../conectar/conectar.php'); 
	session_start();
	if($_GET['id_articulo'] != ''){
		$sql="select a.nom_art,c.alias,u.nom_med,a.estante,a.casilla,c.cod_cuenta from articulo a
		inner join cuenta_contable c on a.id_cuenta = c.id_cuenta
		inner join uni_med u on a.id_um = u.id_um
		where id_art = ".$_GET['id_articulo'];
		mysql_select_db($database_cnn, $cnn);
		$result = mysql_query($sql, $cnn) or die(mysql_error());
		$row=mysql_fetch_array($result);
		
		//consulta para calcular la existencia por orden de compra
		$sqlExistencia="select a.cod_agru,k.orden_compra,
		(select ifnull(sum(kar.cantidad),0) from kardex kar where kar.id_art = k.id_art and  kar.precio = k.precio  and kar.orden_compra = k.orden_compra and kar.id_mov = 1)-
		(select ifnull(sum(kar.cantidad),0) from kardex kar where kar.id_art = k.id_art and kar.precio = k.precio and kar.orden_compra = k.orden_compra and kar.id_mov = 2) as cantidad,
		precio from kardex k 
		inner join agrupacion_operacional a on k.id_agru = a.id_agru
		where k.id_art = ".$_GET['id_articulo']."
		group by k.orden_compra,k.precio";
		//echo $sqlExistencia;
		mysql_select_db($database_cnn, $cnn);
		$resultExistencia = mysql_query($sqlExistencia, $cnn) or die(mysql_error());
		
	?>
		<br>
		<center>
		<table width="946" border="1" align="center">
			<tr>
				<td width="369"><strong>ARTICULO:</strong> <u><?php echo ' '.$row["nom_art"];?></u>
				  <br><strong>CODIGO: </strong> <u><?php echo ' '.$row["cod_cuenta"];?></u>
				  <BR><strong>CUENTA CONTABLE: </strong> <u><?php echo ' '.$row["alias"];?></u>
				  <br><strong>UNIDAD DE MEDIDA:</strong> <u><?php echo ' '.$row["nom_med"];?></u>
				  <br>
					<strong>ESTANTE:</strong>  <u><?php echo ' '.$row["estante"].'    ';?> </u> &nbsp;&nbsp;&nbsp;&nbsp; <strong> CASILLA:</strong> <u><?php echo ' '.$row["casilla"];?>
				</u></td>
				<td width="16">&nbsp;&nbsp;&nbsp;</td>
				<td width="539">
					<table border="1" align="center">
						<tr class="row_k1">
						  <td colspan="9" align="center">EXISTENCIA</td>
					  </tr>
							<tr class="<?php $cont=1; echo (($cont % 2) == 0) ? 'row1' : 'row2';?>">
							<td align="center"><strong>COD AGRU</strong></td>
							<td><strong>&nbsp;&nbsp;</strong></td>
							<td align="center"><strong>ORDEN DE COMPRA</strong></td>
							<td><strong>&nbsp;&nbsp;</strong></td>
							<td align="center"><strong>CANTIDAD</strong></td>
							<td><strong>&nbsp;&nbsp;</strong></td>
							<td align="center"><strong>PRECIO</strong></td>
							<td><strong>&nbsp;&nbsp;</strong></td>
							<td align="center"><strong>TOTAL</strong></td>
						</tr>
					<?php 
						$cont++;	
						$Cantidad=0;	$Total=0;		
						while($rowExistencia=mysql_fetch_array($resultExistencia))
						{
							if($rowExistencia["cantidad"]>0){?>							
							<tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2';?>">
							<td align="center"><?php echo $rowExistencia["cod_agru"];?></td>
							<td>&nbsp;&nbsp;</td>
							<td align="center"><?php echo $rowExistencia["orden_compra"];?></td>
							<td>&nbsp;&nbsp;</td>
							<td align="center"><?php echo $rowExistencia["cantidad"];?></td>
							<td>&nbsp;&nbsp;</td>
							<td align="center">$<?php echo number_format($rowExistencia["precio"],4);?></td>
							<td>&nbsp;&nbsp;</td>
							<td align="center">$<?php echo  number_format($rowExistencia["cantidad"] * $rowExistencia["precio"],4);?></td>
							</tr>
							
							<?php
							$cont++;
							$Cantidad =$Cantidad+$rowExistencia["cantidad"];
							$Total =$Total+($rowExistencia["precio"]* $rowExistencia["cantidad"]);
							}
															
						}
						?>
						<tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2';?>">
							  <td colspan="4" align="center"><strong>TOTAL</strong></td>
							  <td align="center"><strong><?php echo $Cantidad;?></strong></td>
							  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
							  <td align="center"><strong>$<?php echo number_format($Total,4);?></strong></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
<br />
		<table width="1055" border="1" align="center" >
			<tr class="row_k1" bgcolor=#e5eecc>
				<?php if($_SESSION['id_tipo'] == 1 || $_SESSION['id_tipo'] == 2 || $_SESSION['id_tipo'] == 3){?><td width="61" align="center" class="Style1"><strong>EDITAR</strong></td><?php }?>
				<td width="56" align="center" class="Style1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;FECHA&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
				<td width="29" align="center" class="Style1"><strong>&nbsp;&nbsp;O.C&nbsp;&nbsp;</strong></td>
				<td width="45" align="center" class="Style1"><strong>&nbsp;&nbsp;FACT.&nbsp;&nbsp;</strong></td>
				<td width="62" align="center" class="Style1"><strong>AGRUP.<br>
			    OPERA.</strong></td>
				<td width="89" align="center" class="Style1"><strong>DESCARGO</strong></td>
				<td width="106" align="center" class="Style1"><strong>PROVEEDOR</strong></td>
				<td width="123" align="center" class="Style1"><strong>DESTINO</strong></td>
				<td width="85" align="center" class="Style1"><strong>CANTIDAD</strong></td>
				<td width="60" align="center" class="Style1"><strong>&nbsp;&nbsp;PRECIO&nbsp;&nbsp;</strong></td>
				<td width="53" align="center" class="Style1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;TOTAL&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
				<td width="54" align="center" class="Style1"><strong>EXIST.</strong></td>
			</tr>
			
			<?php 
			if($_GET['axo']==0)
			{
				$sql="SELECT k.id_kar,
       date_format(k.fecha, '%d/%m/%Y') as fecha,
       k.orden_compra,
       k.numero_factura,
       agru.cod_agru,
       k.descargo,
       dto.nom_dto,
       auto.equipo,
       auto.placa,
       k.cantidad,
       k.precio,
       k.total,
       k.existencia_actual,
       k.id_mov
  FROM (((almacen.agrupacion_operacional agru
          INNER JOIN almacen.kardex k ON (agru.id_agru = k.id_agru))
         INNER JOIN almacen.proveedor proveedor
            ON (proveedor.id_prov = k.id_prov))
        INNER JOIN almacen.departamento dto ON (dto.id_dto = k.id_dto))
       INNER JOIN almacen.automovil auto ON (auto.id_auto = k.id_auto)
       where k.id_art = ".$_GET['id_articulo']." order by k.id_kar desc ";
			}
			else{
				$sql="SELECT k.id_kar,
       date_format(k.fecha, '%d/%m/%Y') as fecha,
       k.orden_compra,
       k.numero_factura,
       agru.cod_agru,
       k.descargo,
       dto.nom_dto,
       auto.equipo,
       auto.placa,
       k.cantidad,
       k.precio,
       k.total,
       k.existencia_actual,
       k.id_mov
  FROM (((almacen.agrupacion_operacional agru
          INNER JOIN almacen.kardex k ON (agru.id_agru = k.id_agru))
         INNER JOIN almacen.proveedor proveedor
            ON (proveedor.id_prov = k.id_prov))
        INNER JOIN almacen.departamento dto ON (dto.id_dto = k.id_dto))
       INNER JOIN almacen.automovil auto ON (auto.id_auto = k.id_auto)
       where k.id_art = ".$_GET['id_articulo']." and k.fecha between '".$_GET['axo']."-01-01' and '".$_GET['axo']."-12-31' order by k.id_kar desc ";
			
				//echo $sql;
			}
			
			
				//echo $sql;
				mysql_select_db($database_cnn, $cnn);
				$result = mysql_query($sql, $cnn) or die(mysql_error());
				//echo $sql;
				
				while($row=mysql_fetch_array($result))
				{
					if($row["id_mov"]==1)
					{?>
					 <tr class="row_k1">
					 <?php }
					else{?>
					<tr class="<?php $cont++; echo (($cont % 2) == 0) ? 'row1' : 'row2';?>">
					<?php }?>
				<?php if($_SESSION['id_tipo'] == 1 || $_SESSION['id_tipo'] == 2 || $_SESSION['id_tipo'] == 3){?>
				<td align="center" class="Style1"><strong><a href="kardex_modificar.php?id_kar=<?php echo $row["id_kar"];?>">
				EDITAR</a></strong></td><?php }?>
				<td align="center" class="Style1"><?php echo $row["fecha"];?></td>
				<td align="center" class="Style1"><?php echo $row["orden_compra"];?></td>
				<td align="center" class="Style1"><?php echo $row["numero_factura"];?></td>
				<td align="center" class="Style1">(<?php echo $row["cod_agru"];?>)</td>
				<td align="center" class="Style1">
			    <?php if($row["id_mov"]==2){ echo $row["descargo"];}?>
				</td>
				<td align="center" class="Style1"><?php echo $row["nom_prov"];?></td>
				<td class="Style1"><div align="center"><?php echo $row["nom_dto"];?><?php echo $row["equipo"];?><?php echo '  '.$row["placa"];?></div></td>
				<td align="center" class="Style1"><?php echo $row["cantidad"];?></td>
				<td align="center" class="Style1">$<?php echo number_format($row["precio"],4);?></td>
				<td align="center" class="Style1">$<?php echo number_format($row["total"],4);?></td>
				<td align="center" class="Style1"><?php echo $row["existencia_actual"];?></td>
			</tr>	
			
		<?php 
				}
}
else{echo '';}		?>
		
	</table>
	
	</center>