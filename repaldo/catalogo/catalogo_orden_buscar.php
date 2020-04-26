
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

        <!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
        <script src="js/jquery-1.4.1.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/principal.css" />


        <script language="JavaScript">

            function ordenSelect(orden_compra, txt_fecha, id_proveedor, txt_proveedor, txt_uso, id_usuario, txt_usuario, ordenTemp, cmb_bodega) {
                parent.document.getElementById('orden_compra').value = orden_compra;
                parent.document.getElementById('txt_fecha').value = txt_fecha;
                parent.document.getElementById('id_proveedor').value = id_proveedor;
                parent.document.getElementById('txt_proveedor').value = txt_proveedor;
                parent.document.getElementById('txt_uso').value = txt_uso;
                parent.document.getElementById('id_usuario').value = id_usuario;
                parent.document.getElementById('txt_usuario').value = txt_usuario;
                parent.document.getElementById('ordenTemp').value = ordenTemp;
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

                <h2>BUSQUEDA DE ORDENES</h2>

                <form name="catalogo_orden_buscar" 
                      action="javascript:buscarAceptar('Ajax/catalogo_orden_buscar_aceptar.php?txt_nombre_orden='+catalogo_orden_buscar.txt_nombre_orden.value,'targetDiv');">

                    <table>

                        <tr>
                            <td>
                                Orden:
                            </td>
                            <td>
                                <input type="text" id="txt_nombre_orden" name="txt_nombre_orden" autofocus="true" onKeypress="if (event.keyCode == 13)
                                        {
                                            catalogo_orden_buscar.btnAceptar.focus();
                                        }" />
                            </td>
                        </tr>

                    </table>

                    <input type="button" name="btnAceptar" value="Aceptar" 
                           onClick="javascript:buscarAceptar('Ajax/catalogo_orden_buscar_aceptar.php?txt_nombre_orden=' + catalogo_orden_buscar.txt_nombre_orden.value, 'targetDiv');"/>


                </form>
                <div id="targetDiv"></div>
            </div>
        </section>

    </body>
</html>
