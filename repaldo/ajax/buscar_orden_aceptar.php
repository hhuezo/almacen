<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
    </head>
    <body>
        <?php
        require_once('../conexion/conexion.php');
        session_start();
        if (isset($_GET["txt_orden"])) {
            $rs = mysql_query("select date_format(fecha, '%d/%m/%Y') as fecha,para_uso,p.nom_prov from orden_compra o
            inner join proveedor p ON p.id_prov = o.id_prov
            where orden_compra =" . $_GET["txt_orden"] . "");
            $numFilas = mysql_num_rows($rs);
            if ($numFilas > 0) {
                $row = mysql_fetch_array($rs);
                ?>  
                <br>
                <table align="center">
                    <tr>
                        <td>Orden No<?php echo ' ' . $_GET["txt_orden"]; ?></td>
                        <td>&nbsp;&nbsp;&nbsp;Fecha<?php echo ' ' . $row["fecha"]; ?></td>
                        <td>&nbsp;&nbsp;&nbsp;Proveedor : <?php echo ' ' . $row["nom_prov"]; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;&nbsp;&nbsp;Para uso de : <?php echo ' ' . $row["para_uso"]; ?></td>
                    </tr>
                </table>
                <br>
                <?php
                $rs = mysql_query("select k.cantidad,a.nom_art,u.nom_med,k.precio,k.total from kardex k
              inner join articulo a on k.id_art = a.id_art
              inner join uni_med u ON u.id_um = a.id_um
              where k.id_mov = 1 and orden_compra =" . $_GET["txt_orden"] . "");
                $numFilas = mysql_num_rows($rs);
                if ($numFilas > 0) {
                    $cont = 1;
                    $total = 0;
                    ?>
                    <table width="700" border='2' align='center' >
                        <tr class="row1" bgcolor=#e5eecc>
                            <td width="10%" align="center"><strong>CANTIDAD</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td align="center"><strong>UNI.MED</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td align="center"><strong>ARTICULO</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td width="10%" align="center"><strong>PRECIO</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td width="12%" align="center"><strong>TOTAL</strong></td>
                        </tr>
                        <?php
                        while ($row = mysql_fetch_array($rs)) {
                            ?>
                            <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                                <td align="center"><?php echo number_format($row["cantidad"], 0); ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td align="center"><?php echo $row["nom_med"]; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td><?php echo $row["nom_art"]; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td align='right'>$<?php echo number_format($row["precio"], 5); ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td align='right'>$	<?php echo number_format($row["total"], 5); ?></td>
                            </tr>

                            <?php
                            $cont++;
                            $total = $total + $row["total"];
                        }
                        ?>

                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                            <td colspan='8' align="center">Total</td>
                            <td class="texto2" align='right'>$	<?php echo number_format($total, 5); ?></td>
                        </tr>
                    </table>


                    <?php if ($_SESSION['id_tipo'] == 1 || $_SESSION['id_tipo'] == 2 || $_SESSION['id_tipo'] == 3) { ?>
                    <center><a href="entrada_articulo.php?orden_compra_editar=<?php echo $_GET["txt_orden"]; ?>">Editar Orden</a></center>
                    <?php
                }
            } else {
                echo "<center>No hay registros para esta orden de compra</center>";
            }
        } else {
            echo "<center><img src='images/error.jpg'></center>";
        }
        
    }
    mysql_close();
    ?>
</body>
</html>
