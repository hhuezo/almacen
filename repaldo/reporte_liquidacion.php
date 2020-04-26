<?php
include('conexion/conexion_usuario.php');
mysql_close();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>liquidacion</title>
        <!--para ventana modal js-->
        <link rel="stylesheet" href="style_tinybox.css" />
        <script type="text/javascript" src="tinybox.js"></script>

        <!--FIN para ventana modal js-->
        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />
    </head>
    <body>
        <section class="container" >
            <div class="login" align="center">
                <h1> <?php include_once('titulo_sistema.html'); ?> </h1>
                <h2>LIQUIDACION</h2>
                <form name="liquidacion" action="reporte_liquidacion_aceptar.php" method="get" target="_blank">

                    <table width="50%" border="0" align="center">

                        <tr>
                            <td ><div align="left">Agrupacion Operacional:</td>
                            <td>
                                <select name="agru" id="agru">
                                    <option value="0">LIQUIDACION COMPLETA</option>
                                    <option value="1">FONDO GENERAL</option>
                                    <option value="2">AGROINDUSTRIAL</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td height="26" ><div align="left" ><span>Fecha Inicio</span>:</div></td>
                            <td>
                                <input type="date" name="fecha_ini" style="width: 300px" id="fecha_ini" size="12" required="true"></td>    
                        </tr>
                        <tr>
                            <td height="26" ><div align="left">Fecha Fin</div></td>
                            <td>
                                <input type="date" name="fecha_fin" style="width: 300px" id="fecha_fin"  size="12" required="true"></td>
                            </td>

                        </tr>
                         <tr>
                            <td height="26" ><div align="left">Consultar</div></td>
                            <td>
                                <select name="opcion" >
                                    <option value="2">EXPORTAR</option>
                                    <option value="0">CONSULTAR</option>                                    
                                </select>
                            </td>

                        </tr>
                        <tr>
                            <td height="26" colspan="2"> 

                        <center><input type="submit" name="aceptar" value="Aceptar"> 
                            <a href="inicio.php"><input type="button" name="cancelarbtn" value="Cancelar">
                                </center>

                                </td>
                                </tr>
                    </table>
                 </form>
            </div>
       </section>

    </body>
</html>
