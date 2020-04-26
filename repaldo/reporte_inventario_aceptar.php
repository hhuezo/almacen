<?php
require_once('conexion/conexion.php');
$fecha = $_GET[fecha];
$date = date_create($_GET[fecha]);


$mes = substr($fecha, 5, 2);
$anio = substr($fecha, 0, 4);
$dia = substr($fecha, 8, 2);

if ($mes == '01')
    $mes = 'ENERO';
else if ($mes_inicio == 2)
    $mes = 'FEBRERO';
else if ($mes == '03')
    $mes = 'MARZO';
else if ($mes == '04')
    $mes = 'ABRIL';
else if ($mes == '05')
    $mes = 'MAYO';
else if ($mes == '06')
    $mes = 'JUNIO';
else if ($mes == '07')
    $mes = 'JULIO';
else if ($mes == '08')
    $mes = 'AGOSTO';
else if ($mes == '09')
    $mes = 'SEPTIEMBRE';
else if ($mes == '10')
    $mes = 'OCTUBRE';
else if ($mes == '11')
    $mes = 'NOVIEMBRE';
else if ($mes == '12')
    $mes = 'DICIEMBRE';





if ($_GET[exportar] == 1) {
    header("Content-Type: application/vnd.ms-excel");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("content-disposition: attachment;filename=Inventario.xls");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inventario</title>
        <style>
            body {
                font: 150% sans-serif;
            }
        </style>
    </head>
    <body>
        <?php
        if (isset($_GET["cuenta"]) && $_GET["cuenta"] > 0 && $_GET["cuenta"] < 100) {
            $rs = mysql_query("select * from cuenta_contable where id_cuenta = " . $_GET["cuenta"]);
            $row = mysql_fetch_array($rs);
            $id_cuenta = $row[0];
            $nombre_cuenta = $row[2];
            $total_general = 0;

            $rs = mysql_query("select a.id_art,u.nom_med,a.nom_art,c.nom_cuenta from articulo a 
            inner join cuenta_contable c ON a.id_cuenta = c.id_cuenta
            inner join uni_med u ON a.id_um = u.id_um
            where numero_bodega = 1 and estado = 'activo' and a.id_cuenta = " . $_GET["cuenta"]);
            ?>

            <table width="75%" border="1" align="center">
                <tr>
                    <td colspan="5"><p align="center" class="texto">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA<br>
                            INVENTARIO DE EXISTENCIAS DE BIENES DE CONSUMO<br>
                            ALMACEN DE BIENES EN EXISTENCIA<br>
                            INVENTARIO DE <?php echo $nombre_cuenta; ?><br>
                            AL <?php echo date_format($date, 'd/m/Y');
            ?>

                        </p></td>
                </tr>
                <tr>
                    <td width="9%"><p align="center" class="texto">UNIDAD DE <br>MEDIDA</p></td>
                    <td width="59%"><p align="center" class="texto">DESCRIPCIÓN</p></td>
                    <td width="6%"><p align="center" class="texto">CANT.</p></td>
                    <td width="10%"><p align="center" class="texto">PRECIO<br>UNITARIO</p></td>

                    <td width="7%"><p align="center" class="texto">TOTAL</p></td>
                </tr>

                <?php
                while ($row = mysql_fetch_array($rs)) {
                    $rs_detalle = mysql_query("select k.orden_compra,k.numero_factura,k.precio,(select ifnull(sum(cantidad),0) 
			from kardex kar where kar.id_art=k.id_art and id_mov = 1
			and kar.orden_compra = k.orden_compra and kar.precio = k.precio and kar.fecha <= '$fecha')
                        -(select ifnull(sum(cantidad),0) from kardex kar where kar.id_art=k.id_art and id_mov = 2
			and kar.orden_compra = k.orden_compra and kar.precio = k.precio and kar.fecha <= '$fecha') as cantidad
			from kardex k where id_mov = 1 and k.fecha <= '$fecha' and id_art = " . $row["id_art"] . ' group by k.orden_compra,k.precio');

                    while ($rowDetalle = mysql_fetch_array($rs_detalle)) {
                        if ($rowDetalle["cantidad"] > 0) {
                            ?>
                            <tr>
                                <td><div align="center"><?php echo $row["nom_med"]; ?></div></td>
                                <td>&nbsp;<?php echo $row["nom_art"]; ?></td>
                                <td><div align="center"><?php echo $rowDetalle["cantidad"]; ?></div></td>
                                <td><div align="right">$<?php echo number_format($rowDetalle["precio"], 4); ?></div></td>
                                <td><div align="right">$<?php echo number_format($rowDetalle["precio"] * $rowDetalle["cantidad"], 4); ?></div></td>
                            </tr>				
                            <?php
                        }
                        $Total = $Total + ($rowDetalle["precio"] * $rowDetalle["cantidad"]);
                    }
                }
                ?>
                <tr>
                    <td></td><td><center><b>TOTAL</b></center></td><td></td><td></td><td><strong>$<?php echo number_format($Total, 4); ?></strong></td>
        </tr>
    </table>

    <?php
} else if ($_GET["cuenta"] == 100) {
    //consolidado
    echo '<table width="75%" border="1" align="center">';
    echo '<tr><td colspan="3" align="center">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA
    <br>ALACEN DE BIENES EN EXISTENCIA
    <br>CONSOLIDADO POR CUENTAS CONTABLES
    <br> AL ' . $dia . ' DE ' . $mes . ' DE ' . $anio . '
    <br>(VALORES EN DOLARES DE LOS ESTADOS UNIDOS DE NORTE AMERICA)
    </td></tr>';
    echo '<tr align="center"><td><strong>No DE CUENTA</strong></td><td><strong>CONCEPTO</strong></td><td><strong>TOTAL</strong></td></tr>';

    $total = 0;
    $rs = mysql_query("select c.NumeroCuenta,c.nom_cuenta,(select ifnull(sum(k.cantidad * k.precio),0) from kardex k inner join articulo a on k.id_art = a.id_art  where k.id_mov = 1 and a.numero_bodega = 1 and  k.fecha < '$fecha' and a.id_cuenta = c.id_cuenta) -
        (select ifnull(sum(k.cantidad * k.precio),0) from kardex k inner join articulo a on k.id_art = a.id_art where k.id_mov = 2 and a.numero_bodega = 1 and k.fecha < '$fecha' and a.id_cuenta = c.id_cuenta) as total
        from cuenta_contable c   where c.cod_cuenta > 1 order by c.NumeroCuenta ");
    while ($row = mysql_fetch_array($rs)) {
        if ($row[2] > 0) {
            echo '<tr><td align="center">' . $row[0] . '</td><td>' . $row[1] . '</td><td align="right">$' . number_format($row[2], 2) . '</td></tr>';
            $total = $total + $row[2];
        }
    }
    echo '<tr><td colspan="2" align="center"><strong>TOTAL GENERAL</strong></td><td align="right"><strong>$' . number_format($total, 2) . '</strong></td></tr>';
    echo '</table>';

    echo '<table> 
            <tr><td>&nbsp;</td></tr>
        </table>';





    echo '<table width="75%" border="1" align="center">';
    echo '<tr><td colspan="3" align="center">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA
    <br>ALACEN DE BIENES EN EXISTENCIA
    <br>INFORME CUANTITATIVO
    <br> AL ' . $dia . ' DE ' . $mes . ' DE ' . $anio . '
    </td></tr>';
    echo '<tr align="center"><td><strong>No DE CUENTA</strong></td><td><strong>CONCEPTO</strong></td><td><strong>TOTAL</strong></td></tr>';

    $total = 0;
    $total_general = 0;
    $correlativo = 1;
    $rs_cuenta = mysql_query("select * from cuenta_contable where cod_cuenta > 1 ");
    while ($row_cuenta = mysql_fetch_array($rs_cuenta)) {
        $rs = mysql_query("select a.id_art,(select ifnull(sum(cantidad),0) from kardex k where k.id_art = a.id_art and k.id_mov = 1 and k.fecha< '$fecha')-
        (select ifnull(sum(cantidad),0) from kardex k where k.id_art = a.id_art and k.id_mov = 2 and k.fecha< '$fecha') as conteo
        from articulo a  where a.id_cuenta =" . $row_cuenta[0]);

        while ($row = mysql_fetch_array($rs)) {
            if ($row[1] > 0) {
                $total++;
            }
        }
        echo '<tr><td  align="center">' . $correlativo . '</td><td>' . $row_cuenta[2] . '</td><td align="right"><strong>' . $total . '</strong></td></tr>';

        $total_general = $total_general + $total;
        $total = 0;
        $correlativo++;
    }

    echo '<tr><td colspan="2" align="center"><strong>TOTAL GENERAL</strong></td><td align="right"><strong>' . $total_general . '</strong></td></tr>';
    echo '</table>';
} else {
//para todas las cuentas contables    
    $rs_cuenta = mysql_query("select * from cuenta_contable where cod_cuenta >1 ");
    while ($row_cuenta = mysql_fetch_array($rs_cuenta)) {
        $id_cuenta = $row_cuenta[0];
        $nombre_cuenta = $row_cuenta[2];


        $rs = mysql_query("select a.id_art,u.nom_med,a.nom_art,c.nom_cuenta from articulo a 
            inner join cuenta_contable c ON a.id_cuenta = c.id_cuenta
            inner join uni_med u ON a.id_um = u.id_um
            where numero_bodega = 1 and estado = 'activo' and a.id_cuenta = " . $row_cuenta[0]);
        ?>


        <table width="75%" border="1" align="center">
            <tr>
                <td colspan="5"><p align="center" class="texto">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA<br>
                        INVENTARIO DE EXISTENCIAS DE BIENES DE CONSUMO<br>
                        ALMACEN DE BIENES EN EXISTENCIA<br>
                        INVENTARIO DE <?php echo $nombre_cuenta; ?><br>
                        AL <?php
        echo date_format($date, 'd/m/Y');
        $Total = 0;
        ?>

                    </p></td>
            </tr>
            <tr>
                <td width="9%"><p align="center" class="texto">UNIDAD DE <br>MEDIDA</p></td>
                <td width="59%"><p align="center" class="texto">DESCRIPCIÓN</p></td>
                <td width="6%"><p align="center" class="texto">CANT.</p></td>
                <td width="10%"><p align="center" class="texto">PRECIO<br>UNITARIO</p></td>

                <td width="7%"><p align="center" class="texto">TOTAL</p></td>
            </tr>
        <?php
        while ($row = mysql_fetch_array($rs)) {
            $rs_detalle = mysql_query("select k.orden_compra,k.numero_factura,k.precio,(select ifnull(sum(cantidad),0) 
			from kardex kar where kar.id_art=k.id_art and id_mov = 1
			and kar.orden_compra = k.orden_compra and kar.precio = k.precio and kar.fecha <= '$fecha')
                        -(select ifnull(sum(cantidad),0) from kardex kar where kar.id_art=k.id_art and id_mov = 2
			and kar.orden_compra = k.orden_compra and kar.precio = k.precio and kar.fecha <= '$fecha') as cantidad
			from kardex k where id_mov = 1 and k.fecha <= '$fecha' and id_art = " . $row["id_art"] . ' group by k.orden_compra,k.precio');

            while ($rowDetalle = mysql_fetch_array($rs_detalle)) {
                if ($rowDetalle["cantidad"] > 0) {
                    ?>
                        <tr>
                            <td><div align="center"><?php echo $row["nom_med"]; ?></div></td>
                            <td>&nbsp;<?php echo $row["nom_art"]; ?></td>
                            <td><div align="center"><?php echo $rowDetalle["cantidad"]; ?></div></td>
                            <td><div align="right">$<?php echo number_format($rowDetalle["precio"], 4); ?></div></td>
                            <td><div align="right">$<?php echo number_format($rowDetalle["precio"] * $rowDetalle["cantidad"], 4); ?> </div></td>
                        </tr>				
                    <?php
                }
                $Total = $Total + ($rowDetalle["precio"] * $rowDetalle["cantidad"]);
            }
        }
        ?>


            <tr>
                <td></td><td><center><b>TOTAL</b></center></td><td></td><td></td><td><strong>$<?php echo number_format($Total, 4); ?></strong></td>
        </tr>
        </table>
        <table> 
            <tr><td>&nbsp;</td></tr>
        </table>
        <?php
    }

    echo '<table width="75%" border="1" align="center">';
    echo '<tr><td colspan="3" align="center">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA
    <br>ALACEN DE BIENES EN EXISTENCIA
    <br>CONSOLIDADO POR CUENTAS CONTABLES
    <br> AL ' . $dia . ' DE ' . $mes . ' DE ' . $anio . '
    <br>(VALORES EN DOLARES DE LOS ESTADOS UNIDOS DE NORTE AMERICA)
    </td></tr>';
    echo '<tr align="center"><td><strong>No DE CUENTA</strong></td><td><strong>CONCEPTO</strong></td><td><strong>TOTAL</strong></td></tr>';

    $total = 0;
    $rs = mysql_query("select c.NumeroCuenta,c.nom_cuenta,(select ifnull(sum(k.cantidad * k.precio),0) from kardex k inner join articulo a on k.id_art = a.id_art  where k.id_mov = 1 and a.numero_bodega = 1 and  k.fecha < '$fecha' and a.id_cuenta = c.id_cuenta) -
        (select ifnull(sum(k.cantidad * k.precio),0) from kardex k inner join articulo a on k.id_art = a.id_art where k.id_mov = 2 and a.numero_bodega = 1 and k.fecha < '$fecha' and a.id_cuenta = c.id_cuenta) as total
        from cuenta_contable c   where c.cod_cuenta > 1 order by c.NumeroCuenta ");
    while ($row = mysql_fetch_array($rs)) {
        if ($row[2] > 0) {
            echo '<tr><td align="center">' . $row[0] . '</td><td>' . $row[1] . '</td><td align="right">$' . number_format($row[2], 2) . '</td></tr>';
            $total = $total + $row[2];
        }
    }
    echo '<tr><td colspan="2" align="center"><strong>TOTAL GENERAL</strong></td><td align="right"><strong>$' . number_format($total, 2) . '</strong></td></tr>';
    echo '</table>';

    echo '<table> 
            <tr><td>&nbsp;</td></tr>
        </table>';





    echo '<table width="75%" border="1" align="center">';
    echo '<tr><td colspan="3" align="center">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA
    <br>ALACEN DE BIENES EN EXISTENCIA
    <br>INFORME CUANTITATIVO
    <br> AL ' . $dia . ' DE ' . $mes . ' DE ' . $anio . '
    </td></tr>';
    echo '<tr align="center"><td><strong>No DE CUENTA</strong></td><td><strong>CONCEPTO</strong></td><td><strong>TOTAL</strong></td></tr>';

    $total = 0;
    $total_general = 0;
    $correlativo = 1;
    $rs_cuenta = mysql_query("select * from cuenta_contable where cod_cuenta > 1 ");
    while ($row_cuenta = mysql_fetch_array($rs_cuenta)) {
        $rs = mysql_query("select a.id_art,(select ifnull(sum(cantidad),0) from kardex k where k.id_art = a.id_art and k.id_mov = 1 and k.fecha< '$fecha')-
        (select ifnull(sum(cantidad),0) from kardex k where k.id_art = a.id_art and k.id_mov = 2 and k.fecha< '$fecha') as conteo
        from articulo a  where a.id_cuenta =" . $row_cuenta[0]);

        while ($row = mysql_fetch_array($rs)) {
            if ($row[1] > 0) {
                $total++;
            }
        }
        echo '<tr><td  align="center">' . $correlativo . '</td><td>' . $row_cuenta[2] . '</td><td align="right"><strong>' . $total . '</strong></td></tr>';

        $total_general = $total_general + $total;
        $total = 0;
        $correlativo++;
    }

    echo '<tr><td colspan="2" align="center"><strong>TOTAL GENERAL</strong></td><td align="right"><strong>' . $total_general . '</strong></td></tr>';
    echo '</table>';
}

mysql_close();
?>   
</body>
</html>
