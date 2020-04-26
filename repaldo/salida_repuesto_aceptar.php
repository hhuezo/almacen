<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        require_once('clases/conexion.php');

// Recuperar los datos enviados del formulario
        $id_art = $_GET['id_articulo'];
        $cantidad = $_GET['cantidad'];
        $fecha = $_GET["fecha"];
        $descargo = $_GET['descargo'];
        $id_auto = $_GET['id_auto'];
        $existencia = $_GET['txt_existencia'];
        $id_usuario = $_GET['id_usuario'];
        $modoop = $_GET['modoop'];

        if ($_GET['txt_numeroSolicitud'] == '') {
            $txt_numeroSolicitud = 0;
        } else {
            $txt_numeroSolicitud = $_GET['txt_numeroSolicitud'];
        }


//atributos para base de datos de taller
        $nom_art = $_GET['txt_articulo'];
        $Oid = $_GET['Oid'];
        $fecha_sql = substr($_GET["fecha"], 8, 2).'-'.substr($_GET["fecha"], 5, 2).'-'.substr($_GET["fecha"], 0, 4);
		


        // validar descargo
        if ($descargo == '') {
            //verificando si exite variable de session descargo
            if ($_SESSION['descargo'] == '') {
                if ($_SESSION['id_tipo'] == 2) {
                    $objCon = new Conexion();
                    $objCon->Abrir();
                    $sql = "select ifnull(max(descargo),0) + 1 as descargo from  descargo where NumBodega = 1";
                    $objCon->RetornarRS($result, $sql);
                    if ($objCon->ExisteRegistro($sql)) {
                        while ($rs = $result->fetch_array()) {
                            $descargo = $rs[0];
                        }
                    }
                } else if ($_SESSION['id_tipo'] == 3) {
                    $objCon = new Conexion();
                    $objCon->Abrir();
                    $sql = "select ifnull(max(descargo),0) + 1 as descargo from  descargo where NumBodega = 2";
                    $objCon->RetornarRS($result, $sql);
                    if ($objCon->ExisteRegistro($sql)) {
                        while ($rs = $result->fetch_array()) {
                            $descargo = $rs[0];
                        }
                    }
                }
                //creacion de varible de session descargo
                $_SESSION['descargo'] = $descargo;
            } else {
                //asignacion de variable de session a el descargo actual
                $descargo = $_SESSION['descargo'];
            }
        }
		else{
			
			$_SESSION['descargo'] = $descargo;
		}



        if ($existencia >= $cantidad) {
            $objCon = new Conexion();
            $objCon->Abrir();

            //verificanco si ya existe una orden de compra con el numero ingresado
            $sql = "SELECT count(*) as cuenta FROM descargo o where descargo=$descargo";
            //echo $sql . "<br/>";
            $objCon->RetornarRS($result, $sql);
            if ($objCon->ExisteRegistro($sql)) {
                while ($rs = $result->fetch_array()) {
                    $cuenta = $rs[0];
                }
            }

            //echo $cuenta;
            //insertando descargo
            if ($cuenta == 0) {
                $sql_orden = "INSERT INTO descargo(descargo,fecha,id_dto,id_estatus,NumBodega,id_usuario,id_auto)
			VALUES('$descargo','$fecha',0,0,(select numero_bodega from articulo where id_art = $id_art),$id_usuario,$id_auto)";
                //echo $sql_orden . "<br />";
                $objCon->Ejecutar($sql_orden);
            }



            $sql = "call spGeneraExistencia($id_art)";
            $objCon->RetornarRS($result, $sql);
            if ($objCon->ExisteRegistro($sql)) {
                while ($rs = $result->fetch_array()) {
                    $c_id_art = $rs[0];
                    $c_cod_agru = $rs[1];
                    $c_orden_compra = $rs[2];
                    $c_cantidad = $rs[3];
                    $c_precio = $rs[4];
                    $c_total = $rs[5];
                    $c_id_agru = $rs[6];

                    if ($cantidad > $c_cantidad) {
                        $sql_insert = "INSERT INTO kardex(id_art,orden_compra,descargo,para_uso,fecha,precio,cantidad,id_mov,total,id_agru,id_prov,id_dto,id_auto,NumSolicitud,numero_factura,existencia_actual)
					VALUES($c_id_art,$c_orden_compra,$descargo,'','$fecha',$c_precio,$c_cantidad,2,$c_cantidad * $c_precio,$c_id_agru,0,0,$id_auto,$txt_numeroSolicitud,
					(select kar.numero_factura from kardex kar where kar.orden_compra = $c_orden_compra and kar.id_art = $c_id_art and kar.id_mov = 1 and kar.precio = $c_precio),
					(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 1)-
					(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 2)- $c_cantidad)";

                        $objCon_insert = new Conexion();
                        $objCon_insert->Abrir();
                        $objCon_insert->Ejecutar($sql_insert);
                        $objCon_insert->Cerrar();

                        echo $sql_insert."<br />";


                        $cantidad = $cantidad - $c_cantidad;					
						
						
						
						

                        if ($Oid != "") {
                            $sql = "select u.nom_med from articulo a inner join uni_med u on a.id_um = u.id_um where a.id_art =$id_art";
                            //echo $sql."<br/>";
                            $objCon->RetornarRS($result, $sql);
                            if ($objCon->ExisteRegistro($sql)) {
                                while ($rs = $result->fetch_array()) {
                                    $nombre_medida = $rs[0];
                                }
                            }
							
							$sql = "select max(id_kar) from kardex  where id_art =$id_art";
                            //echo $sql."<br/>";
                            $objCon->RetornarRS($result, $sql);
                            if ($objCon->ExisteRegistro($sql)) {
                                while ($rs = $result->fetch_array()) {
                                    $id_kar = $rs[0];
                                }
                            }
							
							
							
							

                            //conexion sql para sistema de taller
                            $conn = odbc_connect("odbcTaller", "Taller", "Ta11er")or die("error EN LA CONEXION");

                            //echo 'conexion existe';
                            $qlInsertSolicitud = "insert into CompraRepuesto(Oid,CompraRepuestos,TipoDocumentos,fecha,NumeroOrdenFactura,NumeroDescargo,Cantidad,UnidadMedida,Descripcion,PrecioUnitario,IdAlmacen)
						values (NEWID(),'$Oid',1,'$fecha_sql','$c_orden_compra','$descargo',$c_cantidad,'$nombre_medida','$nom_art','$c_precio',$id_kar)";
                            //echo $qlInsertSolicitud;
                            $resulInsertSolicitud = odbc_exec($conn, $qlInsertSolicitud);
                            $sqlUpdate = "update SolicitudReparacion set EstadoSolicitud=8 where oid = '$Oid'";
                            $resultsqlUpdate = odbc_exec($conn, $sqlUpdate);
                            odbc_close($conn);
                        }
                    } else {
                        $sql_insert = "INSERT INTO kardex(id_art,orden_compra,descargo,para_uso,fecha,precio,cantidad,id_mov,total,id_agru,id_prov,id_dto,id_auto,NumSolicitud,numero_factura,existencia_actual)
					VALUES($c_id_art,$c_orden_compra,$descargo,'','$fecha',$c_precio,$cantidad,2,$cantidad * $c_precio,$c_id_agru,0,0,$id_auto,$txt_numeroSolicitud,
					(select kar.numero_factura from kardex kar where kar.orden_compra = $c_orden_compra and kar.id_art = $c_id_art and kar.id_mov = 1 and kar.precio = $c_precio),
					(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 1)-
					(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 2)- $cantidad)";
                        echo $sql_insert."<br />";
                        $objCon_insert = new Conexion();
                        $objCon_insert->Abrir();
                        $objCon_insert->Ejecutar($sql_insert);
                        $objCon_insert->Cerrar();

                        if ($Oid != "") {
                            $sql = "select u.nom_med from articulo a inner join uni_med u on a.id_um = u.id_um where a.id_art =$id_art";
                            //echo $sql."<br/>";
                            $objCon->RetornarRS($result, $sql);
                            if ($objCon->ExisteRegistro($sql)) {
                                while ($rs = $result->fetch_array()) {
                                    $nombre_medida = $rs[0];
                                }
                            }
							
							
							
							$sql = "select max(id_kar) from kardex  where id_art =$id_art";
                            //echo $sql."<br/>";
                            $objCon->RetornarRS($result, $sql);
                            if ($objCon->ExisteRegistro($sql)) {
                                while ($rs = $result->fetch_array()) {
                                    $id_kar = $rs[0];
                                }
                            }
							

                            //conexion sql para sistema de taller
                            $conn = odbc_connect("odbcTaller", "Taller", "Ta11er")or die("error EN LA CONEXION");
                            //echo 'conexion existe';
                            $qlInsertSolicitud = "insert into CompraRepuesto(Oid,CompraRepuestos,TipoDocumentos,fecha,NumeroOrdenFactura,NumeroDescargo,Cantidad,UnidadMedida,Descripcion,PrecioUnitario,IdAlmacen)
							values (NEWID(),'$Oid',1,'$fecha_sql','$c_orden_compra','$descargo',$cantidad,'$nombre_medida','$nom_art','$c_precio',$id_kar)";
                            //echo $qlInsertSolicitud;
                            $resulInsertSolicitud = odbc_exec($conn, $qlInsertSolicitud);
                            $sqlUpdate = "update SolicitudReparacion set EstadoSolicitud=8 where oid = '$Oid'";
                            $resultsqlUpdate = odbc_exec($conn, $sqlUpdate);
                            odbc_close($conn);
                        }
                        break;
                    }
                }
            }
            header("Location: salida_repuesto_consultar.php");
        } else {
            echo "Kardex no puede ser negativo";
        }
        $objCon->Cerrar();
        ?>
    </body>
</html>
