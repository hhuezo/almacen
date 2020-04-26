<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_POST["Opcion"])) {
            require_once('../conexion/conexion_usuario.php');
            require_once('../conexion/conexion_taller.php');

            if ($_POST["Opcion"] == 1) {

                $Fecha = $_POST["Fecha"];
                $Descargo = $_POST["Descargo"];
                $Oficina = $_POST["Oficina"];
                $Articulo = $_POST["Articulo"];
                $Cantidad = $_POST["Cantidad"];
                $Existencia = $_POST["Existencia"];



                $rs = mysqli_query($cn, "SELECT *  FROM descargo where Codigo = '$Descargo' ");

                //echo mysqli_num_rows($rs);
                if (mysqli_num_rows($rs) == 0) {
                    $sql = "insert into descargo (Codigo,Fecha,Oficina,Usuario) "
                            . "values ('$Descargo','$Fecha' ,$Oficina," . $_SESSION["IdUsuario"] . ")";

                    // echo $sql.'<br>';

                    mysqli_query($cn, $sql);
                }


                $rs_existencia = mysqli_query($cn, "select Orden,Precio,
                    sum( CASE
                      WHEN Movimiento = 1 THEN Cantidad
                      WHEN Movimiento = 2 THEN Cantidad * -1
                      END) As Existencia
                    FROM kardex where Articulo = $Articulo
                    group by Orden,Precio ");

                $i = 1;

                while ($row = mysqli_fetch_array($rs_existencia)) {
                    if ($row["Existencia"] > 0) {
                        $array_existencia[$i][1] = $row["Orden"];
                        $array_existencia[$i][2] = $row["Precio"];
                        $array_existencia[$i][3] = $row["Existencia"];
                        $i++;
                    }
                }


                $temp_cantidad = $Cantidad;
                $temp_existencia = $Existencia;
                for ($i = 1; $i <= count($array_existencia); $i++) {
                    if ($temp_cantidad <= $array_existencia[$i][3]) {
                        // echo $temp_cantidad .'   '. $array_existencia[$i][2] .'<br>';
                        $temp_existencia -= $temp_cantidad;

                        $sql = "insert into kardex (Fecha,Orden,Descargo,Articulo,Cantidad,Precio,Total,Movimiento,Existencia,Usuario,FechaIngreso) "
                                . "values('$Fecha'," . $array_existencia[$i][1] . ",(select Id from descargo where Codigo = '$Descargo'), $Articulo,$temp_cantidad," . $array_existencia[$i][2] . ","
                                . " $temp_cantidad * " . $array_existencia[$i][2] . ",2, $temp_existencia," . $_SESSION["IdUsuario"] . ",Now())";

                     //  echo $sql . '<br>';

                        $temp_existencia -= $temp_cantidad;
                        $resultado = mysqli_query($cn, $sql);

                        break;
                    } else {
                        // echo $array_existencia[$i][3].'   '. $array_existencia[$i][2] .'<br>';
                        $temp_existencia -= $array_existencia[$i][3];

                        $sql = "insert into kardex (Fecha,Orden,Descargo,Articulo,Cantidad,Precio,Total,Movimiento,Existencia,Usuario,FechaIngreso) "
                                . "values('$Fecha'," . $array_existencia[$i][1] . ",(select Id from descargo where Codigo = '$Descargo'), $Articulo," . $array_existencia[$i][3] . "," . $array_existencia[$i][2] . ","
                                . " " . $array_existencia[$i][3] . " * " . $array_existencia[$i][2] . ",2, $temp_existencia," . $_SESSION["IdUsuario"] . ",Now())";

                       // echo $sql.'<br>';

                        $resultado = mysqli_query($cn, $sql);


                        $temp_cantidad -= $array_existencia[$i][3];
                    }
                }

                if ($resultado) {
                    ?>
                    <script type="text/javascript">
                        consultar();
                    </script>


                    <?php
                } else {
                    echo ' <div align="center" class="alert alert-danger alert-dismissable">
                          <strong> No Agregado.</strong></div>';
                }
            }

            // salida de repuestos
            else if ($_POST["Opcion"] == 2) {

                $Fecha = $_POST["Fecha"];
                $Descargo = $_POST["Descargo"];
                $Articulo = $_POST["Articulo"];
                $Cantidad = $_POST["Cantidad"];
                $Existencia = $_POST["Existencia"];
                $OidSolicitud = $_POST["OidSolicitud"];
                $OidAutomovil = $_POST["OidAutomovil"];
                $Descripcion = $_POST["Descripcion"];
                $Marca = $_POST["Marca"];
                $Solicitud = $_POST["CodSolicitud"];
                $Equipo = $_POST["Equipo"];
                $Placa = $_POST["Placa"];

                //fecha para sql
                $fecha_bd = $Fecha;
                $fecha_format = date('d-m-Y', strtotime($fecha_bd));



                $rs = mysqli_query($cn, "SELECT *  FROM descargo where Codigo = '$Descargo' ");

                //echo mysqli_num_rows($rs);
                if (mysqli_num_rows($rs) == 0) {
                    $sql = "insert into descargo (Codigo,Fecha,Usuario) "
                            . "values ('$Descargo','$Fecha' ," . $_SESSION["IdUsuario"] . ")";

                   //  echo $sql.'<br>';

                    mysqli_query($cn, $sql);
                }

                $rs = mysqli_query($cn, "SELECT *  FROM vehiculo where Oid = '$OidAutomovil' ");

                //echo "SELECT *  FROM vehiculo where Oid = '$OidAutomovil' ";

                if (mysqli_num_rows($rs) == 0) {
                    $sql = "insert into vehiculo (Equipo,Placa,Marca,Descripcion,Oid) "
                            . "values ('$Equipo','$Placa' ,'$Marca' ,'$Descripcion' ,'$OidAutomovil' )";

                    // echo $sql.'<br>';

                    mysqli_query($cn, $sql);
                }


                $rs_art = mysqli_query($cn, "select articulo.Descripcion as NombreArticulo,medida.Descripcion as Medida from "
                        . "articulo inner join medida on articulo.Medida = medida.Id where articulo.Id = $Articulo");

                $row_art = mysqli_fetch_array($rs_art);


                $rs_existencia = mysqli_query($cn, "select Orden,Precio,
                    sum( CASE
                      WHEN Movimiento = 1 THEN Cantidad
                      WHEN Movimiento = 2 THEN Cantidad * -1
                      END) As Existencia
                    FROM kardex where Articulo = $Articulo
                    group by Orden,Precio ");

                $i = 1;

                while ($row = mysqli_fetch_array($rs_existencia)) {
                    if ($row["Existencia"] > 0) {
                        $array_existencia[$i][1] = $row["Orden"];
                        $array_existencia[$i][2] = $row["Precio"];
                        $array_existencia[$i][3] = $row["Existencia"];
                        $i++;
                    }
                }


                $temp_cantidad = $Cantidad;
                $temp_existencia = $Existencia;
                for ($i = 1; $i <= count($array_existencia); $i++) {
                    if ($temp_cantidad <= $array_existencia[$i][3]) {
                        // echo $temp_cantidad .'   '. $array_existencia[$i][2] .'<br>';
                        $temp_existencia -= $temp_cantidad;

                        $sql = "insert into kardex (Vehiculo,Fecha,Orden,Descargo,Articulo,Cantidad,Precio,Total,Movimiento,Existencia,Usuario,FechaIngreso,Solicitud) "
                                . "values((select Id from vehiculo where Oid = '$OidAutomovil' ),'$Fecha'," . $array_existencia[$i][1] . ",(select Id from descargo where Codigo = '$Descargo'), $Articulo,$temp_cantidad," . $array_existencia[$i][2] . ","
                                . " $temp_cantidad * " . $array_existencia[$i][2] . ",2, $temp_existencia," . $_SESSION["IdUsuario"] . ",Now(),$Solicitud)";

                        // echo $sql . '<br>';

                        $temp_existencia -= $temp_cantidad;
                        $resultado = mysqli_query($cn, $sql);

                        if ($resultado) {


                            $rs_max = mysqli_query($cn, "select max(Id) from kardex");
                            $row_max = mysqli_fetch_array($rs_max);


                            $ql_insert = "insert into CompraRepuesto(Oid,IdAlmacen,CompraRepuestos,TipoDocumentos,fecha,NumeroOrdenFactura,NumeroDescargo,Cantidad,UnidadMedida,Descripcion,PrecioUnitario)
                            values (NEWID()," . $row_max[0] . ",'$OidSolicitud',1,'$fecha_format','" . $array_existencia[$i][1] . "','$Descargo',$temp_cantidad,'" . $row_art["Medida"] . "','" . $row_art["NombreArticulo"] . "','" . $array_existencia[$i][2] . "')";
                            $params = array(1, "some data");

                            $stmt = sqlsrv_query($conn, $ql_insert, $params);
                        }


                        break;
                    } else {
                        // echo $array_existencia[$i][3].'   '. $array_existencia[$i][2] .'<br>';
                        $temp_existencia -= $array_existencia[$i][3];

                        $sql = "insert into kardex (Vehiculo,Fecha,Orden,Descargo,Articulo,Cantidad,Precio,Total,Movimiento,Existencia,Usuario,FechaIngreso,Solicitud) "
                                . "values((select Id from vehiculo where Oid = '$OidAutomovil' ),'$Fecha'," . $array_existencia[$i][1] . ",(select Id from descargo where Codigo = '$Descargo'), $Articulo," . $array_existencia[$i][3] . "," . $array_existencia[$i][2] . ","
                                . " " . $array_existencia[$i][3] . " * " . $array_existencia[$i][2] . ",2, $temp_existencia," . $_SESSION["IdUsuario"] . ",Now(),$Solicitud)";

                        // echo $sql.'<br>';
                        $resultado = mysqli_query($cn, $sql);


                        $temp_cantidad -= $array_existencia[$i][3];


                        if ($resultado) {
                            $rs_max = mysqli_query($cn, "select max(Id) from kardex");
                            $row_max = mysqli_fetch_array($rs_max);


                            $ql_insert = "insert into CompraRepuesto(Oid,IdAlmacen,CompraRepuestos,TipoDocumentos,fecha,NumeroOrdenFactura,NumeroDescargo,Cantidad,UnidadMedida,Descripcion,PrecioUnitario)
                            values (NEWID()," . $row_max[0] . ",'$OidSolicitud',1,'$fecha_format','" . $array_existencia[$i][1] . "','$Descargo','" . $array_existencia[$i][3] . "','" . $row_art["Medida"] . "','" . $row_art["NombreArticulo"] . "','" . $array_existencia[$i][2] . "')";

                            $params = array(1, "some data");

                            $stmt = sqlsrv_query($conn, $ql_insert, $params);
                        }
                    }
                }

                if ($resultado) {
                    ?>
                    <script type="text/javascript">
                        consultar();
                    </script>


                    <?php
                } else {
                    echo ' <div align="center" class="alert alert-danger alert-dismissable">
                          <strong> No Agregado.</strong></div>';
                }
            }

            sqlsrv_close();
            mysqli_close($cn);
        }
        ?>
    </body>
</html>
