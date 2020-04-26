<head>
<script language="JavaScript">
function agrupacionSelect(id, nombre){
parent.document.getElementById('id_agru').value=id;
parent.document.getElementById('txt_agru').value=nombre;

//parent.document.getElementById('mensaje').innerHTML='';
parent.TINY.box.hide();
}
</script>
</head>

<?php 
session_start();

require_once('clases/conexion.php'); 

echo '<link rel="stylesheet" type="text/css" href="css/estilos.css">';

//esto se usa para mostrar la letra ñ y tildes
header('Content-Type: text/html; charset=ISO-8859-1'); 

$objCon=new Conexion();
	$sql = "SELECT id_agru, cod_agru, nom_agru FROM agrupacion_operacional";

//echo $sql;	
  $objCon->Abrir();
  $objCon->RetornarRS($result, $sql);
  $cont=1;
	echo "<table align='center'>
	<tr class='row1' style='font-size: 12'>
	<td><b>AGRUPACION</b></td>
	</tr>";	
  if ($objCon->ExisteRegistro($sql)){
	  while($rs = $result->fetch_array())
	  {?>
		<tr  class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'?>" style='font-size: 12' >	  
		<td><a href="#" onClick="javascript:agrupacionSelect('<?php echo $rs[0];?>', '<?php echo $rs[2];?>');"><?php echo $rs[2]?></a></td>
		</tr>
		<?php
		$cont++;
	  }
	echo "</table>";	  
  }
  
  $result->free();
  $objCon->Cerrar();
  
?>
