<link rel="stylesheet" type="text/css" href="css/estilos.css">

<?php require_once('../conectar/conectar.php'); ?>
<?php 
if (isset($_GET["txt_nombre_auto"])) {
  $sql = "SELECT a.id_auto, a.detalle as automovil, a.equipo, a.placa, a.id_marca, m.nombre_marca,d.id_dto,d.nom_dto
	FROM automovil a inner join marca m on a.id_marca=m.id_marca
	inner join departamento d ON a.id_dto = d.id_dto
	where equipo  like '%".$_GET['txt_nombre_auto']."%'
	or placa  like '%".$_GET['txt_nombre_auto']."%' order by d.nom_dto";
	mysql_select_db($database_cnn, $cnn);
	$result = mysql_query($sql, $cnn) or die(mysql_error());
//echo $sql;

if($row=mysql_fetch_array($result)){?>
<table border='0' align='center' >
<tr class="row1" bgcolor=#e5eecc>
  <td><strong>PLACA</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td><strong>EQUIPO</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td align="center"><strong>AUTOMOVIL</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td><strong>MARCA</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td><strong>DEPARTAMENTO</strong></td>
</tr>
<?php
$cont=2;
do{?>
<tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2';?>">
<td><a href="#" onClick="javascript:autoSelect('<?php echo $row["id_auto"];?>','<?php echo $row["automovil"];?>','<?php echo $row["equipo"];?>','<?php echo $row["placa"];?>','<?php echo $row["id_marca"];?>','<?php echo $row["nombre_marca"];?>','<?php echo $row["id_dto"];?>','<?php echo $row["nom_dto"];?>');"><?php echo $row["placa"]; ?></td></a>
<td></td><td><?php echo $row["equipo"]; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="center"><?php echo $row["automovil"]; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><?php echo $row["nombre_marca"]; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><?php echo $row["nom_dto"]; ?></td>
</tr>
<?php
$cont++;
}while($row=mysql_fetch_array($result));?>
</table>
<?php }
else{
echo "<center><img src='images/error.jpg'></center>";
}
mysql_close($cnn); //cierro la conexion 
}
?>

