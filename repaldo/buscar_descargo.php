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
        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />
    </head>
    <body>
        <section class="container">
            <div class="login" align="center">

                <h1><?php include_once('titulo_sistema.html'); ?></h1>
                <h2>BUSQUEDA DE DESCARGO</h2>	
                <form name="buscar_descargo" method="get" action="javascript:buscarAceptar('Ajax/buscar_descargo_aceptar.php?txt_descargo='+buscar_descargo.txt_descargo.value,'targetDiv');" >

                    <table>
                        <tr>
                            <td>Nombre</td>
                            <td>
                                <input type="number" name="txt_descargo" style="width: 300px" autofocus="true" size="35" onKeypress="if (event.keyCode == 13)
                                {
                                    buscar_descargo.btnAceptar.focus();
                                }" />
                            </td>
                        </tr>
                    </table>
                    <input type="submit" name="btnAceptar" value="Aceptar"  onClick="
             if (buscar_descargo.txt_descargo.value == '') {
                 alert('Por favor, Buscar registro')
             }
                           ">
                    <a href="inicio.php"><input type="button" name="cancelarbtn" value="Cancelar"></a>

                </form>



                <div id="targetDiv"></div>

            </div>
        </section>
    </body>
</html>
