<?php
require_once('../conexion/conexion.php');
$rs = mysqli_query($cn, "SELECT descargo.Id,descargo.Codigo,descargo.Fecha,ifnull(oficina.Descripcion,'DIFERENTES EQUIPOS') AS Oficina
FROM descargo left join oficina ON descargo.Oficina = oficina.Id where descargo.Codigo = " . $_POST["Descargo"]);
$row = mysqli_fetch_array($rs);

$rs2 = mysqli_query($cn, "SELECT kardex.Id,
       kardex.Cantidad,
       medida.Descripcion AS Medida,
       articulo.Descripcion AS Articulo,
       kardex.Precio,
       kardex.Total,
       CASE WHEN kardex.Vehiculo > 1
       THEN CONCAT( 'EQ-', vehiculo.Equipo) 
            ELSE ''
        END AS Equipo,
        CASE WHEN kardex.Vehiculo > 1
       THEN CONCAT( 'P-', vehiculo.Placa) 
            ELSE ''
        END AS Placa
FROM (((kardex kardex
        INNER JOIN articulo articulo
           ON (kardex.Articulo = articulo.Id))
       INNER JOIN medida medida
          ON (articulo.Medida = medida.Id))
      INNER JOIN descargo descargo
         ON (descargo.Id = kardex.Descargo))
     INNER JOIN vehiculo vehiculo
        ON (kardex.Vehiculo = vehiculo.Id)
        where descargo.Codigo  = " . $_POST["Descargo"]." order by kardex.Id");






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
                <td><div align="right" class="Estilo1"><strong>PARA:&nbsp;&nbsp;&nbsp; </strong></div></td>
                <td class="Estilo1"><?php echo $row["Oficina"]; ?></td>
            </tr>
        </table>
        <BR/>
        <table width="75%" border="1" align="center" class="Style1">
            <tr class="Style1">
                <td width="8%" class="Estilo1 Style1"><div align="center"><strong>CANTIDAD</strong></div></td>
                <td width="12%" class="Estilo1 Style1"><div align="center"><strong>UNIDAD MEDIDA </strong></div></td>
                <td width="58%" class="Estilo1 Style1"><div align="center"><strong>MATERIALES O REPUESTOS </strong></div></td>
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
                    <td class="Style1">&nbsp;<?php echo $row2["Articulo"].' '.$row2["Equipo"].' '.$row2["Placa"]; ?></td>
                    <td class="Style1" align="right"><?php echo $row2["Precio"]; ?>&nbsp;</td>
                    <td class="Style1">&nbsp;</td>
                    <td class="Style1" align="right"><?php echo $row2["Total"]; ?>&nbsp;</td>
                    <td class="Style1">&nbsp;</td>
                </tr>
                <?php
                $total += $row2["Total"];
            }
            ?>
            <tr class="Style1">
                <td colspan="4" class="Style1" ><div align="right" class="Estilo1">TOTAL</div></td>
                <td class="Style1" >&nbsp;</td>
                <td class="Style1" align="right"><?php echo number_format($total, 5, '.', ''); ?></td>
                <td class="Style1" >&nbsp;</td>
            </tr>
        </table>
<?php
// put your code here
?>
    </body>
</html>
