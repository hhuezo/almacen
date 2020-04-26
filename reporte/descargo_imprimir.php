<?php
require_once('../conexion/conexion.php');
$rs = mysqli_query($cn, "SELECT descargo.Id,descargo.Codigo,descargo.Fecha,ifnull(oficina.Descripcion,'DIFERENTES EQUIPOS') AS Oficina
FROM descargo left join oficina ON descargo.Oficina = oficina.Id where descargo.Codigo = " . $_GET["Descargo"]);
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
        where descargo.Codigo  = " . $_GET["Descargo"] . " order by kardex.Id");

$i = 1;
while ($row2 = mysqli_fetch_array($rs2)) {
    $caracter = $row2["Articulo"] . ' ' . $row2["Equipo"] . ' ' . $row2["Placa"];
    $num_caracter = strlen($caracter);

    if ($num_caracter > 48) {

        $array_item[$i][1] = $row2["Cantidad"];
        $array_item[$i][2] = $row2["Medida"];
        $array_item[$i][3] = substr($caracter, 0, 45);
        $array_item[$i][4] = $row2["Precio"];
        $array_item[$i][5] = $row2["Total"];
        $array_item[$i][6] = "$";
        $i++;

        $array_item[$i][1] = "";
        $array_item[$i][2] = "";
        $array_item[$i][3] = substr($caracter, 46, 45);
        $array_item[$i][4] = "";
        $array_item[$i][5] = "";
        $array_item[$i][6] = "";

        $i++;
    } else {
        $array_item[$i][1] = $row2["Cantidad"];
        $array_item[$i][2] = $row2["Medida"];
        $array_item[$i][3] = $caracter;
        $array_item[$i][4] = $row2["Precio"];
        $array_item[$i][5] = $row2["Total"];
        $array_item[$i][6] = "$";
        $i++;
    }
}

if (count($array_item) < 20) {
    for ($i = count($array_item) + 1; $i <= 20; $i++) {
        $array_item[$i][1] = "";
        $array_item[$i][2] = "";
        $array_item[$i][3] = "";
        $array_item[$i][4] = "";
        $array_item[$i][5] = "";
        $array_item[$i][6] = "";
    }
}

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

            .Estilo2 {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: bold;
                font-size: 11px}
            .Estilo3 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
            .Estilo5 {font-size: 10; }
            -->

        </style>


    </head>
    <body>
        <table width="95%" height="91" border="0">
            <tr>
                <td height="87">&nbsp;</td>
            </tr>
        </table>
        <br/>
        <table width="100%" border="0" align="center">
            <tr>
                <td width="19%" class="Estilo2"><div align="right" class="Estilo1">&nbsp; </div></td>
                <td width="81%" class="Estilo2"><?php echo $fecha; ?></td>
            </tr>
            <tr>
                <td class="Estilo2"><div align="right" class="Estilo1"><strong>&nbsp;&nbsp; </strong></div></td>
                <td class="Estilo2"><?php echo $row["Oficina"]; ?></td>
            </tr>
        </table>
        <BR/>
        <table width="100%" border="0" align="center" class="Style1" >
            <tr class="Style1">
                <td width="9%" height="40" ><div align="center"></div></td>
                <td width="12%" ><div align="center"></div></td>
                <td width="50%" ><div align="center" class="Estilo1 Estilo2"></div></td>
                <td colspan="3" ><div align="center"></div></td>
                <td colspan="3" ><div align="center"></div></td>
            </tr>
<?php
$total = 0;

for ($i = 1; $i <= count($array_item); $i++) {
    ?>
                <tr>
                    <td class="Estilo2" align="center"><strong><?php echo $array_item[$i][1]; ?></strong></td>
                    <td class="Estilo2" align="center"><strong><?php echo $array_item[$i][2]; ?></strong></td>
                    <td class="Estilo2">&nbsp;<?php echo $array_item[$i][3]; ?></td>
                    <td width="3%" align="right" class="Estilo2"><?php echo $array_item[$i][6]; ?></td>
                    <td width="7%" align="right" class="Estilo2">&nbsp;<?php echo number_format($array_item[$i][4], 4, '.', ''); ?>&nbsp;</td>
                    <td width="5%" class="Estilo2">&nbsp;</td>
                    <td width="2%" align="right" class="Estilo2"><?php echo $array_item[$i][6]; ?></td>
                    <td width="7%" align="right" class="Estilo2">&nbsp;<?php echo number_format($array_item[$i][5], 2, '.', ''); ?>&nbsp;</td>
                    <td width="5%" >&nbsp;</td>
                </tr>

    <?php
    $total += $array_item[$i][5];
}
?>
            <tr>
                <td colspan="5" class="Estilo2" ><div align="right" class="Estilo1"></div></td>
                <td class="Estilo2" >&nbsp;</td>
                <td align="right" class="Estilo3">$</td>
                <td align="right" class="Estilo3">&nbsp;<?php echo number_format($total, 2, '.', ''); ?></td>
                <td  >&nbsp;</td>
            </tr>
        </table>
<?php
// put your code here
?>
        <table width="95%" height="130" border="0">
            <tr>
                <td height="126">&nbsp;</td>
            </tr>
        </table>
        <table width="95%" border="0" align="center">
            <tr>
                <td width="33%">&nbsp;</td>
                <td width="33%">&nbsp;</td>
                <td width="33%">&nbsp;</td>
            </tr>
            <tr>
                <td height="56" class="Estilo2"><div align="center" class="Estilo5">SANTOS ANTONIO HERRERA</div></td>
                <td class="Estilo2"><div align="center" class="Estilo5">LIC. JAIME MAURICIO FIGUEROA TORRES</div></td>
                <td class="Estilo2"><div align="center" class="Estilo5"><?php echo $_GET["Recibe"]; ?></div></td>
            </tr>
            <tr>
                <td class="Estilo2"><div align="center" class="Estilo5">GUARDALMACEN</div></td>
                <td class="Estilo2"><div align="center" class="Estilo5">GERENTE DE OPERACIONES Y LOGISTICA</div></td>
                <td class="Estilo2"><div align="center" class="Estilo5"><?php echo $_GET["Cargo"]; ?></div></td>
            </tr>
        </table>
        <p>&nbsp;</p>
    </body>
</html>
<script type="text/javascript">
    window.onload = function () {
        window.print();
        //window.close();
    }
</script>