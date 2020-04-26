<head>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/principal.css">
	<!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<?php require_once('../clases/conexion.php'); 
session_start();
$objCon=new Conexion();
$objCon->Abrir();

if (isset($_GET["txt_nombre"])) {
	
	//usuario de almacen
	if($_SESSION['id_tipo']==2){	
		$sql = "SELECT a.id_art, a.nom_art, 
		(select ifnull(sum(cantidad),0) from kardex k where k.id_art=a.id_art and id_mov=1)-	
		(select ifnull(sum(cantidad),0) from kardex k where k.id_art=a.id_art and id_mov=2) as existencia,
		c.alias
		FROM articulo a
		LEFT OUTER JOIN cuenta_contable c ON a.id_cuenta=c.id_cuenta
		where a.estado='activo' and numero_bodega = 1 and a.nom_art like'%".$_GET['txt_nombre']."%'"; 
	}
	//usuario de taller
	else if($_SESSION['id_tipo']==3){	
		$sql = "SELECT a.id_art, a.nom_art, 
		(select ifnull(sum(cantidad),0) from kardex k where k.id_art=a.id_art and id_mov=1)-	
		(select ifnull(sum(cantidad),0) from kardex k where k.id_art=a.id_art and id_mov=2) as existencia,
		c.alias
		FROM articulo a
		LEFT OUTER JOIN cuenta_contable c ON a.id_cuenta=c.id_cuenta
		where a.estado='activo' and numero_bodega = 2 and a.nom_art like'%".$_GET['txt_nombre']."%'"; 
	}
	// otros usuarios
	else{	
		$sql = "SELECT a.id_art, a.nom_art, 
		(select ifnull(sum(cantidad),0) from kardex k where k.id_art=a.id_art and id_mov=1)-	
		(select ifnull(sum(cantidad),0) from kardex k where k.id_art=a.id_art and id_mov=2) as existencia,
		c.alias
		FROM articulo a
		LEFT OUTER JOIN cuenta_contable c ON a.id_cuenta=c.id_cuenta
		where a.estado='activo' and a.nom_art like'%".$_GET['txt_nombre']."%'";  
	}
//echo $sql;

$objCon->RetornarRS($result, $sql);
  if ($objCon->ExisteRegistro($sql)){?>
<table border='0' align='center' >
<tr class="row1" bgcolor=#e5eecc><td align="center"><b>ARTICULO</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="center"><b>CUENTA</b></td>
  <?php
	$cont=1;
	  while($rs = $result->fetch_array())
		{?>
		<tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2';?>">
		<td><a href="#" onClick="javascript:articuloSelect('<?php echo $rs[0];?>','<?php echo $rs[1];?>','<?php echo $rs[2];?>');"><?php echo $rs[1];?> 
		</a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><?php echo $rs[3];?></td>
		<?php
		$cont++;
		}
	  }
	else{
	echo "<center><img src='images/error.jpg'></center>";
	}	  
  $result->free();  
  $objCon->Cerrar();	  
}
?>

