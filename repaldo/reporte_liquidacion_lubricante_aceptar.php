
<?php
require_once('../conexion/conexion.php');

$fecha_ini = $_GET["fecha_ini"];
$fecha_fin = $_GET["fecha_fin"];

$anio_inicio = substr($_GET["fecha_ini"], 0, 4);
$mes_inicio = substr($_GET["fecha_ini"], 5, 2);
$dia_inicio = substr($_GET["fecha_ini"], 8, 2);

$anio_fin = substr($_GET["fecha_fin"], 0, 4);
$mes_fin = substr($_GET["fecha_fin"], 5, 2);
$dia_fin = substr($_GET["fecha_fin"], 8, 2);

if ($mes_inicio == '01')
    $mes_inicio = 'ENERO';
else if ($mes_inicio == '02')
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Liquidacion</title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
            <style type="text/css">
                <!--
                .Estilo1 {font-family: Arial, Helvetica, sans-serif}
                .Estilo2 {font-size: 12px}
                .Estilo4 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
                -->
            </style>
    </head>
    <body>
        <?php
        $rs = mysql_query("select k.id_agru,agru.cod_agru ,count(*) as CONTEO from kardex k inner join articulo a on k.id_art = a.id_art 
        inner join agrupacion_operacional agru on k.id_agru = agru.id_agru
        where a.numero_bodega =2 and k.id_mov=2 and k.fecha between '$fecha_ini' and '$fecha_fin' group by k.id_agru ");
        $row_count = mysql_num_rows($rs);

        while ($rs_head = mysql_fetch_array($rs)) {
            if ($rs_head["CONTEO"] > 0) {
                ?>

                <table width="1004" border="0" align="center">
                    <tr>
                        <td width="138" rowspan="3"><div align="center"><span class="Estilo1"></span></div></td>
                        <td width="604"><div align="center" class="Estilo1"><strong>INSTITUTO SALVADORE&Ntilde;O DE TRANSFORMACION AGRARIA</strong></div></td>
                        <td width="112" rowspan="3"><div align="center" class="Estilo1"><strong>No&nbsp;<?php echo $_GET["correlativo"]; ?> </strong></div></td>
                    </tr>
                    <tr>
                        <td><div align="center" class="Estilo1"><strong>RESUMEN DE COMBUSTIBLES Y LUBRICANTES </strong></div></td>
                    </tr>
                    <tr>
                        <td><div align="center" class="Estilo1"><strong>PERIODO DE LIQUIDACION: DEL <?php echo $dia_inicio; ?> DE <?php echo $mes_inicio; ?> DE <?php echo $anio_inicio; ?> AL <?php echo $dia_fin; ?> DE <?php echo $mes_fin; ?> DE <?php echo $anio_fin; ?></strong></div></td>
                    </tr>
                    <tr>
                        <td colspan="3"><div align="center" class="Estilo1"><strong>AGRUPACION OPERACIONAL(<?php echo $rs_head[1]; ?>)</strong></div></td>
                    </tr>
                </table>

                <?php
                $rs2 = mysql_query("select sum(k.cantidad) as suma_articulo,nom_med,a.nom_art,cu.nom_cuenta,k.numero_factura,k.precio,(sum(k.cantidad)*k.precio) 
                as total from kardex k inner join articulo a on k.id_art = a.id_art inner join uni_med u ON a.id_um = u.id_um 
                left join cuenta_contable cu ON a.id_cuenta = cu.id_cuenta
                where a.numero_bodega = 2 and k.id_mov=2 and fecha between '$fecha_ini' and '$fecha_fin' and k.id_agru = " . $rs_head['0'] . " group by a.nom_art,k.precio order by cu.nom_cuenta,a.nom_art");


                $numFilas = mysql_num_rows($rs2);
                if ($numFilas > 0) {
                    ?>
                    <table width="1004" border="1" align="center" cellspacing="0">
                        <tr>
                            <td width="40" rowspan="2"><div align="center" class="Estilo1"><strong>ITEM</strong></div></td>
                            <td width="80" rowspan="2"><div align="center" class="Estilo1"><strong>CANTIDAD</strong></div></td>
                            <td width="60" rowspan="2"><div align="center" class="Estilo1"><strong>UNIDAD</strong></div></td>
                            <td width="373" rowspan="2"><div align="center" class="Estilo1"><strong>CONCEPTO</strong></div></td>
                            <td width="227" rowspan="2"><div align="center" class="Estilo1"><strong>CUENTA</strong></div></td>
                            <td width="75" rowspan="2"><div align="center" class="Estilo1"><strong>FACTURA</strong></div></td>
                            <td colspan="2"><div align="center" class="Estilo1"><strong>PRECIOS</strong></div></td>
                        </tr>
                        <tr>
                            <td width="59"><div align="center" class="Estilo1"><strong>UNITARIO</strong></div></td>
                            <td width="56"><div align="center" class="Estilo1"><strong>TOTAL</strong></div></td>
                        </tr>

                        <?php
                        $total = 0;
                        $item = 1;
                        while ($row = mysql_fetch_array($rs2)) {
                            ?>	  
                            <tr>
                                <td><div align="center" class="Estilo1 Estilo2"><?php echo $item; ?></div></td>
                                <td><div align="center" class="Estilo4"><?php echo $row[0]; ?></div></td>
                                <td><div align="center" class="Estilo4"><?php echo $row[1]; ?></div></td>
                                <td><span class="Estilo4"><?php echo $row[2]; ?></span></td>
                                <td><span class="Estilo4"><?php echo $row[3]; ?></span></td>
                                <td><div align="center" class="Estilo4"><?php echo $row[4]; ?></div></td>
                                <td><div align="right" class="Estilo4">$<?php echo number_format($row[5], 2, '.', ''); ?></div></td>
                                <td><div align="right" class="Estilo4">$<?php echo number_format($row[6], 2, '.', ''); ?></div></td>
                            </tr>
                            <?php
                            $total = $total + $row[6];
                            $item++;
                        }
                        ?>
                        <tr>
                            <td colspan="7"><div align="right" class="Estilo1"><strong>TOTAL</strong></div></td>
                            <td><div align="right" class="Estilo1"><strong>$<?php echo number_format($total, 2, '.', ''); ?></strong></div></td>
                        </tr>
                    </table>  
                    <p></p><p></p>

                    <?php
                }
            }
        }

        mysql_close();
        if ($row_count > 0) {
            ?>
            <p></p><p></p>
            <table width="947" height="100" border="0" align="center"> 
                <tr>
                    <td colspan="2" class="Estilo1">OBSERVACION:<?php echo '     ' . $_GET["observacion"]; ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="Estilo1"></td>
                </tr>
                <tr>
                    <td class="Estilo1">&nbsp;</td>
                    <td class="Estilo1">&nbsp;</td>
                </tr>
                <tr>
                    <td width="471" class="Estilo1"><div align="center">_________________________________________________<br />AUTORIZO</div></td>
                    <td width="466" class="Estilo1"><div align="center">_________________________________________________<br />ENCARGADO DE LUBRICANTES</div></td>
                </tr>
            </table> 
            <?php
        }
        ?>

    </body>
</html> 