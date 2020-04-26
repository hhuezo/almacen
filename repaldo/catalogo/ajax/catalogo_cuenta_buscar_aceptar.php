<head>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="css/principal.css">
	<!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<?php require_once('../clases/conexion.php'); 

$objCon=new Conexion();
$objCon->Abrir();

if (isset($_GET["txt_nombre"])) {
  $sql = "SELECT id_cuenta,cod_cuenta,nom_cuenta,alias FROM cuenta_contable where nom_cuenta like '%".$_GET['txt_nombre']."%'";

$objCon->RetornarRS($result, $sql);
  if ($objCon->ExisteRegistro($sql)){?>
<table border='0' align='center' >
<tr class="row1" bgcolor=#e5eecc>
	<td><b>Codigo</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><b>Cuenta</b></td>
</tr>  
  <?php
	$cont=1;
	  while($rs = $result->fetch_array())
		{?>
		<tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2';?>">
		<td><a href="#" onClick="javascript:cuentaSelect('<?php echo $rs[0];?>','<?php echo $rs[1];?>','<?php echo $rs[2];?>','<?php echo $rs[3];?>');"><?php echo $rs[1]; ?>
		</a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><?php echo $rs[2];?></td>
		</tr>
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

