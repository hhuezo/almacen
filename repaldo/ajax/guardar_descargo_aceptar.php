<?php 
session_start();

require_once('../clases/conexion.php'); 
require_once('../conectar/conectar.php'); 
	
// Recuperar los datos enviados del formulario
$id_art=$_GET['id_articulo'];
$cantidad=$_GET['cantidad'];
$fecha='STR_TO_DATE(\''.$_GET["fecha"].'\',\'%d/%m/%Y\')';
$descargo=$_GET['descargo'];
$id_dto=$_GET['id_departamento'];
$existencia=$_GET['txt_existencia'];
$id_usuario=$_GET['id_usuario'];
$modoop=$_GET['modoop'];

		// validar descargo
	if($descargo == ''){
		//verificando si exite variable de session descargo
		if($_SESSION['descargo'] == ''){		
			if($_SESSION['id_tipo']==2){
				$objCon=new Conexion();
				$objCon->Abrir();
				$sql="select max(descargo) + 1 as descargo from  descargo where NumBodega = 1";
				$objCon->RetornarRS($result, $sql);
				if ($objCon->ExisteRegistro($sql)){
					while($rs = $result->fetch_array()){
					$descargo=$rs[0];		
					}
				}
			}
			else if($_SESSION['id_tipo']==3){
				$objCon=new Conexion();
				$objCon->Abrir();
				$sql="select max(descargo) + 1 as descargo from  descargo where NumBodega = 2";
				$objCon->RetornarRS($result, $sql);
				if ($objCon->ExisteRegistro($sql)){
					while($rs = $result->fetch_array()){
					$descargo=$rs[0];		
					}
				}
			}
			//creacion de varible de session descargo
			$_SESSION['descargo']=$descargo;
		}
		else{
			//asignacion de variable de session a el descargo actual
			$descargo=$_SESSION['descargo'];
		}		
	}





if($existencia>=$cantidad){
$objCon=new Conexion();
$objCon->Abrir();

	//verificanco si ya existe una orden de compra con el numero ingresado
	$sql="SELECT count(*) as cuenta FROM descargo o where descargo=$descargo";
	//echo $sql."<br/>";
	$objCon->RetornarRS($result, $sql);
	  if ($objCon->ExisteRegistro($sql)){
		while($rs = $result->fetch_array()){
			$cuenta=$rs[0];		
		}
	  }

	//insertando orden de compras
	if ($cuenta==0){
		$sql_orden="INSERT INTO descargo(descargo,fecha,id_dto,id_estatus,NumBodega,id_usuario,id_auto)
			VALUES('$descargo',$fecha,$id_dto,0,1,$id_usuario,0)";
			//echo $sql_orden."<br />";
			$objCon->Ejecutar($sql_orden);
	}
$sql="call spGeneraExistencia($id_art)";
$objCon->RetornarRS($result, $sql);
  if ($objCon->ExisteRegistro($sql)){
  	  while($rs = $result->fetch_array())
		{
			$c_id_art=$rs[0];
			$c_cod_agru=$rs[1];
			$c_orden_compra=$rs[2];
			$c_cantidad=$rs[3];
			$c_precio=$rs[4];
			$c_total=$rs[5];
			$c_id_agru=$rs[6];
		
			if ($cantidad > $c_cantidad){
				    $sql_insert="INSERT INTO kardex(id_art,orden_compra,descargo,para_uso,fecha,precio,cantidad,id_mov,total,id_agru,id_prov,id_dto,id_auto,existencia_actual)
					VALUES($c_id_art,'$c_orden_compra','$descargo','',$fecha,$c_precio,$c_cantidad,2,$c_cantidad * $c_precio,$c_id_agru,0,$id_dto,0,
					(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 1)-
					(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 2)- $c_cantidad)";
					
					//echo $sql_insert;
					$objCon_insert=new Conexion();
					$objCon_insert->Abrir();
					$objCon_insert->Ejecutar($sql_insert);										
					$objCon_insert->Cerrar();
					
					$cantidad = $cantidad - $c_cantidad;
			}
			else{
				    $sql_insert="INSERT INTO kardex(id_art,orden_compra,descargo,para_uso,fecha,precio,cantidad,id_mov,total,id_agru,id_prov,id_dto,id_auto,existencia_actual)
					VALUES($c_id_art,'$c_orden_compra','$descargo','',$fecha,$c_precio,$cantidad,2,$cantidad * $c_precio,$c_id_agru,0,$id_dto,0,
					(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 1)-
					(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 2)- $cantidad)";
					//echo $sql_insert;
					$objCon_insert=new Conexion();
					$objCon_insert->Abrir();
					$objCon_insert->Ejecutar($sql_insert);
					$objCon_insert->Cerrar();
					break;
			
			}
		}
	}
$objCon->Cerrar();	
header("Location: buscar_descargo_consultar.php"); 	
}
else{
	echo "Kardex no puede ser negativo";
}
	

?>
