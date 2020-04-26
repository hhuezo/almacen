<?php 
	require_once('clases/conexion.php'); 
	session_start();
	$objCon=new Conexion();
	$objCon->Abrir();
	if(!isset($_GET["descargo"]) || $_GET["descargo"] == '')
	{
		 $_GET["descargo"] = $_SESSION['descargo'];
	}
	
	
	
	$sql_head="  select date_format(d.fecha, '%d/%m/%Y') as fecha,	a.id_auto,a.detalle,a.equipo,a.placa,dto.nom_dto,
	(select max(NumSolicitud) from kardex kar where kar.descargo = ".$_GET['descargo'].") as solicitud,
    (select dep.nom_dto from departamento dep where dep.id_dto = d.id_dto ) as dto
	from descargo d 
	left join automovil a ON a.id_auto = d.id_auto
    left join departamento dto ON a.id_dto = dto.id_dto
	where descargo = ".$_GET['descargo'];
		$objCon->RetornarRS($result_head, $sql_head);
		if ($objCon->ExisteRegistro($sql_head)){
			while($rs_head = $result_head->fetch_array()){
				$fecha=$rs_head[0];	
				$equipo=$rs_head[3];
				$placa=$rs_head[4];
				$departamento=$rs_head[5];
				$solicitud=$rs_head[6];
				$dto = $rs_head[7];
			}			
	}
	$objCon->Cerrar();
 ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>

<body>

<table width="985" border="0" align="center"> 
  <tr>
    <td width="175"><div align="center"><img src="img/logo.png" width="87" height="81" /></div></td>
    <td colspan="2"><div align="center">INSTITUTO SALVADORE&Ntilde;O DE TRANSFORMACION AGRARIA 
      <br />BODEGA DE LUBRICANTES
      <br />COMPROBANTE DE DESCARGO
    </div></td>
    <td width="178"><div align="center">SOLICITUD No<?php echo '  ',$solicitud;?>
	<br />
	DESCARGO No <?php echo $_GET['descargo']; ?>
	 </div></td>
  </tr>
   <tr>
     <td colspan="2">OFICINA: <?php echo '  '.$departamento;   ?>   <?php echo $dto;?></td>
     <td>FECHA: <?php echo '  '.$fecha; ?></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td colspan="3">PARA SER UTILIZADOS EN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EQUIPO: <?php echo '  '.$equipo.'    '; ?> &nbsp;&nbsp;PLACA: <?php echo '  '.$placa.'    '; ?></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
    <td width="354">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	$objCon=new Conexion();
	$objCon->Abrir();
	$sql="select k.cantidad,u.nom_med,k.numero_factura,a.nom_art,k.precio,k.precio*k.cantidad from kardex k 
	inner join articulo a on k.id_art=a.id_art
	inner join uni_med u ON a.id_um = u.id_um
	where k.descargo =".$_GET['descargo'];
	
	$objCon->RetornarRS($result, $sql);
  if ($objCon->ExisteRegistro($sql)){?>

<table width="982" border="1" align="center" cellspacing="0">
  <tr>
    <td width="64" height="25"><div align="center">CANTIDAD</div></td>
    <td width="80"><div align="center">U. MEDIDA </div></td>
    <td width="96"><div align="center">FACTURA No </div></td>
    <td width="516"><div align="center">DESCRIPCION</div></td>
    <td width="89"><div align="center">PRECIO UNIT. </div></td>
    <td width="97"><div align="center">VALOR TOTAL </div></td>
  </tr>
  <?php
  	$cont=0;$total=0;
	while($rs = $result->fetch_array())
		{?>
		  <tr>
			<td height="25"><div align="center"><?php echo $rs[0];?></div></td>
			<td><div align="center"><?php echo $rs[1];?></div></td>
			<td><div align="center"><?php echo $rs[2];?></div></td>
			<td>&nbsp;<?php echo $rs[3];?></td>
			<td><div align="right">$<?php echo number_format($rs[4],2,'.','');?>&nbsp;</div></td>
			<td><div align="right">$<?php echo number_format($rs[5],2,'.','');?>&nbsp;</div></td>
		  </tr>
		  <?php
		$cont++;
		$total=$total+$rs[5];
		}
	}
	  $result->free();  
	$objCon->Cerrar();
	while($cont<7)
	{
	?>
  <tr>
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php	
	$cont++;
	}?>
  <tr>
    <td colspan="5" height="25"><div align="right">TOTAL</div></td>
    <td><div align="right">$<?php echo number_format($total,2,'.','');?>&nbsp;</div></td>
  </tr>
