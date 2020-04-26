<?php
if (isset($_POST["Oficina"])) {

    if (isset($_GET["Opcion"]) && $_GET["Opcion"] == 1) {
        header("Content-Type: application/vnd.ms-excel");

        header("Expires: 0");

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

        header("content-disposition: attachment;filename=Inventario.xls");
    }

    require_once('../conexion/conexion_usuario.php');

    $Oficina = $_POST["Oficina"];
    $FechaInicio = $_POST["FechaInicio"];
    $FechaFinal = $_POST["FechaFinal"];

    $rs = mysqli_query($cn, "SELECT kardex.Id,
       DATE_FORMAT(kardex.Fecha, '%d/%m/%Y') as Fecha,
       descargo.Codigo as Descargo,
       articulo.Descripcion as Articulo,
       medida.Descripcion as Medida,
       cuenta.Descripcion as Cuenta,
       kardex.Cantidad,
       kardex.Precio,
       kardex.Total
  FROM kardex kardex
    INNER JOIN  articulo articulo ON kardex.Articulo = articulo.Id
          INNER JOIN medida medida ON articulo.Medida = medida.Id          
        INNER JOIN descargo descargo
           ON descargo.Id = kardex.Descargo
       INNER JOIN cuenta cuenta ON articulo.Cuenta = cuenta.Id
       where descargo.Oficina = $Oficina and kardex.Fecha between '$FechaInicio' and '$FechaFinal' order by Id
");
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
            <link rel="stylesheet" type="text/css" href="../css/estilos.css">
            <style type="text/css">
                <!--
                .Estilo2 {font-size: 14; font-weight: bold; }
                -->
            </style>
        </head>
        <body>
            <br/>
            <table width="90%" border="1"  align="center">
                <tr class="row1" bgcolor=#e5eecc>
                    <td><div align="center" class="Estilo2">Fecha</div></td>
                    <td><div align="center" class="Estilo2">Descargo</div></td>
                    <td><div align="center" class="Estilo2">Cuenta</div></td>
                    <td><div align="center" class="Estilo2">Articulo</div></td>
                    <td><div align="center" class="Estilo2">Medida</div></td>
                    <td><div align="center" class="Estilo2">Cantidad</div></td>
                    <td><div align="center" class="Estilo2">Precio</div></td>
                    <td><div align="center" class="Estilo2">Total</div></td>
                </tr>
                <?php
                $cont = 1;
                $total = 0;
                while ($row = mysqli_fetch_array($rs)) {
                    ?>
                    <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                        <td><div align="center"><?php echo $row["Fecha"] ?></div></td>
                        <td><div align="center"><?php echo $row["Descargo"] ?></div></td>
                        <td><div align="center"><?php echo $row["Cuenta"] ?></div></td>
                        <td><?php echo $row["Articulo"] ?></td>
                        <td><div align="center"><?php echo $row["Medida"] ?></div></td>
                        <td><div align="center"><?php echo $row["Cantidad"] ?></div></td>
                        <td><div align="right">$<?php echo $row["Precio"] ?></div></td>
                        <td><div align="right">$<?php echo $row["Total"] ?></div></td>
                    </tr>

                    <?php
                    $cont++;
                    $total += $row["Total"];
                }
                ?>
                <tr>
                    <td height="23" colspan="7" class="Estilo2"><div align="center">TOTAL</div></td>
                    <td><div align="right">$<?php echo $total ?></div></td>
                </tr>
            </table>

        </body>
    </html>
    <?php
    mysqli_close($cn);
}
?>