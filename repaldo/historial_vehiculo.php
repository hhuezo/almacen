<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
require_once('conexion/conexion.php');
$rol = $_SESSION['id_tipo'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Historial</title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <!--para ventana modal js-->
        <link rel="stylesheet" href="style_tinybox.css" />
        <script type="text/javascript" src="tinybox.js"></script>

        <!--FIN para ventana modal js-->


        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />

        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="css/botones.css" />
        <script src="js/jquery-1.4.1.js" type="text/javascript"></script>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    </head>
    <body>

        <section class="container">
            <div class="login">
                <h1>
                    <?php include_once('titulo_sistema.html'); ?>
                </h1>

                <body onLoad="consultar();">

                <center>

                    <h2>HISTORIAL DE VEHICULOS</h2>		

                    <form name="historial_auto" method="post">

                        <table width="45%" border="1" align="center">
                            <tr>
                                <td >Para uso de</td><td > 

                                    <input type="hidden" name="id_auto" id="id_auto" size="5" readonly="true" onKeyUp="this.value = this.value.toUpperCase();">
                                    <input type="text" name="txt_auto" id="txt_auto" size="35" readonly="true" onKeyUp="this.value = this.value.toUpperCase();">
                                    <input type="hidden" name="cmb_estado" id="cmb_estado" size="35" readonly="true">
                                </td>
                                <td align="center"> 
                                    <a href="#" onClick="TINY.box.show({iframe: 'catalogo_auto_buscar.php', boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                       class="enlacebotonimagen" name="btnBuscar">
                                        <img src="css/16-Search.ico"></a>    		 

                                </td>    
                            </tr>
                            <tr>
                                <td >Equipo</td>
                                <td><input type="text" name="equipo" id="equipo" readonly></td>
                            </tr> 
                            <tr>
                                <td >Placa</td>
                                <td><input type="text" name="placa" id="placa" readonly> </td>
                            </tr>  
                            <?php
                            if ($rol == 5 || $rol == 1) {
                                ?>
                                <tr>
                                    <td>Busqueda Por:</td>
                                    <td>
                                        <select name="TipoBusqueda">
                                            <option value="1">Todos los Articulos</option>
                                            <option value="2">Llantas y Neumaticos</option>
                                        </select>
                                    </td>
                                </tr> 
                            <?php } ?>
                            <tr>

                                <td height="15">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                            <tr>
                                <td colspan="2" align="center"><input type="submit" name="btnAceptar" value="Aceptar" onClick="
                                        if (historial_auto.id_auto.value == '') {
                                            alert('Por favor, no dejar el Automovil en blanco')
                                            return false;
                                        }

                                                                      " />&nbsp;&nbsp;
                                    <a href="inicio.php"><input type="button" name="btnCancelar" value="Cancelar" /></a>
                                </td>

                            </tr>
                        </table>
                    </form>

                    <?php
                    if (isset($_POST['btnAceptar'])) {
                        $auto = $_POST['id_auto'];
                        $equipo = $_POST['equipo'];
                        $placa = $_POST['placa'];
                        $TipoBusqueda = $_POST['TipoBusqueda'];
                        if ($rol == 5 && $TipoBusqueda == 2) {
                            $rs = mysql_query("select id_kar,DATE_FORMAT(k.fecha,'%d/%m/%Y') AS fecha,k.descargo,k.orden_compra,nom_art,k.cantidad,u.nom_med,k.precio,k.total from
                            kardex k inner join articulo a on k.id_art = a.id_art 
                            inner join uni_med u on
                            a.id_um = u.id_um where id_auto = $auto and a.id_cuenta = 14 order by id_kar desc");
                        } else {
                            $rs = mysql_query("select id_kar,DATE_FORMAT(k.fecha,'%d/%m/%Y') AS fecha,k.descargo,k.orden_compra,a.nom_art,k.cantidad,u.nom_med,k.precio,k.total from 
                            kardex k inner join articulo a on k.id_art = a.id_art
                            inner join uni_med u on a.id_um = u.id_um 
                            where id_auto = $auto  order by id_kar desc");
                        }
                        $numFilas = mysql_num_rows($rs);

                        if ($numFilas > 0) {
                            ?>
                            <table width="772" border='1' align='center'>
                                <tr><td colspan ="8"></td></tr>
                                <tr>
                                    <td  colspan ="4"><strong>EQUIPO: <?php echo $equipo ?>   PLACA: <?php echo $placa ?></strong>
                                    </td><td align="right" colspan="4"> </td>
                                </tr>
                                <tr class="row1" bgcolor=#e5eecc>
                                    <td width="55" align="center"><strong>FECHA</strong></td>
                                    <td width="90" align="center"><strong>ORDEN COMPRA</strong></td>
                                    <td width="90" align="center"><strong>DESCARGO</strong></td>
                                    <td width="191" align="center"><strong>ARTICULO</strong></td>
                                    <td width="80" align="center"><strong>CANTIDAD</strong></td>
                                    <td width="75" align="center"><strong>UNI. MED</strong></td>
                                    <td width="67" align="center"><strong>PRECIO</strong></td>
                                    <td width="62" align="center"><strong>TOTAL</strong></td>
                                </tr>
                                <?php
                                $cont = 1;
                                while ($row = mysql_fetch_array($rs)) {
                                    ?>
                                    <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                                        <td><?php echo $row["fecha"]; ?></td>
                                        <td align="center"><?php echo $row["orden_compra"]; ?></td>
                                        <td align="center"><?php echo $row["descargo"]; ?></td>
                                        <td><?php echo $row["nom_art"]; ?></td>
                                        <td align="center"><?php echo $row["cantidad"]; ?></td>
                                        <td align="center"><?php echo $row["nom_med"]; ?></td>
                                        <td align="center">$<?php echo number_format($row["precio"], 2, ',', '.'); ?></td>
                                        <td align="center">$<?php echo number_format($row["total"], 2, ',', '.'); ?></td>
                                    </tr>
                                    <?php
                                    $cont++;
                                }
                                ?>
                            </table>
                                <?php
                            } else {
                                echo "<center><img src='images/error.jpg'></center>";
                            }
                           
                        }
                         mysql_close(); //cierro la conexion 
                        ?>


                </center>

            </div>
        </section>
    </body>
</html>