</table>
<br /><br />
<table width="982" border="0" align="center">
  <tr>
    <td width="314" height="67"><div align="center">CARLOS ALBERTO CA&Ntilde;AS <br />  
      _________________________________ <br /> AUTORIZADO (NOMBRE)  	  
    </div></td>
    <td width="366"><div align="center">DAVID GAMEZ GIL
	 <br />
_________________________________ <br />
ENTREGADO (NOMBRE) </div></td>
    <td width="288"><div align="center">LIC. MARIA ESTER GUSZMAN<br />
_________________________________ <br />
VISTO BUENO (NOMBRE) </div></td>
  </tr>
  <tr>
    <td height="60"><div align="center">_________________________________ <br /> FIRMA</div></td>
    <td><div align="center">_________________________________ <br />
FIRMA</div></td>
    <td><div align="center">_________________________________ <br />
FIRMA</div></td>
  </tr> 
  <tr>
    <td colspan="3"><div align="right">ORIGINAL CONTABILIDAD </div></td>
  </tr>
</table>
<br />
<div align="center">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </div>
<p>&nbsp;</p>


<table width="985" border="0"  align="center"> 
  <tr>
    <td width="175"><div align="center"><img src="img/logo.png" width="87" height="81" /></div></td>
    <td colspan="2"><div align="center">INSTITUTO SALVADORE&Ntilde;O DE TRANSFORMACION AGRARIA 
      <br />BODEGA DE LUBRICANTES
      <br />COMPROBANTE DE DESCARGO
    </div></td>
    <td width="178"><div align="center">SOLICITUD No<?php echo '  ',$solicitud;?>
	<br />
	DESCARGO No <?php echo $_GET['descargo']; ?>
	 </div></td>
  </tr>
   <tr>
     <td colspan="2">OFICINA: <?php echo '  '.$departamento; ?></td>
     <td>FECHA: <?php echo '  '.$fecha; ?></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td colspan="3">PARA SER UTILIZADOS EN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EQUIPO: <?php echo '  '.$equipo.'    '; ?> &nbsp;&nbsp;PLACA: <?php echo '  '.$placa.'    '; ?></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
    <td width="354">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	$objCon=new Conexion();
	$objCon->Abrir();
	$sql="select k.cantidad,u.nom_med,k.numero_factura,a.nom_art,k.precio,k.precio*k.cantidad from kardex k 
	inner join articulo a on k.id_art=a.id_art
	inner join uni_med u ON a.id_um = u.id_um
	where k.descargo =".$_GET['descargo'];
	
	$objCon->RetornarRS($result, $sql);
  if ($objCon->ExisteRegistro($sql)){?>

<table width="982" border="1" align="center" cellspacing="0">
  <tr>
    <td width="64" height="25"><div align="center">CANTIDAD</div></td>
    <td width="80"><div align="center">U. MEDIDA </div></td>
    <td width="96"><div align="center">FACTURA No </div></td>
    <td width="516"><div align="center">DESCRIPCION</div></td>
    <td width="89"><div align="center">PRECIO UNIT. </div></td>
    <td width="97"><div align="center">VALOR TOTAL </div></td>
  </tr>
  <?php
  	$cont=0;$total=0;
	while($rs = $result->fetch_array())
		{?>
		  <tr>
			<td height="25"><div align="center"><?php echo $rs[0];?></div></td>
			<td><div align="center"><?php echo $rs[1];?></div></td>
			<td><div align="center"><?php echo $rs[2];?></div></td>
			<td>&nbsp;<?php echo $rs[3];?></td>
			<td><div align="right">$<?php echo number_format($rs[4],2,'.','');?>&nbsp;</div></td>
			<td><div align="right">$<?php echo number_format($rs[5],2,'.','');?>&nbsp;</div></td>
		  </tr>
		  <?php
		$cont++;
		$total=$total+$rs[5];
		}
	}
	  $result->free();  
	$objCon->Cerrar();
	while($cont<7)
	{
	?>
  <tr>
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php	
	$cont++;
	}?>
  <tr>
    <td colspan="5" height="25"><div align="right">TOTAL</div></td>
    <td><div align="right">$<?php echo number_format($total,2,'.','');?>&nbsp;</div></td>
  </tr>
</table>
<br /><br />
<table width="982" border="0" align="center">
  <tr>
    <td width="314" height="67"><div align="center">CARLOS ALBERTO CA&Ntilde;AS <br />  
      _________________________________ <br /> AUTORIZADO (NOMBRE)  	  
    </div></td>
    <td width="366"><div align="center">DAVID GAMEZ GIL <br />
