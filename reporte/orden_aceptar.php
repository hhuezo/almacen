<?php
require_once('../conexion/conexion.php');
$rs = mysqli_query($cn, "SELECT orden.Id,
       orden.Codigo,
       orden.Fecha,
       proveedor.Descripcion as Proveedor,
       orden.Uso
FROM orden orden
     INNER JOIN proveedor proveedor
        ON (orden.Proveedor = proveedor.Id)where orden.Codigo = " . $_POST["Orden"]);

$row = mysqli_fetch_array($rs);

$rs2 = mysqli_query($cn, "SELECT kardex.Id,
       kardex.Cantidad,
       medida.Descripcion AS Medida,
       articulo.Descripcion AS Articulo,
       kardex.Precio,
       kardex.Total
FROM ((kardex kardex
       INNER JOIN articulo articulo
          ON (kardex.Articulo = articulo.Id))
      INNER JOIN medida medida
         ON (articulo.Medida = medida.Id))
     INNER JOIN orden orden
        ON (orden.Id = kardex.Orden)
        where kardex.Movimiento = 1 and orden.Codigo  = " . $_POST["Orden"] . " order by kardex.Id");

function obtenerFechaEnLetra($fecha) {
    // $dia = conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('ENERO', 'FEBRERO', 'MERZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
    $mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
    return $num . ' DE ' . $mes . ' DEL ' . $anno;
}

$fecha = 'SAN SALVADOR, ' . obtenerFechaEnLetra($row["Fecha"]);
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
            -->
        </style>



        <style type="text/css">
            <!--
            .Style1 {
                border: thin solid #333333;
            }
            -->

        </style>


    </head>
    <body>
        <br/>
        <table width="75%" border="0" align="center">
            <tr>
                <td width="31%"><div align="right" class="Estilo1">LUGAR Y FECHA:&nbsp;&nbsp;&nbsp; </div></td>
                <td width="69%" class="Estilo1"><?php echo $fecha; ?></td>
            </tr>
            <tr>
                <td><div align="right" class="Estilo1"><strong>PROVEEDOR:&nbsp;&nbsp;&nbsp; </strong></div></td>
                <td class="Estilo1"><?php echo $row["Proveedor"]; ?></td>
            </tr>
            <tr>
                <td><div align="right" class="Estilo1"><strong>PARA USO DE:&nbsp;&nbsp;&nbsp; </strong></div></td>
                <td class="Estilo1"><?php echo $row["Uso"]; ?></td>
            </tr>
        </table>
        <BR/>
        <table width="75%" border="1" align="center" class="Style1">
            <tr class="Style1">
                <td width="8%" class="Estilo1 Style1"><div align="center"><strong>CANTIDAD</strong></div></td>
                <td width="13%" class="Estilo1 Style1"><div align="center"><strong>UNIDAD MEDIDA </strong></div></td>
                <td width="56%" class="Estilo1 Style1"><div align="center"><strong>MATERIALES O REPUESTOS </strong></div></td>
                <td colspan="2" class="Estilo1 Style1"><div align="center"><strong>PRECIO UNITARIO </strong></div></td>
                <td colspan="2" class="Estilo1 Style1"><div align="center"><strong>VALOR TOTAL </strong></div></td>
            </tr>
            <?php
            $total = 0;
            while ($row2 = mysqli_fetch_array($rs2)) {
                ?>
                <tr class="Style1">
                    <td class="Style1" align="center"><?php echo $row2["Cantidad"]; ?></td>
                    <td class="Style1" align="center"><?php echo $row2["Medida"]; ?></td>
                    <td class="Style1">&nbsp;<?php echo $row2["Articulo"]; ?></td>
                    <td class="Style1" align="right">$<?php echo $row2["Precio"]; ?>&nbsp;</td>
                    <td class="Style1">&nbsp;</td>
                    <td class="Style1" align="right">$<?php echo $row2["Total"]; ?>&nbsp;</td>
                    <td class="Style1">&nbsp;</td>
                </tr>
                <?php
                $total += $row2["Total"];
            }
            ?>
            <tr class="Style1">
                <td colspan="4" class="Style1" ><div align="right" class="Estilo1">TOTAL</div></td>
                <td class="Style1" >&nbsp;</td>
                <td class="Style1" align="right">$<?php echo number_format($total, 5, '.', ''); ?></td>
                <td class="Style1" >&nbsp;</td>
            </tr>
        </table>
<?php
// put your code here
?>
    </body>
</html>
