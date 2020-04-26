<?php
   session_start();
    if (!isset($_SESSION['username'])){
        header("Location: index.php");
       exit();
    } 
    include('conexion/conexion.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Almacen</title>
        <link rel="stylesheet" href="style_tinybox.css" />
        <script type="text/javascript" src="tinybox.js"></script>
        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />
    </head>
    <body>
        <section class="container">
            <div class="login" align="center">

                <h1><?php include_once('titulo_sistema.html'); ?></h1>

                <h2>BUSQUEDA DE ORDEN DE COMPRA</h2>	


                <form name="buscar_orden" method="get" action="javascript:buscarAceptar('ajax/buscar_orden_aceptar.php?txt_orden='+buscar_orden.txt_orden.value,'targetDiv');" >

                    <table>
                        <tr>
                            <td>Orden</td>
                            <td>
                                <input type="text" name="txt_orden" required="true" autofocus="true" size="35" onKeypress="if (event.keyCode == 13)
                                {
                                    buscar_orden.btnAceptar.focus();
                                }" />
                            </td>
                        </tr>
                    </table>
                    <input type="submit" name="btnAceptar" value="Aceptar">
                    <a href="inicio.php"><input type="button" name="cancelarbtn" value="Cancelar"></a>

                </form>

                <div id="targetDiv"></div>



            </div>
        </section>
    </body>
</html>