_________________________________ <br />
ENTREGADO (NOMBRE) </div></td>
    <td width="288"><div align="center">LIC. MARIA ESTER GUSZMAN<br />
_________________________________ <br />
VISTO BUENO (NOMBRE) </div></td>
  </tr>
  <tr>
    <td height="60"><div align="center">_________________________________ <br /> FIRMA</div></td>
    <td><div align="center">_________________________________ <br />
FIRMA</div></td>
    <td><div align="center">_________________________________ <br />
FIRMA</div></td>
  </tr>
   <tr>
    <td colspan="3"><div align="right">DUPLICADO GERENCIA DE OPERACIONES</div></td>
  </tr>  
</table>




<table width="985" border="0" align="center"> 
  <tr>
    <td width="175"><div align="center"><img src="img/logo.png" width="87" height="81" /></div></td>
    <td colspan="2"><div align="center">INSTITUTO SALVADORE&Ntilde;O DE TRANSFORMACION AGRARIA 
      <br />BODEGA DE LUBRICANTES
      <br />COMPROBANTE DE DESCARGO
    </div></td>
    <td width="178"><div align="center">SOLICITUD No<?php echo '  ',$solicitud;?>
	<br />
	DESCARGO No <?php echo $_GET['descargo']; ?>
	 </div></td>
  </tr>
   <tr>
     <td colspan="2">OFICINA: <?php echo '  '.$departamento; ?></td>
     <td>FECHA: <?php echo '  '.$fecha; ?></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td colspan="3">PARA SER UTILIZADOS EN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EQUIPO: <?php echo '  '.$equipo.'    '; ?> &nbsp;&nbsp;PLACA: <?php echo '  '.$placa.'    '; ?></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
    <td width="354">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	$objCon=new Conexion();
	$objCon->Abrir();
	$sql="select k.cantidad,u.nom_med,k.numero_factura,a.nom_art,k.precio,k.precio*k.cantidad from kardex k 
	inner join articulo a on k.id_art=a.id_art
	inner join uni_med u ON a.id_um = u.id_um
	where k.descargo =".$_GET['descargo'];
	
	$objCon->RetornarRS($result, $sql);
  if ($objCon->ExisteRegistro($sql)){?>

<table width="982" border="1" align="center" cellspacing="0">
  <tr>
    <td width="64" height="25"><div align="center">CANTIDAD</div></td>
    <td width="80"><div align="center">U. MEDIDA </div></td>
    <td width="96"><div align="center">FACTURA No </div></td>
    <td width="516"><div align="center">DESCRIPCION</div></td>
    <td width="89"><div align="center">PRECIO UNIT. </div></td>
    <td width="97"><div align="center">VALOR TOTAL </div></td>
  </tr>
  <?php
  	$cont=0;$total=0;
	while($rs = $result->fetch_array())
		{?>
		  <tr>
			<td height="25"><div align="center"><?php echo $rs[0];?></div></td>
			<td><div align="center"><?php echo $rs[1];?></div></td>
			<td><div align="center"><?php echo $rs[2];?></div></td>
			<td>&nbsp;<?php echo $rs[3];?></td>
			<td><div align="right">$<?php echo number_format($rs[4],2,'.','');?>&nbsp;</div></td>
			<td><div align="right">$<?php echo number_format($rs[5],2,'.','');?>&nbsp;</div></td>
		  </tr>
		  <?php
		$cont++;
		$total=$total+$rs[5];
		}
	}
	  $result->free();  
	$objCon->Cerrar();
	while($cont<7)
	{
	?>
  <tr>
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php	
	$cont++;
	}?>
  <tr>
    <td colspan="5" height="25"><div align="right">TOTAL</div></td>
    <td><div align="right">$<?php echo number_format($total,2,'.','');?>&nbsp;</div></td>
  </tr>
</table>
<br /><br />
<table width="982" border="0" align="center">
  <tr>
    <td width="314" height="67"><div align="center">CARLOS ALBERTO CA&Ntilde;AS <br />  
      _________________________________ <br /> AUTORIZADO (NOMBRE)  	  
    </div></td>
    <td width="366"><div align="center">DAVID GAMEZ GIL <br />
_________________________________ <br />
ENTREGADO (NOMBRE) </div></td>
   <td width="288"><div align="center">LIC. MARIA ESTER GUSZMAN<br />
_________________________________ <br />
VISTO BUENO (NOMBRE) </div></td>
  </tr>
  <tr>
    <td height="60"><div align="center">_________________________________ <br /> FIRMA</div></td>
    <td><div align="center">_________________________________ <br />
