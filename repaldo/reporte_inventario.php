<?php
include('conexion/conexion.php');
 $rs = mysql_query("SELECT * from cuenta_contable");
mysql_close();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inventario</title>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />
    </head>
    <body>
        <section class="container">
            <div class="login" align="center">
                <h2>INVENTARIO POR CUENTA CONTABLE</h2>	
                <form name="inventario" method="get" action="reporte_inventario_aceptar.php" target="_blank">
                    <table align="center" border="0">

                        <tr><td><center> <input type="hidden" name="fecha" id="fecha" readonly size="12"></center>
                        </td></tr>
                        <tr>
                            <!--<td height="119"><center>-->
                            <td>
                            CUENTA CONTABLE
                            <!-- combobox para la seleccion de cuentas contables -->
                            </td>
                            <td>
                            <select name="cuenta" id="cuenta" style="width: 300px" >
                                <?php
                                while ($row = mysql_fetch_array($rs)) {
                                    ?>
                                    <option value='<?php echo $row["id_cuenta"]; ?>'><?php echo $row["alias"]; ?><?php $row["nom_cuenta"]; ?></option>	
                                <?php }
                                ?>
                                    <option value='100'>CONSOLIDADO</option>
                            </select>

                        </center>

                        </td>
                        </tr>
                        <tr>
                        <td>FECHA</td>
                        <td>&nbsp;<input type="date" name="fecha" style="width: 300px" required="true"></td>
                        </tr>
                         <tr>
                        <td>EXPORTAR</td>
                        <td><select name="exportar" >
							<option value="1">EXPORTAR</option>
							<option value="0">CONSULTAR</option>
						</td>
                        </tr>
                         <tr>
                        <td></td>
                        <td>&nbsp;</td>
                        </tr>
                        <tr><td colspan="2"><center><input type="submit" name="aceptar" value="Aceptar">
                            <a href="inicio.php"><input type="button" name="btncancelar" value="Cancelar"></a></center></td>
                        </tr>
                        
                    </table>
                </form>

            </div>
        </section>
    </body>
</html>
