<head>

<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/principal.css">
<script type="text/javascript" src="Ajax/Ajax.js"></script>

<link rel="stylesheet" type="text/css" href="css/style_kardex.css">

	<!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php require_once('../clases/conexion.php'); 

session_start();
if (!isset($_SESSION['username'])){ 
	header("Location: index.php"); 
	exit();
} 

$id_usuario=$_SESSION['id_usuario'];

$id_art=$_GET['id_articulo'];
$cantidad=$_GET['cantidad'];
$precio=$_GET['precio'];
$fecha='STR_TO_DATE(\''.$_GET["fecha"].'\',\'%d/%m/%Y\')';
$orden=$_GET['orden_compra'];
$agru=$_GET['id_agru'];
$prov=$_GET['id_proveedor'];
$factura=$_GET['txt_factura'];
$uso=$_GET['uso'];


$objCon=new Conexion();
$objCon->Abrir();

	//verificanco si ya existe una orden de compra con el numero ingresado
	$sql="SELECT count(*) as cuenta FROM orden_compra o where orden_compra='$orden'";
	//echo $sql."<br/>";
	$objCon->RetornarRS($result, $sql);
	  if ($objCon->ExisteRegistro($sql)){
		while($rs = $result->fetch_array()){
			$cuenta=$rs[0];		
		}
	  }

	//insertando orden de compras
	if ($cuenta==0){
		$sql_orden="INSERT INTO orden_compra(orden_compra,fecha,id_prov,id_agru,para_uso,id_estatus, id_usuario)
			VALUES('$orden',$fecha,$prov,$agru,'$uso',0,$id_usuario)";
			//echo $sql_orden."<br />";
			$objCon->Ejecutar($sql_orden);
	}


	// Insertando registros en la base de datos de mysql
	$sql="INSERT INTO kardex(id_art,orden_compra,descargo,para_uso,fecha,precio,cantidad,id_mov,total,id_agru,id_prov,id_dto,id_auto,numero_factura,existencia_actual)
	VALUES($id_art,'$orden',0,'$uso',$fecha,$precio,$cantidad,1,$precio*$cantidad,$agru,$prov,0,0,'$factura',
	(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 1)-
	(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 2)+ $cantidad)";
	//echo $sql."<br />";
	$objCon->Ejecutar($sql);


		//mostrando resultado
	$sql = "SELECT k.id_kar,a.id_art,a.nom_art,u.nom_med,k.cantidad,k.precio,total FROM kardex k
	INNER JOIN articulo a ON k.id_art = a.id_art
	LEFT JOIN departamento d ON k.id_dto = d.id_dto
	LEFT JOIN automovil auto ON auto.id_auto = k.id_auto
	LEFT JOIN uni_med u ON a.id_um = u.id_um
	where k.orden_compra = '$orden' and k.id_mov=1 order by id_kar desc";


	$objCon->RetornarRS($result, $sql);
	  if ($objCon->ExisteRegistro($sql)){?>
	<table border="1" cellspacing="20" align="center" >
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
			  <tr class="row1" bgcolor=#e5eecc>
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
  
?>