FIRMA</div></td>
    <td><div align="center">_________________________________ <br />
FIRMA</div></td>
  </tr> 
     <tr>
    <td colspan="3"><div align="right">TRIPLICADO SERVICIOS GENERALES</div></td>
  </tr>  
</table>
<br />
<div align="center">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </div>
<p>&nbsp;</p>


<table width="985" border="0"  align="center"> 
  <tr>
    <td width="175"><div align="center"><img src="img/logo.png" width="87" height="81" /></div></td>
    <td colspan="2"><div align="center">INSTITUTO SALVADORE&Ntilde;O DE TRANSFORMACION AGRARIA 
      <br />BODEGA DE LUBRICANTES
      <br />COMPROBANTE DE DESCARGO
    </div></td>
    <td width="178"><div align="center">SOLICITUD No<?php echo '  ',$solicitud;?>
	<br />
	DESCARGO No <?php echo $_GET['descargo']; ?>
	 </div></td>
  </tr>
   <tr>
     <td colspan="2">OFICINA: <?php echo '  '.$departamento; ?></td>
     <td>FECHA: <?php echo '  '.$fecha; ?></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td colspan="3">PARA SER UTILIZADOS EN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EQUIPO: <?php echo '  '.$equipo.'    '; ?> &nbsp;&nbsp;PLACA: <?php echo '  '.$placa.'    '; ?></td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
    <td width="354">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	$objCon=new Conexion();
	$objCon->Abrir();
	$sql="select k.cantidad,u.nom_med,k.numero_factura,a.nom_art,k.precio,k.precio*k.cantidad from kardex k 
	inner join articulo a on k.id_art=a.id_art
	inner join uni_med u ON a.id_um = u.id_um
	where k.descargo =".$_GET['descargo'];
	
	$objCon->RetornarRS($result, $sql);
  if ($objCon->ExisteRegistro($sql)){?>

<table width="982" border="1" align="center" cellspacing="0">
  <tr>
    <td width="64" height="25"><div align="center">CANTIDAD</div></td>
    <td width="80"><div align="center">U. MEDIDA </div></td>
    <td width="96"><div align="center">FACTURA No </div></td>
    <td width="516"><div align="center">DESCRIPCION</div></td>
    <td width="89"><div align="center">PRECIO UNIT. </div></td>
    <td width="97"><div align="center">VALOR TOTAL </div></td>
  </tr>
  <?php
  	$cont=0;$total=0;
	while($rs = $result->fetch_array())
		{?>
		  <tr>
			<td height="25"><div align="center"><?php echo $rs[0];?></div></td>
			<td><div align="center"><?php echo $rs[1];?></div></td>
			<td><div align="center"><?php echo $rs[2];?></div></td>
			<td>&nbsp;<?php echo $rs[3];?></td>
			<td><div align="right">$<?php echo number_format($rs[4],2,'.','');?>&nbsp;</div></td>
			<td><div align="right">$<?php echo number_format($rs[5],2,'.','');?>&nbsp;</div></td>
		  </tr>
		  <?php
		$cont++;
		$total=$total+$rs[5];
		}
	}
	  $result->free();  
	$objCon->Cerrar();
	while($cont<7)
	{
	?>
  <tr>
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php	
	$cont++;
	}?>
  <tr>
    <td colspan="5" height="25"><div align="right">TOTAL</div></td>
    <td><div align="right">$<?php echo number_format($total,2,'.','');?>&nbsp;</div></td>
  </tr>
</table>
<br /><br />
<table width="982" border="0" align="center">
  <tr>
    <td width="314" height="67"><div align="center">CARLOS ALBERTO CA&Ntilde;AS <br />  
      _________________________________ <br /> AUTORIZADO (NOMBRE)  	  
    </div></td>
    <td width="366"><div align="center">DAVID GAMEZ GIL <br />
_________________________________ <br />
ENTREGADO (NOMBRE) </div></td>
    <td width="288"><div align="center">LIC. MARIA ESTER GUSZMAN<br />
_________________________________ <br />
VISTO BUENO (NOMBRE) </div></td>
  </tr>
  <tr>
    <td height="60"><div align="center">_________________________________ <br /> FIRMA</div></td>
    <td><div align="center">_________________________________ <br />
FIRMA</div></td>
    <td><div align="center">_________________________________ <br />
FIRMA</div></td>
  </tr> 
     <tr>
    <td colspan="3"><div align="right">CUADRUPLICADO BODEGA DE LUBRICANTES</div></td>
  </tr>   
</table>






</body>
</html>