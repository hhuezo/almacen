<?php
if (isset($_GET["Opcion"]) && $_GET["Opcion"] == 1) {
    header("Content-Type: application/vnd.ms-excel");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("content-disposition: attachment;filename=Liquidacion.xls");
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
        $FechaInicio = $_GET["FechaInicio"];
        $FechaFinal = $_GET["FechaFinal"];
        $Opcion = $_GET["Opcion"];

		
		$ArrayAgrupacion[1][1] = 1;
        $ArrayAgrupacion[1][2] = "03";
			
		$ArrayAgrupacion[2][1] = 2;
        $ArrayAgrupacion[2][2] = "05";	

        function obtenerFechaEnLetra($fecha) {
            // $dia = conocerDiaSemanaFecha($fecha);
            $num = date("j", strtotime($fecha));
            $anno = date("Y", strtotime($fecha));
            $mes = array('ENERO', 'FEBRERO', 'MERZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
            $mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
            return $num . ' DE ' . $mes . ' DEL ' . $anno;
        }

        $fecha_inicio = obtenerFechaEnLetra($FechaInicio);
        $fecha_final = obtenerFechaEnLetra($FechaFinal);











        for ($i = 1; $i <= count($ArrayAgrupacion); $i++) {

            unset($ArrayCuenta);
            $rs_cuenta = mysqli_query($cn, "SELECT cuenta.Id,cuenta.Descripcion,
            (select ifnull(sum(Total),0) 
            from kardex k inner join articulo a ON a.Id = k.Articulo 
            inner join orden o ON o.Id = k.Orden
            where a.Cuenta = cuenta.Id and o.Agrupacion = " . $ArrayAgrupacion[$i][1] . " and k.Movimiento = 2 and k.Fecha between '$FechaInicio' and '$FechaFinal' ) as Conteo  
            from cuenta where Id = 16    ");		
		

            $k = 1;
            $total = 0;
            while ($row_cuenta = mysqli_fetch_array($rs_cuenta)) {
                if ($row_cuenta["Conteo"] > 0) {
                    $ArrayCuenta[$k][1] = $row_cuenta["Id"];
                    $ArrayCuenta[$k][2] = $row_cuenta["Descripcion"];
                    $ArrayCuenta[$k][3] = $row_cuenta["Conteo"];
                    $k++;
                    $total += $row_cuenta["Conteo"];
                }
            }
            ?>




            <table width="90%" border="1" align="center">
                <tr>
                    <td colspan="6"><div align="center"><span class="Estilo1">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA <br/>
                                LIQUIDACION DE EXISTENCIAS DE BIENES DE CONSUMO <br/>
                                PERIODO DE LIQUIDACION: DEL <?php echo $fecha_inicio; ?> AL <?php echo $fecha_final; ?> <br/>
                                ALMACEN DE BIENES EN EXISTENCIA <br/>
                                AGRUPACION OPERACIONAL(<?php echo $ArrayAgrupacion[$i][2]; ?>)

                            </span></div></td>
                </tr>
                <tr>
                    <td width="10%" class="Estilo1"><div align="center">UNIDAD DE <br>
                            MEDIDA</div></td>
                    <td width="60%" class="Estilo1"><div align="center">DESCRIPCIÓN</div></td>
                    <td width="8%" class="Estilo1"><div align="center">CANT.</div></td>
                    <td width="8%" class="Estilo1"><div align="center">PRECIO<br>
                            UNITARIO</div></td>
                    <td width="10%" class="Estilo1"><div align="center">TOTAL<br>
                            PARCIAL</div></td>
                    <td width="6%" class="Estilo1"><div align="center">TOTAL</div></td>
                </tr>

                <?php
                for ($j = 1; $j <= count($ArrayCuenta); $j++) {
                    ?>
                    <tr class="Estilo1">
                        <td>&nbsp;</td>
                        <td align="center"><?php echo $ArrayCuenta[$j][2]; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right"><?php echo $ArrayCuenta[$j][3]; ?></td>
                    </tr>

                    <?php
                    $rs = mysqli_query($cn, "select m.Descripcion as Medida ,a.Descripcion as Articulo ,ifnull(SUM(Cantidad),0) as Cantidad, k.Precio from kardex k 
                    inner join articulo a ON a.Id = k.Articulo
                    inner join medida m ON m.Id = a.Medida
                    inner join orden o ON o.Id = k.Orden
                    where a.Cuenta = " . $ArrayCuenta[$j][1] . " and k.Movimiento = 2 and o.Agrupacion = " . $ArrayAgrupacion[$i][1] . " "
                            . " and k.Fecha between '$FechaInicio' and '$FechaFinal' 
                    group by a.Id,k.Precio order by a.Descripcion");

                    while ($row = mysqli_fetch_array($rs)) {
                        ?>

                        <tr class="Estilo2" align="center">
                            <td><?php echo $row["Medida"]; ?></td>
                            <td align="left"><?php echo $row["Articulo"]; ?></td>
                            <td><?php echo $row["Cantidad"]; ?></td>
                            <td align="right"><?php echo $row["Precio"]; ?></td>
                            <td align="right"><?php echo $row["Cantidad"] * $row["Precio"]; ?></td>
                            <td align="right"></td>
                        </tr>


                        <?php
                    }
                }
                ?>


                <tr>
                    <td><div align="center"></div></td>
                    <td><div align="center"><span class="Estilo1">TOTAL</span></div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" class="Estilo1" ><?php echo $total; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><div align="center" class="Estilo2">AUTORIZADO POR:__________________________________________ </div></td>
                    <td colspan="4"><div align="center" class="Estilo2">______________________________<br>
                            SR. SANTOS ANTONIO HERRERA <br>
                            GUARDALMACEN</div></td>
                </tr>
            </table>
            <br/><br/>







            <?php
        }

        mysqli_close($cn);
        ?>

            
    </body>
</html>
