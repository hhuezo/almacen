<?php
require_once('../conexion/conexion_usuario.php');

if (isset($_GET["Opcion"]) && $_GET["Opcion"] == 1) {
    header("Content-Type: application/vnd.ms-excel");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("content-disposition: attachment;filename=Inventario.xls");
}

$rs = mysqli_query($cn, "SELECT date_format(kardex.Fecha, '%d/%m/%Y') as Fecha,
       articulo.Descripcion AS Articulo,
       medida.Descripcion AS Medida,
       kardex.Cantidad,
       kardex.Precio,
       kardex.Total,
       descargo.Codigo as Descargo
FROM (articulo articulo
      INNER JOIN medida medida ON (articulo.Medida = medida.Id))
     INNER JOIN kardex kardex ON (kardex.Articulo = articulo.Id)
      INNER JOIN descargo descargo
          ON kardex.Descargo = descargo.Id
     where kardex.Vehiculo = " . $_GET["Vehiculo"] . " and kardex.Fecha between '" . $_GET["FechaInicio"] . "' and '" . $_GET["FechaFinal"] . "'");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
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
        <br/>
        <table width="90%" border="1" cellspacing="0" align="center">
            <tr class="row1" bgcolor=#e5eecc>
                <td width="10%"><div align="center"><span class="Estilo1">FECHA</span></div></td>
                <td width="9%"><div align="center"><span class="Estilo1">DESCARGO</span></div></td>
                <td width="47%"><div align="center"><span class="Estilo1">REPUESTO</span></div></td>
                <td width="8%"><div align="center"><span class="Estilo1">U/M</span></div></td>
                <td width="6%"><div align="center"><span class="Estilo1">CANTIDAD</span></div></td>
                <td width="9%"><div align="center"><span class="Estilo1">PRECIO</span></div></td>
                <td width="11%"><div align="center"><span class="Estilo1">TOTAL</span></div></td>
            </tr>
            <?php
            $cont = 1;
            $total = 0;
            while ($row = mysqli_fetch_array($rs)) {
                ?>
                <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                    <td><div align="center"><span class="Estilo2"><?php echo $row["Fecha"]; ?></span></div></td>
                    <td><div align="center"><span class="Estilo2"><?php echo $row["Descargo"]; ?></span></div></td>
                    <td><span class="Estilo2"><?php echo $row["Articulo"]; ?></span></td>
                    <td><div align="center"><span class="Estilo2"><?php echo $row["Medida"]; ?></span></div></td>
                    <td><div align="center" class="Estilo2"><?php echo $row["Cantidad"]; ?></div></td>
                    <td><div align="right" class="Estilo2">$<?php echo number_format($row["Precio"], 2, '.', ''); ?></div></td>
                    <td><div align="right" class="Estilo2">$<?php echo number_format($row["Total"], 2, '.', ''); ?></div></td>
                </tr>

                <?php
                $cont++;
                $total += $row["Total"];
            }
            ?>
            <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                <td colspan="6"><div align="center" class="Estilo1">TOTAL</div></td>
                <td><div align="right" class="Estilo1">$<?php echo number_format($total, 2, '.', ''); ?></div></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>

    </body>
</html>
