<head>

<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/principal.css">
<script type="text/javascript" src="Ajax/Ajax.js"></script>
	<!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php require_once('../clases/conexion.php'); 

session_start();

$orden=$_GET['orden_compra'];
if($orden!=''){

$sql = "SELECT k.id_kar,a.id_art,a.nom_art,u.nom_med,k.cantidad,k.precio,total FROM kardex k
INNER JOIN articulo a ON k.id_art = a.id_art
LEFT JOIN departamento d ON k.id_dto = d.id_dto
LEFT JOIN automovil auto ON auto.id_auto = k.id_auto
LEFT JOIN uni_med u ON a.id_um = u.id_um
where k.orden_compra = $orden and k.id_mov=1 order by id_kar desc";

$objCon=new Conexion();
$objCon->Abrir();
$objCon->RetornarRS($result, $sql);
  if ($objCon->ExisteRegistro($sql)){?>
<table border='0' align='center' >
  <tr class="row2" bgcolor=#e5eecc>
    <td align="center"><strong>ARTICULO</strong></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="center"><strong>UNI. MED</strong></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td align="center"><strong>CANTIDAD</strong></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td align="center"><strong>PRECIO</strong></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="center"><strong>TOTAL</strong></td>
  </tr>


  <?php
	  $cont=0;
	  $total=0;
	  while($rs = $result->fetch_array())
		{?>
		<tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2';?>">
		<td><?php echo $rs[2]; ?></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><?php echo $rs[3]; ?></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='center'><?php echo number_format($rs[4],0); ?></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='right'>$<?php echo number_format($rs[5],5); ?></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align='right'>$<?php echo number_format($rs[6],5); ?></td>
		</tr>
		<?php
		$total = $total + $rs[6];
		$cont++;
		}
		?>
		  <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2';?>">
    <td colspan='8' align="center"><strong>TOTAL</strong></td>
    <td><strong>$<?php echo number_format($total,5);?></strong></td>
  </tr>
  </table>
		<?php
		
	  }
	  else{
	echo "";
	}
	$result->free();  
	$objCon->Cerrar();
}
	
?>
