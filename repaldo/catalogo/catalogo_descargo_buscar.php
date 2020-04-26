<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <!--para ventana modal js-->
        <link rel="stylesheet" href="css/style_form.css" />
        <link rel="stylesheet" type="text/css" href="css/botones.css" />

        <script type="text/javascript" src="js/tinybox.js"></script>
        <script type="text/javascript" src="Ajax/Ajax.js"></script>

        <!--FIN para ventana modal js-->

        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
        <script src="js/jquery-1.4.1.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/principal.css" />


        <script language="JavaScript">

            function descargoSelect(descargo, txt_fecha, id_departamento, txt_departamento, id_auto, txt_auto, equipo, placa, id_usuario, txt_usuario, descargoTemp,cmb_bodega) {
                parent.document.getElementById('descargo').value = descargo;
                parent.document.getElementById('txt_fecha').value = txt_fecha;
                parent.document.getElementById('id_departamento').value = id_departamento;
                parent.document.getElementById('txt_departamento').value = txt_departamento;
                parent.document.getElementById('id_auto').value = id_auto;
                parent.document.getElementById('txt_auto').value = txt_auto;
                parent.document.getElementById('equipo').value = equipo;
                parent.document.getElementById('placa').value = placa;
                parent.document.getElementById('id_usuario').value = id_usuario;
                parent.document.getElementById('txt_usuario').value = txt_usuario;
                parent.document.getElementById('descargoTemp').value = descargoTemp;
                parent.document.getElementById('cmb_bodega').value = cmb_bodega;
//parent.document.getElementById('targetDiv').innerHTML='';
                parent.TINY.box.hide();
                window.parent.DeshabilitarTodo();
                window.parent.IniciarBotonBuscar();

            }

        </script>


    </head>
    <body>
        <section class="container_marco">
            <div class="marco" align="center">

                <h2>BUSQUEDA DE DESCARGOS</h2>

                <form name="catalogo_descargo_buscar" 
                      action="javascript:buscarAceptar('Ajax/catalogo_descargo_buscar_aceptar.php?txt_nombre_descargo='+catalogo_descargo_buscar.txt_nombre_descargo.value,'targetDiv');">

                    <table>

                        <tr>
                            <td>
                                Descargo
                            </td>
                            <td>
                                <input type="text" id="txt_nombre_descargo" name="txt_nombre_descargo" autofocus="true" size="35" onKeypress="if (event.keyCode == 13)
        {
            catalogo_descargo_buscar.btnAceptar.focus();
        }" />
                            </td>
                        </tr>

                    </table>

                    <input type="button" name="btnAceptar" value="Aceptar" 
                           onClick="javascript:buscarAceptar('Ajax/catalogo_descargo_buscar_aceptar.php?txt_nombre_descargo=' + catalogo_descargo_buscar.txt_nombre_descargo.value, 'targetDiv');"/>


                </form>
                <div id="targetDiv"></div>
            </div>
        </section>
    </body>
</html>
