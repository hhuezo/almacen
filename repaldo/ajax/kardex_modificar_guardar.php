<?php
	session_start();
	require_once('../clases/conexion.php');
	//modificar entrada de articulo
	if($_GET['modoop']==11){
		if($_GET['cantidad'] < $_GET['txt_existencia'])
		{
			echo 'se han registrado un total de '.$_GET['txt_existencia'].' salidas por tanto ingresar una cantidad igual o mayor';
		}
		else{
			$objCon=new Conexion();
			$objCon->Abrir();
			$sql= "update kardex set cantidad = ".$_GET['cantidad']." , precio = ".$_GET['precio']." , 
			total = ".$_GET['cantidad']*$_GET['precio'].",fecha = '".$_GET['fecha']."',numero_factura = '".$_GET['txt_factura']."' where id_kar = ".$_GET['id_kar'];
			$objCon->Ejecutar($sql);
			
			$sql="update kardex set precio = ".$_GET['precio']." ,total = ".$_GET['precio']." * cantidad,numero_factura = '".$_GET['txt_factura']."' 
			where orden_compra =".$_GET['orden_compra']." and id_art = ".$_GET['id_articulo'];
			//echo $sql;
			$objCon->Ejecutar($sql);
			echo "<center><img src='images/modificar.jpg' border='0'></center>";
			$objCon->Cerrar();
		}
	}
	//eliminar entrada de articulo
	else if($_GET['modoop']==12){
		$objCon=new Conexion();
		$objCon->Abrir();
		$sql="select count(*) as conteo from kardex where id_mov = 2 and orden_compra = ".$_GET['orden_compra']." and id_art = 
		".$_GET['id_articulo']." and precio = ".$_GET['precio'];
		//echo $sql;
		$objCon->RetornarRS($result, $sql);
		if ($objCon->ExisteRegistro($sql)){
			while($rs = $result->fetch_array()){
				$conteo=$rs[0];
			}
		}
		
		if($conteo>0){
			echo '<center>No se puede eliminar porque hay salidas que pertenecen a esta orden</center>';
		}
		else{
			$sql="delete from kardex where id_kar = ".$_GET['id_kar'];
			$objCon->Ejecutar($sql);
			echo "<center><img src='images/eliminar.jpg' border='0'></center>";
			}	
			$objCon->Cerrar();
	}
	//modificacion de salida de articulos
	else if($_GET['modoop']==21){
		if($_GET['cantidad']>$_GET['txt_existencia'])
		{echo '<center>Error!!! la existencia para esta orden de compra es: '.$_GET['txt_existencia']."</center>";}
		else{
			$objCon=new Conexion();
			$objCon->Abrir();
			$sql= "update kardex set cantidad = ".$_GET['cantidad'].",total = ".$_GET['cantidad']*$_GET['precio']." 
			,descargo = ".$_GET['descargo'].",fecha = '".$_GET['fecha']."'
			where id_kar = ".$_GET['id_kar'];
			$objCon->Ejecutar($sql);
			echo "<center><img src='images/modificar.jpg' border='0'></center>";
			$objCon->Cerrar();			
		}
		
	}
	//eliminacion de salida de articulos
	else if($_GET['modoop']==22){
			$objCon=new Conexion();
			$objCon->Abrir();
			$sql="delete from kardex where id_kar = ".$_GET['id_kar'];
			$objCon->Ejecutar($sql);
			echo "<center><img src='images/eliminar.jpg' border='0'></center>";
			$objCon->Cerrar();		
	}
	//modificacion de salida de repuestos
	else if($_GET['modoop']==31){
		if($_GET['cantidad']>$_GET['txt_existencia'])
		{echo '<center>Error!!! la existencia para esta orden de compra es: '.$_GET['txt_existencia']."</center>";}
		else{
			$objCon=new Conexion();
			$objCon->Abrir();
			$sql= "update kardex set cantidad = ".$_GET['cantidad'].",total = ".$_GET['cantidad']*$_GET['precio']." 
			,id_auto = ".$_GET['id_auto'].",descargo = ".$_GET['descargo'].",fecha = '".$_GET['fecha']."'
			where id_kar = ".$_GET['id_kar'];
			//echo $sql;
			$objCon->Ejecutar($sql);
			echo "<center><img src='images/modificar.jpg' border='0'></center>";
			$objCon->Cerrar();			
		}
		
	}
	//eliminacion de salida de repuestos
	else if($_GET['modoop']==32){
			$objCon=new Conexion();
			$objCon->Abrir();
			$sql="delete from kardex where id_kar = ".$_GET['id_kar'];
			$objCon->Ejecutar($sql);
			echo "<center><img src='images/eliminar.jpg' border='0'></center>";
			$objCon->Cerrar();		
	}	
	
	//actualizando existecia del articulo
	$sql ="select id_kar,fecha,cantidad,id_mov from kardex where id_art = ".$_GET['id_articulo']." order by fecha";

	$objCon=new Conexion();
	$objCon->Abrir();
	$objCon->RetornarRS($result, $sql);
	  if ($objCon->ExisteRegistro($sql)){
		  $existencia =0;
		  while($rs = $result->fetch_array())
			{		
			if($rs[3]==1){$existencia = $existencia + $rs[2];}
			if($rs[3]==2){$existencia = $existencia - $rs[2];}
			$Sql_update = "update kardex set existencia_actual = $existencia where id_kar = ".$rs[0];
			$objCon->Ejecutar($Sql_update);
			}
			
	  $result->free();  
	  $objCon->Cerrar();	 
}
		
 ?>