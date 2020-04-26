<?php
include('conexion/conexion.php');
$numFilas = 0;
if (isset($_GET['orden_compra']) && $_GET['orden_compra'] != '') {
    $orden = $_GET['orden_compra'];
    $rs = mysql_query("SELECT k.id_kar,a.id_art,a.nom_art,u.nom_med,k.cantidad,k.precio,total,numero_factura FROM kardex k
    INNER JOIN articulo a ON k.id_art = a.id_art
    LEFT JOIN departamento d ON k.id_dto = d.id_dto
    LEFT JOIN automovil auto ON auto.id_auto = k.id_auto
    LEFT JOIN uni_med u ON a.id_um = u.id_um
    where k.orden_compra = $orden and k.id_mov=1 order by id_kar desc");
    $numFilas = mysql_num_rows($rs);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="css/principal.css">
    </head>
    <body>
        <?php if ($numFilas > 0) { ?>
            <table border='0' align='center' >
                <tr class="row2" bgcolor=#e5eecc>
                    <td align="center"><strong>ARTICULO</strong></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td align="center"><strong>FACTURA</strong></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td align="center"><strong>UNI. MED</strong></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td align="center"><strong>CANTIDAD</strong></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td align="center"><strong>PRECIO</strong></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td align="center"><strong>TOTAL</strong></td>
                </tr>       

                <?php
                $cont = 0;
                $total = 0;
                while ($row = mysql_fetch_array($rs)) {
                    ?>

                    <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                        <td><?php echo $row[2]; ?></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td align="center"><?php echo $row[7]; ?></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?php echo $row[3]; ?></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td align='center'><?php echo number_format($row[4], 0); ?></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td align='right'>$<?php echo number_format($row[5], 5); ?></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td align='right'>$<?php echo number_format($row[6], 5); ?></td>
                    </tr>
                    <?php
                    $total = $total + $row[6];
                    $cont++;
                }
                ?>

                <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                    <td colspan='10' align="center"><strong>TOTAL</strong></td>
                    <td><strong>$<?php echo number_format($total, 5); ?></strong></td>
                </tr>
            </table>

            <?php
        }
        ?>

    </body>
</html>
