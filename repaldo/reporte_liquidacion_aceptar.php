<?php
include('conexion/Conexion.php');

if (isset($_GET["opcion"]) && $_GET["opcion"] == 2) {
    header("Content-Type: application/vnd.ms-excel");

    header("Expires: 0");

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    header("content-disposition: attachment;filename=Liquidacion.xls");
}

$gerente = ""; $guardalmecen = "";
$rs = mysql_query("SELECT * from nombres where activo = 1 order by cargo");
while ($row = mysql_fetch_array($rs)) {
    if($row[5] == 'GERENTE')
    {
        $gerente = $row[1];
    }
    if($row[5] == 'GUARDALMECEN')
    {
        $guardalmecen = $row[1];
    }
}


$var_id_agru = $_GET['agru'];
$var_fecha_ini = $_GET['fecha_ini'];
$var_fecha_fin = $_GET['fecha_fin'];

$mes_inicio = substr($var_fecha_ini, 5, 2);
$anio_inicio = substr($var_fecha_ini, 0, 4);
$dia_inicio = substr($var_fecha_ini, 8, 2);

$mes_fin = substr($_GET['fecha_fin'], 5, 2);
$anio_fin = substr($_GET['fecha_fin'], 0, 4);
$dia_fin = substr($_GET['fecha_fin'], 8, 2);

if ($var_id_agru == 1)
    $agrupacion = '03';
else if ($var_id_agru == 2)
    $agrupacion = '05';


if ($mes_inicio == '01')
    $mes_inicio = 'ENERO';
else if ($mes_inicio == 2)
    $mes_inicio = 'FEBRERO';
else if ($mes_inicio == '03')
    $mes_inicio = 'MARZO';
else if ($mes_inicio == '04')
    $mes_inicio = 'ABRIL';
else if ($mes_inicio == '05')
    $mes_inicio = 'MAYO';
else if ($mes_inicio == '06')
    $mes_inicio = 'JUNIO';
else if ($mes_inicio == '07')
    $mes_inicio = 'JULIO';
else if ($mes_inicio == '08')
    $mes_inicio = 'AGOSTO';
else if ($mes_inicio == '09')
    $mes_inicio = 'SEPTIEMBRE';
else if ($mes_inicio == '10')
    $mes_inicio = 'OCTUBRE';
else if ($mes_inicio == '11')
    $mes_inicio = 'NOVIEMBRE';
else if ($mes_inicio == '12')
    $mes_inicio = 'DICIEMBRE';



if ($mes_fin == '01')
    $mes_fin = 'ENERO';
else if ($mes_fin == '02')
    $mes_fin = 'FEBRERO';
else if ($mes_fin == '03')
    $mes_fin = 'MARZO';
else if ($mes_fin == '04')
    $mes_fin = 'ABRIL';
else if ($mes_fin == '05')
    $mes_fin = 'MAYO';
else if ($mes_fin == '06')
    $mes_fin = 'JUNIO';
else if ($mes_fin == '07')
    $mes_fin = 'JULIO';
else if ($mes_fin == '08')
    $mes_fin = 'AGOSTO';
else if ($mes_fin == '09')
    $mes_fin = 'SEPTIEMBRE';
else if ($mes_fin == '10')
    $mes_fin = 'OCTUBRE';
else if ($mes_fin == '11')
    $mes_fin = 'NOVIEMBRE';
