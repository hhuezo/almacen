
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script type="text/javascript" src="ajax.js"></script>
    </head>
    <body>

        <?php

        include('conexion/conexion.php');
        session_start();
        if (isset($_POST['Operacion']) && $_POST['Operacion'] == '1') {

            $Fecha = $_POST["Fecha"];
            $Descargo = $_POST['Descargo'];
            $NumeroSolicitud = $_POST['Solicitud'];
            $Auto = $_POST['Vehiculo'];
            $Articulo = $_POST['Articulo'];
            $Cantidad = $_POST['Cantidad'];
            $Oid = $_POST['Oid'];
            
            $d_fecha = date("d/m/Y", strtotime($Fecha));



            $rs = mysql_query("SELECT articulo.id_art, 
		(select ifnull(sum(cantidad),0) from kardex k where k.id_art=articulo.id_art and id_mov=1)-	
		(select ifnull(sum(cantidad),0) from kardex k where k.id_art=articulo.id_art and id_mov=2) as existencia
                FROM articulo articulo                    
                     where   articulo.id_art =  $Articulo");
            $row = mysql_fetch_array($rs);
            echo $row["existencia"].' - '.$Cantidad;

            if ($row["existencia"] >= $Cantidad) {

                // validar descargo
                if ($Descargo == '') {

                    //calculando el numero de descargo
                    $rs = mysql_query("select max(descargo) + 1 as descargo from  descargo where NumBodega = 1");
                    $row = mysql_fetch_array($rs);
                    $Descargo = $row[0];

                    //insertando nuevo descargo
                    $sql = "INSERT INTO descargo(descargo,fecha,id_dto,id_estatus,NumBodega,id_usuario,id_auto,Codigo)
                    VALUES('$Descargo','$Fecha',0,0,2," . $_SESSION['id_usuario'] . ",$Auto,'$Descargo')";
                    //echo $sql;

                    $resultado = mysql_query($sql);
                    if ($resultado) {
                        $cuenta = 1;
                    }
                } else {
                    //echo 'hola';
                    $rs = mysql_query("select descargo from  descargo where NumBodega = 1 and Codigo = '" . $Descargo . "'");
                    $numFilas = mysql_num_rows($rs);
                    //echo $numFilas;

                    if ($numFilas == 0) {
                        //insertando nuevo descargo
                        $sql = "INSERT INTO descargo(descargo,fecha,id_dto,id_estatus,NumBodega,id_usuario,id_auto,Codigo)
                        VALUES($Descargo,'$Fecha',0,0,1," . $_SESSION['id_usuario'] . ",$Auto,'$Descargo')";
                        $resultado = mysql_query($sql);
                        //echo $sql;

                        if ($resultado) {
                            $cuenta = 1;
                        }
                    }

                    $cuenta = 1;
                }

                if ($cuenta > 0) {

                    $rs = mysql_query("SELECT k.orden_compra as orden,
              sum(k.cantidad) as o_cantidad,
              k.precio as precio,
              agrupacion_operacional.id_agru as agupacion,
              k.numero_factura
              FROM almacen.agrupacion_operacional agrupacion_operacional
              INNER JOIN almacen.kardex k
              ON (agrupacion_operacional.id_agru = k.id_agru) where k.id_mov = 1 and id_art = $Articulo
              group by k.orden_compra, k.precio order by k.fecha");

                    $d_cantidad = $Cantidad;
                    while ($row = mysql_fetch_array($rs)) {

                        $rs2 = mysql_query("select ifnull(sum(cantidad),0) as s_cantidad  from kardex k where id_art = $Articulo and id_mov = 2 and precio = " . $row["precio"] . "
                    and orden_compra = " . $row["orden"]);
                        $row2 = mysql_fetch_array($rs2);

                        //restamos las entradas menos las salidas
                        $cantidad_disponible = $row["o_cantidad"] - $row2["s_cantidad"];


                        if ($cantidad_disponible > 0 && $d_cantidad > 0) {
                            $orden_temp = $row["orden"];
                            $precio_temp = $row["precio"];
                            $agrupacion_temp = $row["agupacion"];
                            $factura_temp = $row["numero_factura"];

                            if ($d_cantidad <= $cantidad_disponible) {
                                //echo $d_cantidad;                            

                                $sql = "insert into kardex (id_art,orden_compra,descargo,para_uso,fecha,precio,cantidad,id_mov,total,id_agru,id_prov,id_dto,id_auto,NumSolicitud,existencia_actual,usuario,numero_factura,fecha_ingreso)values
                            ($Articulo,$orden_temp,$Descargo,'','$Fecha',$precio_temp,$d_cantidad,2,$precio_temp*$d_cantidad,$agrupacion_temp,0,0,$Auto,$NumeroSolicitud,
                                 (select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $Articulo and kar.id_mov = 1)-
					(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $Articulo and kar.id_mov = 2)- $d_cantidad,'" . $_SESSION["username"] . "','$factura_temp',Now())";
                                //echo $sql;
                                mysql_query($sql);

                                // consulta para saber id de kardex                                
                                $rs_kardex= mysql_query("select max(id_kar) from kardex where id_art =$Articulo");                               
                                $row_kardex = mysql_fetch_array($rs_kardex);
                                $id_kardex = $row_kardex [0];
                                
                                //consulta para la unidad de medida
                                $rs_unidad = mysql_query("select a.nom_art,u.nom_med from articulo a inner join uni_med u on a.id_um = u.id_um where a.id_art =$Articulo");
                                $row_unidad = mysql_fetch_array($rs_unidad);
                                $nombre_articulo = $row_unidad[0];
                                $nombre_medida = $row_unidad[1];



                                //conexion sql para sistema de taller
                                $conn = odbc_connect("odbcTaller", "Taller", "Ta11er")or die("error EN LA CONEXION");

                                //echo 'conexion existe';
                                $qlInsertSolicitud = "insert into CompraRepuesto(Oid,CompraRepuestos,IdAlmacen,TipoDocumentos,fecha,NumeroOrdenFactura,NumeroDescargo,Cantidad,UnidadMedida,Descripcion,PrecioUnitario)
						values (NEWID(),'$Oid',$id_kardex,1,'$d_fecha','$orden_temp','$Descargo',$d_cantidad,'$nombre_medida','$nombre_articulo','$precio_temp')";
                                echo $qlInsertSolicitud;
                                $resulInsertSolicitud = odbc_exec($conn, $qlInsertSolicitud);
                                $sqlUpdate = "update SolicitudReparacion set EstadoSolicitud=8 where oid = '$Oid'";
                                $resultsqlUpdate = odbc_exec($conn, $sqlUpdate);
                                odbc_close($conn);


                                $d_cantidad = 0;
                                break;
                            } else {


                                $sql = "insert into kardex (id_art,orden_compra,descargo,para_uso,fecha,precio,cantidad,id_mov,total,id_agru,id_prov,id_dto,id_auto,NumSolicitud,existencia_actual,usuario,numero_factura,fecha_ingreso)values
                            ($Articulo,$orden_temp,$Descargo,'','$Fecha',$precio_temp,$cantidad_disponible,2,$precio_temp*$cantidad_disponible,$agrupacion_temp,0,0,$Auto,$NumeroSolicitud,
                                 (select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $Articulo and kar.id_mov = 1)-
					(select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $Articulo and kar.id_mov = 2)- $cantidad_disponible,'" . $_SESSION["username"] . "','$factura_temp',Now())";
                                mysql_query($sql);
                                echo $sql . '<br>';
                                
                                 // consulta para saber id de kardex                                
                                $rs_kardex= mysql_query("select max(id_kar) from kardex where id_art =$Articulo");
                                $row_kardex = mysql_fetch_array($rs_kardex);
                                $id_kardex = $row_kardex [0];
                                
                                //consulta para la unidad de medida
                                $rs_unidad = mysql_query("select a.nom_art,u.nom_med from articulo a inner join uni_med u on a.id_um = u.id_um where a.id_art =$Articulo");
                                $row_unidad = mysql_fetch_array($rs_unidad);
                                $nombre_articulo = $row_unidad[0];
                                $nombre_medida = $row_unidad[1];



                                //conexion sql para sistema de taller
                                $conn = odbc_connect("odbcTaller", "Taller", "Ta11er")or die("error EN LA CONEXION");

                                //echo 'conexion existe';
                                $qlInsertSolicitud = "insert into CompraRepuesto(Oid,CompraRepuestos,IdAlmacen,TipoDocumentos,fecha,NumeroOrdenFactura,NumeroDescargo,Cantidad,UnidadMedida,Descripcion,PrecioUnitario)
						values (NEWID(),'$Oid',$id_kardex,1,'$d_fecha','$orden_temp','$Descargo',$cantidad_disponible,'$nombre_medida','$nombre_articulo','$precio_temp')";
                                echo $qlInsertSolicitud;
                                $resulInsertSolicitud = odbc_exec($conn, $qlInsertSolicitud);
                                $sqlUpdate = "update SolicitudReparacion set EstadoSolicitud=8 where oid = '$Oid'";
                                $resultsqlUpdate = odbc_exec($conn, $sqlUpdate);
                                odbc_close($conn);

                                $d_cantidad = $d_cantidad - $cantidad_disponible;
                            }
                        }
                    }
                   
                    mysql_close();

                     header("Location: descargo_consultar.php?Descargo=$Descargo");
                } else {

                    echo '<div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>error, el descargo no existe</strong> </div>';

                    mysql_close();
                }
            } else {
                echo '<div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>error,la cantidad ingresada es mayor que la existencia</strong> </div>';

                mysql_close();
            }
        }






        if (isset($_POST['Operacion']) && $_POST['Operacion'] == 'guardar_descargo') {
            $descargo = $_POST['Descargo'];
            $sql = "update descargo SET id_estatus = 1 where descargo = " . $descargo;
            mysql_query($sql);
            mysql_close();
            ?>

                <!--<center><a href=""><input type="button" name="btnModificar" id="btnModificar" value="Imprimir" class="btn btn-info" 
                                          OnClick="window.open('imprimirDescargo.php?descargo=<?php echo $descargo; ?>', 'popup', 1000, 1000, 1, 1, 0, 0, 0, 1, 0);
                                                  return false;"></a></center>-->

            <?php
            echo ' <div align="center" class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> Descargo guardado.</strong></div>';
        }
        ?>


    </script>
</body>
</html>
