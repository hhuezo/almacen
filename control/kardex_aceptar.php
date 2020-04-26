<html>
    <head>
        <meta charset="UTF-8">
        <title>kardex</title>

        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../css/principal.css">


        <style type="text/css">
            <!--
            .Style1 {
                border: thin solid #333333;
            }
            -->

        </style>
    </head>
    <body>

        <br>

        <?php
        if (isset($_GET["Articulo"])) {

            $fecha_temp = ($_GET["Axo"] - 1) . '-' . date("m-d");

            require_once('../conexion/conexion.php');

            $Articulo = $_GET["Articulo"];

            $rs = mysqli_query($cn, "SELECT articulo.Id,
                    articulo.Descripcion as Articulo,
                    cuenta.Codigo,
                    cuenta.Descripcion As Cuenta,
                    medida.Descripcion As Medida,
                    articulo.Estante,
                    articulo.Casilla
             FROM (articulo articulo
                   INNER JOIN medida medida
                      ON (articulo.Medida = medida.Id))
                  INNER JOIN cuenta cuenta
                     ON (articulo.Cuenta = cuenta.Id) where articulo.Id = $Articulo");

            $row = mysqli_fetch_array($rs);
            ?>

        <table width="946" border="1" align="center">
                <tr>
                    <td width="569"><strong>ARTICULO:</strong> <?php echo ' ' . $row["Articulo"]; ?>
                        <br><strong>CODIGO: </strong> <?php echo ' ' . $row["Codigo"]; ?>
                        <BR><strong>CUENTA CONTABLE: </strong> <?php echo ' ' . $row["Cuenta"]; ?>
                        <br><strong>UNIDAD DE MEDIDA:</strong> <?php echo ' ' . $row["Medida"]; ?>
                        <br>
                        <strong>ESTANTE:</strong>  <?php echo ' ' . $row["Estante"] . '    '; ?>  &nbsp;&nbsp;&nbsp;&nbsp; <strong> CASILLA:</strong> <?php echo ' ' . $row["Casilla"]; ?>
                    </td>
                    <td width="16">&nbsp;&nbsp;&nbsp;</td>
                    <td width="539">
                        <table border="1" align="center">
                            <tr class="row_k1">
                                <td colspan="9" align="center">EXISTENCIA</td>
                            </tr>
                            <tr class="<?php
                            $cont = 1;
                            echo (($cont % 2) == 0) ? 'row1' : 'row2';
                            ?>">
                                <td align="center"><strong>COD AGRU</strong></td>
                                <td><strong>&nbsp;&nbsp;</strong></td>
                                <td align="center"><strong>ORDEN DE COMPRA</strong></td>
                                <td><strong>&nbsp;&nbsp;</strong></td>
                                <td align="center"><strong>CANTIDAD</strong></td>
                                <td><strong>&nbsp;&nbsp;</strong></td>
                                <td align="center"><strong>PRECIO</strong></td>
                                <td><strong>&nbsp;&nbsp;</strong></td>
                                <td align="center"><strong>TOTAL</strong></td>
                            </tr>
                            <?php
                            $cont++;
                            $Cantidad = 0;
                            $Total = 0;

                            $rs = mysqli_query($cn, "select agrupacion.Codigo AS Agrupacion,kardex.Orden,kardex.Precio,
                            sum( CASE
                              WHEN Movimiento = 1 THEN Cantidad
                              WHEN Movimiento = 2 THEN Cantidad * -1
                              END) As Existencia
                            FROM kardex 
                            inner join orden on kardex.Orden = orden.Id 
                            INNER JOIN agrupacion ON agrupacion.Id = orden.Agrupacion
                            where Articulo = $Articulo
                            group by Orden,Precio  order by Orden ;");

                            while ($row = mysqli_fetch_array($rs)) {

                                if ($row["Existencia"] > 0) {
                                    ?>
                                    <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                                        <td align="center"><?php echo $row["Agrupacion"]; ?></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="center"><?php echo $row["Orden"]; ?></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="center"><?php echo $row["Existencia"]; ?></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="center">$<?php echo number_format($row["Precio"], 4); ?></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="center">$<?php echo number_format($row["Precio"] * $row["Existencia"], 4); ?></td>
                                    </tr>

                                    <?php
                                    $cont++;
                                    $Total += $row["Precio"] * $row["Existencia"];
                                    $total_cantidad += $row["Existencia"];
                                }
                            }
                            ?>
                            <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                                <td colspan="4" align="center"><strong>TOTAL</strong></td>
                                <td align="center"><strong><?php echo $total_cantidad; ?></strong></td>
                                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                                <td align="center"><strong>$<?php echo number_format($Total, 4); ?></strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>



            <?php
            //consulta para año acatual
            if ($_GET["Axo"] == 0) {
                $rs = mysqli_query($cn, "SELECT kardex.Id,
                        date_format(kardex.Fecha, '%d/%m/%Y') as Fecha,
                        kardex.Factura,
                        orden.Codigo as Orden,
                        descargo.Codigo as Descargo,
                        agrupacion.Codigo as Agrupacion,
                        proveedor.Descripcion as Proveedor,
                      CASE WHEN kardex.Vehiculo > 1
                        THEN
                            ''
                            ELSE
                             oficina.Descripcion                             
                         END AS Oficina,
                        CASE WHEN kardex.Vehiculo > 1 AND kardex.Movimiento = 2
                               THEN CONCAT( 'EQ- ', vehiculo.Equipo) 
                               ELSE ''
                        END AS Equipo,
                        CASE WHEN kardex.Vehiculo > 1 AND kardex.Movimiento = 2
                               THEN CONCAT( 'P- ', vehiculo.Placa) 
                               ELSE ''
                        END AS Placa,
                        
                        CASE WHEN kardex.Solicitud > 0
                             THEN CONCAT( ' (Sol. No ', kardex.Solicitud,')' )
                            ELSE ''
                        END AS Solicitud,
                        kardex.Cantidad,
                        kardex.Precio,
                        kardex.Total,
                        kardex.Movimiento,
                        kardex.Existencia,
                        kardex.Vehiculo
                 FROM kardex kardex
                   INNER JOIN orden orden ON orden.Id = kardex.Orden
                 INNER JOIN proveedor proveedor  ON orden.Proveedor = proveedor.Id
                          INNER JOIN agrupacion agrupacion ON orden.Agrupacion = agrupacion.Id
                         LEFT JOIN descargo descargo  ON descargo.Id = kardex.Descargo
                        LEFT JOIN oficina oficina ON oficina.Id = descargo.Oficina
                       INNER JOIN vehiculo vehiculo ON kardex.Vehiculo = vehiculo.Id     
                      where kardex.Articulo = $Articulo order by kardex.Id desc");
            }
            //consulta para todos los registros
            else {
                $rs = mysqli_query($cn, "SELECT kardex.Id,
                        date_format(kardex.Fecha, '%d/%m/%Y') as Fecha,
                        kardex.Factura,
                        orden.Codigo as Orden,
                        descargo.Codigo as Descargo,
                        agrupacion.Codigo as Agrupacion,
                        proveedor.Descripcion as Proveedor,
                      CASE WHEN kardex.Vehiculo > 1
                        THEN
                            ''
                            ELSE
                             oficina.Descripcion                             
                         END AS Oficina,
                        CASE WHEN kardex.Vehiculo > 1 AND kardex.Movimiento = 2
                               THEN CONCAT( 'EQ- ', vehiculo.Equipo) 
                               ELSE ''
                        END AS Equipo,
                        CASE WHEN kardex.Vehiculo > 1 AND kardex.Movimiento = 2
                               THEN CONCAT( 'P- ', vehiculo.Placa) 
                               ELSE ''
                        END AS Placa,
                         CASE WHEN kardex.Solicitud > 0
                            THEN CONCAT( ' (Sol. No ', kardex.Solicitud,')' )
                            ELSE ''
                        END AS Solicitud,
                        kardex.Cantidad,
                        kardex.Precio,
                        kardex.Total,
                        kardex.Movimiento,
                        kardex.Existencia,
                        kardex.Vehiculo
                 FROM kardex kardex
                   INNER JOIN orden orden ON orden.Id = kardex.Orden
                 INNER JOIN proveedor proveedor  ON orden.Proveedor = proveedor.Id
                          INNER JOIN agrupacion agrupacion ON orden.Agrupacion = agrupacion.Id
                         LEFT JOIN descargo descargo  ON descargo.Id = kardex.Descargo
                        LEFT JOIN oficina oficina ON oficina.Id = descargo.Oficina
                       INNER JOIN vehiculo vehiculo ON kardex.Vehiculo = vehiculo.Id     
                      where kardex.Articulo = $Articulo and kardex.Fecha > '" . $fecha_temp . "' order by kardex.Id desc");
            }
            ?>

            <table width="1055" border="1" align="center" >
                <tr class="row_k1" bgcolor=#e5eecc>                    
                    <td width="56" align="center" class="Style1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;FECHA&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                    <td width="29" align="center" class="Style1"><strong>&nbsp;&nbsp;O.C&nbsp;&nbsp;</strong></td>
                    <td width="45" align="center" class="Style1"><strong>&nbsp;&nbsp;FACT.&nbsp;&nbsp;</strong></td>
                    <td width="62" align="center" class="Style1"><strong>AGRUP.<br>
                            OPERA.</strong></td>
                    <td width="89" align="center" class="Style1"><strong>DESCARGO</strong></td>
                    <td width="106" align="center" class="Style1"><strong>PROVEEDOR</strong></td>
                    <td width="123" align="center" class="Style1"><strong>DESTINO</strong></td>
                    <td width="85" align="center" class="Style1"><strong>CANTIDAD</strong></td>
                    <td width="60" align="center" class="Style1"><strong>&nbsp;&nbsp;PRECIO&nbsp;&nbsp;</strong></td>
                    <td width="53" align="center" class="Style1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;TOTAL&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                    <td width="54" align="center" class="Style1"><strong>EXIST.</strong></td>
                    <td width="61" align="center" class="Style1"><strong>EDITAR</strong></td>
                </tr>


                <?php
                $cont = 1;
                while ($row = mysqli_fetch_array($rs)) {
                    if ($row["Movimiento"] == 1) {
                        $color = "row_k1";
                    } else if (($cont % 2) == 0) {
                        $color = "row2";
                    } else {
                        $color = "row1";
                    }
                    ?>
                    <tr class="<?php echo $color; ?>">
                        <td align="center" class="Style1"><?php echo $row["Fecha"]; ?></td>
                        <td align="center" class="Style1"><?php echo $row["Orden"]; ?></td>
                        <td align="center" class="Style1"><?php echo $row["Fectura"]; ?></td>
                        <td align="center" class="Style1">(<?php echo $row["Agrupacion"]; ?>)</td>
                        <td align="center" class="Style1"><?php echo $row["Descargo"]; ?></td>
                        <td align="center" class="Style1"><?php echo $row["Proveedor"]; ?></td>
                        <td align="center" class="Style1"><?php echo $row["Oficina"] . ' ' . $row["Equipo"] . ' ' . $row["Placa"]. ' ' . $row["Solicitud"]; ?></td>
                        <td align="center" class="Style1"><?php echo $row["Cantidad"]; ?></td>
                        <td align="center" class="Style1">$<?php echo number_format($row["Precio"], 4); ?></td>
                        <td align="center" class="Style1">$<?php echo number_format($row["Total"], 4); ?></td>
                        <td align="center" class="Style1"><?php echo $row["Existencia"]; ?></td>
                        <td align="center" class="Style1"><a href="kerdex_modificar.php?Id=<?php echo $row["Id"]; ?>&Mov=<?php echo $row["Movimiento"]; ?>&Vehiculo=<?php echo $row["Vehiculo"]; ?>">  EDITAR </a></td>
                    </tr>

                    <?php
                    $cont++;
                }
            }
            ?>
    </body>
</html>
