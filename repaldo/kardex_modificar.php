<?php //echo $_GET['id_kar']; 
session_start();
require_once('clases/conexion.php'); 


	$objCon=new Conexion();
	$objCon->Abrir();
	$sql="select id_mov,id_dto,id_auto from kardex where id_kar = ".$_GET['id_kar'];
	//echo $sql;
	$objCon->RetornarRS($result, $sql);
	if ($objCon->ExisteRegistro($sql)){
		while($rs = $result->fetch_array()){
			$id_mov=$rs[0];
			$id_dto=$rs[1];
			$id_auto=$rs[2];
		}
	}
	
	//verificar a que tipo de transaccion pertenece el registro
	if($id_mov ==1){$mood = 1;}
	else if($id_mov==2 && $id_dto>0){$mood = 2;}
	else if($id_mov==2 && $id_auto>0){$mood = 3;}

?>

	<html>
	<head>


  <!--para ventana modal js-->
	<link rel="stylesheet" href="style_tinybox.css" />
	<script type="text/javascript" src="tinybox.js"></script>
    
	<!--FIN para ventana modal js-->


<script type="text/javascript" src="Ajax/Ajax.js"></script>
<link rel="stylesheet" href="css/style_form.css" type="text/css" />


	<!-- script para calendario -->
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
		<link rel="stylesheet" type="text/css" href="css/botones.css" />
		<script src="js/jquery-1.4.1.js" type="text/javascript"></script>
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui.min.js" type="text/javascript"></script>
	</head>
	
	<section class="container">
	<div class="login">

	<h1>
	<?php include_once('titulo_sistema.html');?>
	</h1>
	<h2>MODIFICACION DE REGISTROS</h2>
	<form name="kardex" method="post">
	<?php
	if($mood ==1){
		$objCon=new Conexion();
		$objCon->Abrir();
			$sql="select k.fecha as fecha,k.orden_compra,k.numero_factura,agru.nom_agru,p.nom_prov,
			k.para_uso,a.nom_art,a.id_art,k.cantidad,k.precio,
			(select sum(cantidad) from kardex kar where kar.orden_compra=k.orden_compra and kar.id_art = k.id_art 
			and kar.precio = k.precio and kar.id_mov = 2) as TotalSalida
			from kardex k 
			inner join agrupacion_operacional agru on k.id_agru = agru.id_agru
			inner join proveedor p on k.id_prov = p.id_prov
			inner join articulo a on k.id_art = a.id_art
			where k.id_kar  =".$_GET['id_kar'];
			$objCon->RetornarRS($result, $sql);
				if ($objCon->ExisteRegistro($sql)){
					while($rs = $result->fetch_array()){
					$fecha=$rs[0];	
					$orden_compra=$rs[1];	
					$numero_factura=$rs[2];	
					$agrupacion=$rs[3];	
					$proveedor=$rs[4];	
					$paraUso=$rs[5];	
					$articulo=$rs[6];
					$id_articulo=$rs[7];
					$cantidad=$rs[8];	
					$precio=$rs[9];
					$TotalSalida=$rs[10];
					}
				}?>
			<center>
			<table>
			<tr>
			   <td >Fecha</td>
			   <td>
			   <input type="hidden" name="id_kar" id="id_kar" readonly="true" size="12" value="<?php echo $_GET['id_kar']; ?>">
			   <input type="Date" name="fecha" id="fecha" value="<?php echo $fecha; ?>"></td>
			</tr>
			 <tr>
			   <td>Orden de Compra</td>
			   <td><input type="text" name="orden_compra" id="orden_compra" readonly value="<?php echo $orden_compra; ?>"></td>
			</tr>
			<tr>
				<td>Agrupacion Ope.</td>
				<td><input type="text" name="agrupacion" id="agrupacion" readonly="true" size="12" value="<?php echo $agrupacion; ?>"></td>
			</tr>
			<tr>
			   <td >Proveedor</td>
			   <td><input type="text" name="txt_proveedor" id="txt_proveedor" size="50" value="<?php echo $proveedor; ?>" readonly>
			   </td>			  
			</tr>
			<tr>
			   <td >Para Uso de</td>
			   <td><input type="text" name="uso" id="uso" size="50" readonly value="<?php echo $paraUso; ?>"></td>
			</tr>
			<tr>
			   <td >Factura</td>
			   <td><input type="text" name="txt_factura" id="txt_factura"  size="50" value="<?php echo $numero_factura; ?>">
			   </td>
			   <td>
			   </td>
			</tr>
			<tr>   
				 <td >Articulo</td>
				 <td>
					<input type="hidden" name="id_articulo" id="id_articulo" size="50" value="<?php echo $id_articulo; ?>" readonly>
					<input type="text" name="txt_articulo" id="txt_articulo" size="50" value="<?php echo $articulo; ?>" readonly>
					<input type="hidden" name="txt_existencia" id="txt_existencia" size="50" value="<?php echo $TotalSalida; ?>" readonly>
				 </td>
			</tr>
			<tr>
				<td colspan>Cantidad </td>
				<td><input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>"></td>
				<td></td>
			</tr>  
			<tr>   
				<td colspan>Precio ($) </td>
				<td><input type="text" name="precio" id="precio" value="<?php echo $precio; ?>"></td>
				<td></td>
			</tr>
			 <tr align='center'>
     <td colspan="2">
     
     <input type="button" name="aceptarbtn" value="Modificar" onClick="
		if(kardex.cantidad.value==''){
			alert('Por favor, No dejar la cantidad en blanco')
		}
		else if(kardex.precio.value==''){
			alert('Por favor, No dejar el precio en blanco')
		}		
		else{
		sendQueryToSelect('ajax/kardex_modificar_guardar.php?modoop=11&id_kar='+kardex.id_kar.value+
		'&cantidad='+kardex.cantidad.value+
		'&fecha='+kardex.fecha.value+
		'&orden_compra='+kardex.orden_compra.value+
		'&txt_existencia='+kardex.txt_existencia.value+
		'&id_articulo='+kardex.id_articulo.value+
		'&txt_factura='+kardex.txt_factura.value+
		'&precio='+kardex.precio.value,'targetDiv');		
		}" >
		
		<input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
		if (kardex.id_kar.value!='') {
			if(confirm('Esta seguro que desea Eliminar este Registro?')) {
				sendQueryToDelete('ajax/kardex_modificar_guardar.php?modoop=12&id_kar='+kardex.id_kar.value+
				'&cantidad='+kardex.cantidad.value+
				'&orden_compra='+kardex.orden_compra.value+
				'&txt_existencia='+kardex.txt_existencia.value+
				'&id_articulo='+kardex.id_articulo.value+
				'&precio='+kardex.precio.value,'targetDiv');
			}
		}
		else alert('Por favor, Buscar registro a Eliminar')"/>
		
		<a href="historial_articulo.php?id_articulo=<?php echo $id_articulo;?>">
       <input type="button" name="btnCancelar" value="Cancelar"></a>

      </td>
   </tr>
   </table>
	</center>
	<div id="targetDiv"></div>
	<?php
	}
	if($mood ==2){
		$objCon=new Conexion();
		$objCon->Abrir();
			$sql="select k.fecha as fecha,k.descargo,a.nom_art,a.id_art,dep.id_dto,dep.nom_dto,
			k.cantidad,k.precio,(select sum(cantidad) from kardex kar where kar.id_art=k.id_art and 
			kar.orden_compra=k.orden_compra and kar.precio = k.precio and id_mov = 1)+ k.cantidad
			-(select sum(cantidad) from kardex kar where kar.id_art=k.id_art and kar.orden_compra=k.orden_compra 
			and kar.precio = k.precio and id_mov = 2) as existencia
			from kardex k 
			inner join articulo a on k.id_art=a.id_art
			inner join departamento dep on k.id_dto=dep.id_dto
			where k.id_kar =".$_GET['id_kar'];
			$objCon->RetornarRS($result, $sql);
				if ($objCon->ExisteRegistro($sql)){
					while($rs = $result->fetch_array()){
					$fecha=$rs[0];	
					$descargo=$rs[1];
					$articulo=$rs[2];
					$id_articulo=$rs[3];
					$id_dto=$rs[4];
					$departamento=$rs[5];
					$cantidad=$rs[6];	
					$precio=$rs[7];
					$Existencia=$rs[8];
					}
				}?>
		
		<center>
			<table>
			<tr>
			   <td >Fecha</td>
			   <td>
			   <input type="hidden" name="id_kar" id="id_kar" readonly="true" size="12" value="<?php echo $_GET['id_kar']; ?>">
			   <input type="Date" name="fecha" id="fecha" value="<?php echo $fecha; ?>"></td>
			</tr>
			 <tr>
			   <td>Descargo</td>
			   <td><input type="text" name="descargo" id="descargo" value="<?php echo $descargo; ?>"></td>
			</tr>
			</tr>
			 <tr>
			   <td>Departamento</td>
			   <td><input type="text" name="txt_departamento" id="txt_departamento" readonly value="<?php echo $departamento; ?>">
			   <input type="hidden" name="id_departamento" id="id_departamento" readonly value="<?php echo $id_dto; ?>"></td>
			</tr>
			<tr>
			<tr>   
				 <td >Articulo</td>
				 <td>
					<input type="hidden" name="id_articulo" id="id_articulo" size="50" value="<?php echo $id_articulo; ?>" readonly>
					<input type="text" name="txt_articulo" id="txt_articulo" size="50" value="<?php echo $articulo; ?>" readonly>
					<input type="hidden" name="txt_existencia" id="txt_existencia" size="50" value="<?php echo $Existencia; ?>" readonly>
				 </td>
			</tr>
			<tr>
				<td colspan>Cantidad </td>
				<td><input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>"></td>
				<td></td>
			</tr>  
			<tr>   
				<td colspan>Precio ($) </td>
				<td><input type="text" name="precio" id="precio" readonly value="<?php echo $precio; ?>"></td>
				<td></td>
			</tr>
			<tr align='center'>
     <td colspan="2">
     
     <input type="button" name="aceptarbtn" value="Modificar" onClick="
		if(kardex.cantidad.value==''){
			alert('Por favor, No dejar la cantidad en blanco')
		}
		else if(kardex.precio.value==''){
			alert('Por favor, No dejar el precio en blanco')
		}
		else if(kardex.descargo.value==''){
			alert('Por favor, No dejar el descargo en blanco')
		}
		else{
		sendQueryToSelect('ajax/kardex_modificar_guardar.php?modoop=21&id_kar='+kardex.id_kar.value+
		'&cantidad='+kardex.cantidad.value+
		'&descargo='+kardex.descargo.value+
		'&fecha='+kardex.fecha.value+
		'&txt_existencia='+kardex.txt_existencia.value+
		'&id_articulo='+kardex.id_articulo.value+
		'&precio='+kardex.precio.value,'targetDiv');		
		}" >		
		<input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
		if (kardex.id_kar.value!='') {
			if(confirm('Esta seguro que desea Eliminar este Registro?')) {
				sendQueryToDelete('ajax/kardex_modificar_guardar.php?modoop=22&id_kar='+kardex.id_kar.value+
				'&cantidad='+kardex.cantidad.value+
				'&descargo='+kardex.descargo.value+
				'&txt_existencia='+kardex.txt_existencia.value+
				'&id_articulo='+kardex.id_articulo.value+
				'&precio='+kardex.precio.value,'targetDiv');
			}
		}
		else alert('Por favor, Buscar registro a Eliminar')"/>
		
		<a href="historial_articulo.php?id_articulo=<?php echo $id_articulo;?>">
       <input type="button" name="btnCancelar" value="Cancelar"></a>

      </td>
   </tr>
   </table>
	</center>
	<div id="targetDiv"></div>		
	<?php	
	}
	if($mood ==3){
		$objCon=new Conexion();
		$objCon->Abrir();
			$sql="select k.fecha as fecha,k.descargo,a.nom_art,a.id_art,auto.id_auto,auto.equipo,auto.placa,
			k.cantidad,k.precio,(select sum(cantidad) from kardex kar where kar.id_art=k.id_art and 
			kar.orden_compra=k.orden_compra and kar.precio = k.precio and id_mov = 1)+ k.cantidad
			-(select sum(cantidad) from kardex kar where kar.id_art=k.id_art and kar.orden_compra=k.orden_compra 
			and kar.precio = k.precio and id_mov = 2) as existencia
			from kardex k 
			inner join articulo a on k.id_art=a.id_art
			inner join automovil auto on k.id_auto=auto.id_auto
			where k.id_kar =".$_GET['id_kar'];
			$objCon->RetornarRS($result, $sql);
				if ($objCon->ExisteRegistro($sql)){
					while($rs = $result->fetch_array()){
					$fecha=$rs[0];	
					$descargo=$rs[1];
					$articulo=$rs[2];
					$id_articulo=$rs[3];
					$id_auto=$rs[4];
					$equipo=$rs[5];
					$placa=$rs[6];
					$cantidad=$rs[7];	
					$precio=$rs[8];
					$Existencia=$rs[9];
					}
				}?>
		
		<center>
			<table>
			<tr>
			   <td >Fecha</td>
			   <td>
			   <input type="hidden" name="id_kar" id="id_kar" readonly="true" size="12" value="<?php echo $_GET['id_kar']; ?>">
			   <input type="Date" name="fecha" id="fecha"  value="<?php echo $fecha; ?>"></td>
			</tr>
			 <tr>
			   <td>Descargo</td>
			   <td><input type="text" name="descargo" id="descargo"  value="<?php echo $descargo; ?>"></td>
			</tr>
			</tr>
			 <tr>
			   <td>Equipo</td>
			   <td><input type="text" name="equipo" id="equipo" readonly value="<?php echo $equipo; ?>">
			   <input type="hidden" name="id_departamento" id="id_departamento" readonly value="<?php echo $id_auto; ?>">
			   <a href="#" onClick="TINY.box.show({iframe:'catalogo_auto_buscar.php',boxid:'frameless',width:625,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}})" 
				class="enlacebotonimagen" name="btnBuscar">
				<img src="css/16-Search.ico"></a>
			   </td>
			</tr>
			<tr>
			   <td>Placa</td>
			   <td><input type="text" name="placa" id="placa" readonly value="<?php echo $placa; ?>">
			   <input type="hidden" name="id_auto" id="id_auto" readonly value="<?php echo $id_auto; ?>"></td>
			</tr>
			<input type="hidden" name="txt_auto" id="txt_auto" size="35" readonly="true" onKeyUp="this.value = this.value.toUpperCase();">
			<input type="hidden" name="cmb_estado" id="cmb_estado" size="35" readonly="true">
			<tr>
			<tr>   
				 <td >Articulo</td>
				 <td>
					<input type="hidden" name="id_articulo" id="id_articulo" size="50" value="<?php echo $id_articulo; ?>" readonly>
					<input type="text" name="txt_articulo" id="txt_articulo" size="50" value="<?php echo $articulo; ?>" readonly>
					<input type="hidden" name="txt_existencia" id="txt_existencia" size="50" value="<?php echo $Existencia; ?>" readonly>
				 </td>
			</tr>
			<tr>
				<td colspan>Cantidad </td>
				<td><input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>"></td>
				<td></td>
			</tr>  
			<tr>   
				<td colspan>Precio ($) </td>
				<td><input type="text" name="precio" id="precio" readonly value="<?php echo $precio; ?>"></td>
				<td></td>
			</tr>
			<tr align='center'>
     <td colspan="2">
     
     <input type="button" name="aceptarbtn" value="Modificar" onClick="
		if(kardex.cantidad.value==''){
			alert('Por favor, No dejar la cantidad en blanco')
		}
		else if(kardex.precio.value==''){
			alert('Por favor, No dejar el precio en blanco')
		}	
		else if(kardex.descargo.value==''){
			alert('Por favor, No dejar el descargo en blanco')
		}	
		else{
		sendQueryToSelect('ajax/kardex_modificar_guardar.php?modoop=31&id_kar='+kardex.id_kar.value+
		'&cantidad='+kardex.cantidad.value+
		'&descargo='+kardex.descargo.value+
		'&fecha='+kardex.fecha.value+
		'&txt_existencia='+kardex.txt_existencia.value+
		'&id_auto='+kardex.id_auto.value+
		'&id_articulo='+kardex.id_articulo.value+
		'&precio='+kardex.precio.value,'targetDiv');		
		}" >		
		<input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
		if (kardex.id_kar.value!='') {
			if(confirm('Esta seguro que desea Eliminar este Registro?')) {
				sendQueryToDelete('ajax/kardex_modificar_guardar.php?modoop=32&id_kar='+kardex.id_kar.value+
				'&cantidad='+kardex.cantidad.value+
				'&descargo='+kardex.descargo.value+
				'&txt_existencia='+kardex.txt_existencia.value+
				'&id_articulo='+kardex.id_articulo.value+
				'&precio='+kardex.precio.value,'targetDiv');
			}
		}
		else alert('Por favor, Buscar registro a Eliminar')"/>
		
		<a href="historial_articulo.php?id_articulo=<?php echo $id_articulo;?>">
       <input type="button" name="btnCancelar" value="Cancelar"></a>

      </td>
   </tr>
   </table>
	</center>
	<div id="targetDiv"></div>		
	<?php
	}
	?>
	</form>
