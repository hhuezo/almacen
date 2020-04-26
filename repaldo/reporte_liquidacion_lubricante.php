<?php
require_once('conexion/conexion.php');
session_start();

$rs = mysql_query("SELECT * FROM agrupacion_operacional");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Almacen</title>

        <!--para ventana modal js-->
        <link rel="stylesheet" href="style_tinybox.css" />
        <script type="text/javascript" src="tinybox.js"></script>

        <!--FIN para ventana modal js-->


        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />
        <script type="text/javascript" src="js/centeredPopup.js"></script>
    </head>
    <body>

        <section class="container">
            <div class="login" align="center">
                <h1><?php include_once('titulo_sistema.html'); ?></h1>

                <h2>LIQUIDACION</h2>

                <form name="liquidacion" method="get" >

                    <table width="40%" height="188" border="0" align="center">
                        <tr>
                            <td><div align="left" ><span>Fecha Inicio</span>:</div></td>
                            <td>&nbsp;<input type="date" name="fecha_ini" id="fecha_ini"  style="width: 300px"></td>
                        </tr>
                        <tr>
                            <td><div align="left">Fecha Fin:</div></td>
                            <td>&nbsp;<input type="date" name="fecha_fin" id="fecha_fin"  style="width: 300px"></td>
                        </tr>
                        <tr>
                            <td><div align="left">Correlativo:</div></td>
                            <td><input type="text" name="correlativo" id="correlativo" style="width: 300px"></td>
                        </tr>
                        <tr>
                            <td><div align="left">Observacion:</div></td>
                            <td><textarea rows="4" cols="38" name="observacion"></textarea></td>   
                        </tr>
                        <tr>
                        <tr>
                            <td height="26" colspan="2" align="center"> 
                                <input type="button" name="aceptar" value="Aceptar" onClick="

                                        if (liquidacion.fecha_ini.value == '') {
                                            alert('Por favor, no dejar la fecha de inicio en blanco')
                                            return false;
                                        }
                                        if (liquidacion.fecha_fin.value == '') {
                                            alert('Por favor, no dejarno dejar la fecha final en blanco')
                                            return false;
                                        }
                                        if (liquidacion.correlativo.value == '') {
                                            alert('Por favor, no dejarno dejar el correlativo en blanco')
                                            return false;
                                        } else {
                                            window.open('reporte_liquidacion_lubricante_aceptar.php?fecha_ini=' + liquidacion.fecha_ini.value + '&fecha_fin=' + liquidacion.fecha_fin.value + '&correlativo=' + liquidacion.correlativo.value + '&observacion=' + liquidacion.observacion.value, 'popup', 1000, 1000, 1, 1, 0, 0, 0, 1, 0);
                                            return false;
                                        }"  > <a href="inicio.php"><input type="button" name="cancelarbtn" value="Cancelar"></a>
                            </td>
                        </tr>
                  </table>

                </form>

            </div>
        </section>
    </body>
</html>