else if ($mes_fin == '12')
    $mes_fin = 'DICIEMBRE';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liquidacion</title>
        <style>
            body {
                font: 150% sans-serif;
            }
        </style>
    </head>
    <body>

        <?php if ($var_id_agru > 0) { ?>

            <table width="80%" border="1" align="center">
                <tr>
                    <td colspan="6"><p align="center" class="texto">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA<br>
                            LIQUIDACION DE EXISTENCIAS DE BIENES DE CONSUMO<br>

                            PERIODO DE LIQUIDACION: DEL <?php echo $dia_inicio . '  ' . 'DE  ' . $mes_inicio . ' DE ' . $anio_inicio; ?> AL 
                            <?php echo $dia_fin . '  ' . 'DE  ' . $mes_fin . ' DE ' . $anio_fin; ?> <br>

                            ALMACEN DE BIENES EN EXISTENCIA<br>
                            AGRUPACION OPERACIONAL(<?php echo $agrupacion; ?>)
                        </p></td>
                </tr>
                <tr>
                    <td width="9%"><p align="center" class="texto">UNIDAD DE <br>MEDIDA</p></td>
                    <td width="52%"><p align="center" class="texto">DESCRIPCIÓN</p></td>
                    <td width="13%"><p align="center" class="texto">CANT.</p></td>
                    <td width="10%" ><p align="center" class="texto">PRECIO<br>UNITARIO</p></td>
                    <td width="9%"><p align="center" class="texto">TOTAL<br>PARCIAL</p></td>
                    <td width="7%"><p align="center" class="texto">TOTAL</p></td>
                </tr>

                <?php
                $rs = mysql_query("SELECT c.id_cuenta, c.nom_cuenta, SUM( k.cantidad * k.precio ) AS total_cuenta
                FROM kardex k
                JOIN articulo a ON k.id_art = a.id_art
                JOIN cuenta_contable c ON a.id_cuenta = c.id_cuenta
                WHERE k.id_mov =2
                AND k.id_agru = $var_id_agru and numero_bodega = 1 and (k.fecha between '$var_fecha_ini' and '$var_fecha_fin')
                GROUP BY c.id_cuenta, c.nom_cuenta
                ");
                $numFilas = mysql_num_rows($rs);


                if ($numFilas > 0) {
                    while ($row = mysql_fetch_array($rs)) {
                        ?>
                        <tr>
                            <td></td>
                            <td class="texto"><strong><center><em><?php echo $row['nom_cuenta'] ?></em></center></strong></td> 
                            <td ></td> <td></td> <td></td> <td class="texto"><?php echo round($row['total_cuenta'], 2) ?></td>
                        </tr>
                        <?php
                        $numero_cuenta = $row['id_cuenta'];
                        $total_general = $total_general + $row['total_cuenta'];


                        $rs_producto = mysql_query("SELECT c.id_cuenta,c.nom_cuenta,u.nom_med,a.nom_art,k.precio, sum(k.cantidad) as total_articulo from kardex k join articulo a on 
				k.id_art = a.id_art 
				join cuenta_contable c on a.id_cuenta = c.id_cuenta 
				 join uni_med u on a.id_um = u.id_um
				where k.id_mov =2 AND k.id_agru = $var_id_agru AND  c.id_cuenta=" . $numero_cuenta . " and (k.fecha between '$var_fecha_ini' and '$var_fecha_fin')
				and a.numero_bodega = 1 group by c.id_cuenta,c.nom_cuenta,a.nom_art,k.precio");
                        $numFilas = mysql_num_rows($rs_producto);

                        if ($numFilas > 0) {
                            while ($row_producto = mysql_fetch_array($rs_producto)) {
                                $parcial = number_format($row_producto[4] * $row_producto[5], 4, '.', '');
                                ?>
                                <tr>
                                    <td><p align="center" class="texto2"><?php echo $row_producto[2] ?></p></td><td class="texto2"><?php echo $row_producto[3] ?></td>
                                    <td><p align="center" class="texto2"><?php echo $row_producto[5] ?></p></td> <td class="texto2"><?php echo $row_producto[4] ?></td> 
                                    <td class="texto2"><?php echo $parcial ?></td> 
                                    <td></td>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td height="24"></td><td><p align="center" class="texto">TOTAL</td><td></td> <td></td> <td></td> <td class="texto"><?php echo "$total_general"; ?></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><br><br> AUTORIZADO POR:__________________________________________
                        <br> <?php echo $gerente; ?>
                    </td>
                    <td colspan="4" align="center"><br>______________________________<br><?php echo $guardalmecen; ?>
                        <br> GUARDALMACEN
                    </td>
                </tr>
            </table>

        </body>
    </html>
    <?php
} else {

    $rs_agrupacion = mysql_query("select id_agru,cod_agru from agrupacion_operacional");
    while ($row_agrupacion = mysql_fetch_array($rs_agrupacion)) {
        $var_id_agru = $row_agrupacion['id_agru'];
        $agrupacion = $row_agrupacion['cod_agru'];
        $total_general = 0;

        $rs_cuentas = mysql_query("SELECT c.id_cuenta, c.nom_cuenta, SUM( k.cantidad * k.precio) AS total_cuenta
		FROM kardex k
		JOIN articulo a ON k.id_art = a.id_art
		JOIN cuenta_contable c ON a.id_cuenta = c.id_cuenta
		WHERE k.id_mov =2
		AND k.id_agru = $var_id_agru and numero_bodega = 1 and (k.fecha between '$var_fecha_ini' and '$var_fecha_fin')
		GROUP BY c.id_cuenta, c.nom_cuenta");
        ?>

        <table width="80%" border="1" align="center">
            <tr>
                <td colspan="6"><p align="center" class="texto">INSTITUTO SALVADOREÑO DE TRANSFORMACION AGRARIA<br>
                        LIQUIDACION DE EXISTENCIAS DE BIENES DE CONSUMO<br>

                        PERIODO DE LIQUIDACION: DEL <?php echo $dia_inicio . '  ' . 'DE  ' . $mes_inicio . ' DE ' . $anio_inicio; ?> AL 
                        <?php echo $dia_fin . '  ' . 'DE  ' . $mes_fin . ' DE ' . $anio_fin; ?> <br>
                        ALMACEN DE BIENES EN EXISTENCIA<br>
                        AGRUPACION OPERACIONAL(<?php echo $agrupacion; ?>)
                    </p></td>
            </tr>
            <tr>
                <td width="9%"><p align="center" class="texto">UNIDAD DE <br>MEDIDA</p></td>
                <td width="52%"><p align="center" class="texto">DESCRIPCIÓN</p></td>
                <td width="13%"><p align="center" class="texto">CANT.</p></td>
                <td width="10%"><p align="center" class="texto">PRECIO<br>UNITARIO</p></td>
                <td width="9%"><p align="center" class="texto">TOTAL<br>PARCIAL</p></td>
                <td width="7%"><p align="center" class="texto">TOTAL</p></td>
            </tr>

            <?php
            while ($row_cuentas = mysql_fetch_array($rs_cuentas)) {
                ?>

                <tr>
                    <td></td><td class="texto"><center><strong><em><?php echo $row_cuentas['nom_cuenta'] ?></em></strong>
                </center></td> <td></td> <td></td> <td></td> <td class="texto"><?php echo round($row_cuentas['total_cuenta'], 2) ?></td>
            </tr>
            <?php
            $numero_cuenta = $row_cuentas['id_cuenta'];

            $total_general = $total_general + $row_cuentas['total_cuenta'];
            ?>
            <?php
            $rs_producto = mysql_query("SELECT c.id_cuenta,c.nom_cuenta,u.nom_med,a.nom_art,k.precio, sum(k.cantidad) as total_articulo from kardex k join articulo a on 
				k.id_art = a.id_art 
				join cuenta_contable c on a.id_cuenta = c.id_cuenta 
				 join uni_med u on a.id_um = u.id_um
				where k.id_mov =2 AND k.id_agru = $var_id_agru AND  c.id_cuenta=" . $numero_cuenta . " and (k.fecha between '$var_fecha_ini' and '$var_fecha_fin')
				and a.numero_bodega = 1 and k.descargo <> 36215 group by c.id_cuenta,c.nom_cuenta,a.nom_art,k.precio");



            while ($row_producto = mysql_fetch_array($rs_producto)) {
                //$parcial=round($filas2['precio'] * $filas2['total_articulo'],4);
                $parcial = number_format($row_producto['precio'] * $row_producto['total_articulo'], 4, '.', '');
                ?>
                <tr>
                    <td><p align="center" class="texto2"><?php echo $row_producto['nom_med'] ?></p></td><td class="texto2"><?php echo $row_producto['nom_art'] ?></td>
                    <td><p align="center" class="texto2"><?php echo $row_producto['total_articulo'] ?></p></td> <td class="texto2"><?php echo $row_producto['precio'] ?></td> 
                    <td class="texto2"><?php echo $parcial ?></td> 
                    <td></td>
                </tr>

                <?php
            }
        }
        ?>
        <tr>
            <td height="24"></td><td><p align="center" class="texto">TOTAL</td><td></td> <td></td> <td></td> <td class="texto"><?php echo "$total_general"; ?></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><br> AUTORIZADO POR:__________________________________________
                <br> <?php echo $gerente; ?>
            </td>
            <td colspan="4" align="center"><br>______________________________<br><?php echo $guardalmecen; ?>
                <br> GUARDALMACEN
            </td>
        </tr>
        </table>
        <table> 
            <tr><td>&nbsp;</td></tr>
        </table>


        <?php
    }
}
?>

<?php
mysql_close();
?>