<link rel="stylesheet" type="text/css" href="css/estilos.css">

<?php require_once('../conectar/conectar.php'); ?>
<?php 
if (isset($_GET["txt_nombre_usuario"])) {
  $sql = "select u.id_usuario,u.username,u.password,t.id_tipo,t.nom_tipo,u.estado from usuarios u inner join tipo_usuario 
	t ON t.id_tipo = u.id_tipo
	where username  like '%".$_GET['txt_nombre_usuario']."%'";	
	mysql_select_db($database_cnn, $cnn);
	$result = mysql_query($sql, $cnn) or die(mysql_error());
//echo $sql;

if($row=mysql_fetch_array($result)){?>
<table border='0' align='center' >
<tr class="row1" bgcolor=#e5eecc>
  <td><strong>USUARIO</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td align="center"><strong>ROL</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td align="center"><strong>ESTADO</strong></td>
</tr>
<?php
$cont=2;
do{?>
<tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2';?>">
<td><a href="#" onClick="javascript:usuarioSelect('<?php echo $row["id_usuario"];?>','<?php echo $row["username"];?>','<?php echo $row["password"];?>','<?php echo $row["id_tipo"];?>','<?php echo $row["nom_tipo"];?>');"><?php echo $row["username"]; ?></td></a>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo $row["nom_tipo"]; ?></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td align="center"><?php echo $row["estado"]; ?></td>

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

