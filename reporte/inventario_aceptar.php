<?php
if (isset($_GET["Opcion"]) && $_GET["Opcion"] == 1) {
    header("Content-Type: application/vnd.ms-excel");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("content-disposition: attachment;filename=Inventario.xls");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            <!--
            .Estilo1 {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: bold;
            }
            .Estilo2 {font-family: Arial, Helvetica, sans-serif}
            -->
        </style>
    </head>
    <body>

        <?php
        require_once('../conexion/conexion.php');
        $Cuenta = $_GET["Cuenta"];
        $Fecha = $_GET["Fecha"];
        $Opcion = $_GET["Opcion"];

        if ($Cuenta == 0) {
            $rs_cuenta = mysqli_query($cn, "SELECT cuenta.Id,cuenta.Descripcion, cuenta.Numero,
            (select ifnull(sum(Cantidad),0) from kardex k inner join articulo a ON k.Articulo = a.Id where a.Cuenta = cuenta.Id and k.Movimiento = 1 and k.Fecha <= '$Fecha')-
            (select ifnull(sum(Cantidad),0) from kardex k inner join articulo a ON k.Articulo = a.Id where a.Cuenta = cuenta.Id and k.Movimiento = 2 and k.Fecha <= '$Fecha') as Existencia
            from cuenta where Id >0 ");
        } else {
            $rs_cuenta = mysqli_query($cn, "SELECT cuenta.Id,cuenta.Descripcion, cuenta.Numero,
            (select ifnull(sum(Cantidad),0) from kardex k inner join articulo a ON k.Articulo = a.Id where a.Cuenta = cuenta.Id and k.Movimiento = 1 and k.Fecha <= '$Fecha')-
            (select ifnull(sum(Cantidad),0) from kardex k inner join articulo a ON k.Articulo = a.Id where a.Cuenta = cuenta.Id and k.Movimiento = 2 and k.Fecha <= '$Fecha') as Existencia
            from cuenta where Id = $Cuenta");
        }

        $i = 1;
        $total = 0;
        while ($row_cuenta = mysqli_fetch_array($rs_cuenta)) {
            $ArrayCuenta[$i][1] = $row_cuenta["Id"];
            $ArrayCuenta[$i][2] = $row_cuenta["Descripcion"];
            $ArrayCuenta[$i][3] = $row_cuenta["Numero"];
            $ArrayCuenta[$i][5] = 0;
            $i++;
        }




        for ($i = 1; $i <= count($ArrayCuenta); $i++) {

            $rs = mysqli_query($cn, "select m.Descripcion as Medida, a.Descripcion as Articulo,k.Precio,
            sum( CASE
                WHEN Movimiento = 1 THEN Cantidad
                WHEN Movimiento = 2 THEN Cantidad * -1
             END) As Existencias
           from kardex k 
           inner join articulo a ON a.Id = k.Articulo 
           inner join cuenta c ON c.Id = a.Cuenta
           inner join medida m ON m.Id = a.Medida
           where  k.Fecha <= '$Fecha' and a.Cuenta = " . $ArrayCuenta[$i][1] . " 
           #quitar el ultimo and
            #and a.NumBodega = 1
           group by a.Id,k.Precio  
           order by a.Id;");
            ?>

            <table width="90%" border="1" align="center">
                <tr>
                    <td colspan="5"><div align="center" class="Estilo1">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA <br/>
                            INVENTARIO DE EXISTENCIAS DE BIENES DE CONSUMO <br/>
                            ALMACEN DE BIENES EN EXISTENCIA <br/>
                            INVENTARIO DE <?php echo $ArrayCuenta[$i][2]; ?> <br/>
                            AL <?php echo date("d/m/Y", strtotime($Fecha)); ?>
                        </div></td>
                </tr>
                <tr>
                    <td><div align="center" class="Estilo2">UNIDAD DE<br>
                            MEDIDA</div></td>
                    <td><div align="center" class="Estilo2">DESCRIPCIÓN</div></td>
                    <td><div align="center" class="Estilo2">CANT.</div></td>
                    <td><div align="center" class="Estilo2">PRECIO<br>
                            UNITARIO</div></td>
                    <td><div align="center" class="Estilo2">TOTAL</div></td>
                </tr>

                <?php
                $total = 0;
                while ($row = mysqli_fetch_array($rs)) {
                    if ($row["Existencias"] > 0) {
                        ?>
                        <tr align="center" class="Estilo2">
                            <td><?php echo $row["Medida"]; ?></td>
                            <td align="left"><?php echo $row["Articulo"]; ?></td>
                            <td><?php echo $row["Existencias"]; ?></td>
                            <td align="right">$<?php echo number_format($row["Precio"], 4, '.', ''); ?></td>
                            <td align="right">$<?php echo number_format($row["Existencias"] * $row["Precio"], 4, '.', ''); ?></td>
                        </tr>

                        <?php
                        $total += $row["Existencias"] * $row["Precio"];
                        $ArrayCuenta[$i][5] ++;
                    }
                }
                ?>
                <tr align="right" class="Estilo1">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>$<?php echo number_format($total, 4, '.', ''); ?></td>
                </tr>               
            </table>
            <br/> <br/>

            <?php
            $ArrayCuenta[$i][4] = $total;
        }


        if ($Cuenta == 0) {
            ?>

            <table width="70%" border="1" align="center">
                <tr class="Estilo1" align="center">
                    <td colspan="3">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA<br/>
                        ALMACEN DE BIENES EN EXISTENCIA<br/>
                        CONSOLIDADO POR CUENTAS CONTABLES<br/>
                        AL <?php echo date("d/m/Y", strtotime($Fecha)); ?><br/>
                        (VALORES EN DOLARES DE LOS ESTADOS UNIDOS DE NORTE AMERICA)<br/>

                    </td>
                </tr>
                <tr class="Estilo1" align="center">
                    <td><strong>No DE CUENTA</strong></td>
                    <td><strong>CONCEPTO</strong></td>
                    <td><strong>TOTAL</strong></td>
                </tr>
                <?php
                $total = 0;
                for ($i = 1; $i <= count($ArrayCuenta); $i++) {
                    ?>
                    <tr class="Estilo2">
                        <td align="center"><?php echo $ArrayCuenta[$i][3]; ?></td>
                        <td><?php echo $ArrayCuenta[$i][2]; ?></td>
                        <td align="right">$<?php echo number_format($ArrayCuenta[$i][4], 2, '.', ''); ?></td>
                    </tr>
                    <?php
                    $total += $ArrayCuenta[$i][4];
                }
                ?>
                <tr class="Estilo1">
                    <td colspan="2"><div align="center"><strong>TOTAL GENERAL</strong></div></td>
                    <td align="right">$<?php echo number_format($total, 2, '.', ''); ?></td>
                </tr>
            </table>
            <br>


            <table width="70%" border="1" align="center">
                <tr class="Estilo1" align="center">
                    <td colspan="3">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA<br/>
                        ALMACEN DE BIENES EN EXISTENCIA<br/>
                        INFORME CUANTITATIVO<br/>
                        AL <?php echo date("d/m/Y", strtotime($Fecha)); ?><br/>


                    </td>
                </tr>
                <tr class="Estilo1" align="center">
                    <td><strong>No DE CUENTA</strong></td>
                    <td><strong>CONCEPTO</strong></td>
                    <td><strong>TOTAL</strong></td>
                </tr>
                <?php
                $total = 0;
                for ($i = 1; $i <= count($ArrayCuenta); $i++) {
                    ?>
                    <tr class="Estilo2">
                        <td align="center"><?php echo $ArrayCuenta[$i][3]; ?></td>
                        <td><?php echo $ArrayCuenta[$i][2]; ?></td>
                        <td align="center"><?php echo $ArrayCuenta[$i][5]; ?></td>
                    </tr>
                    <?php
                    $total += $ArrayCuenta[$i][5];
                }
                ?>
                <tr class="Estilo1">
                    <td colspan="2"><div align="center"><strong>TOTAL GENERAL</strong></div></td>
                    <td align="center"><?php echo $total; ?></td>
                </tr>


                <?php
            }
            ?>
    </body>
</html>
