
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

            function articuloSelect(id, nombre, estante, casilla, id_cuenta, txt_cuenta, id_unidad, txt_unidad, cmb_estado, cmb_bodega) {
                parent.document.getElementById('id_articulo').value = id;
                parent.document.getElementById('txt_articulo').value = nombre;
                parent.document.getElementById('txt_estante').value = estante;
                parent.document.getElementById('casilla').value = casilla;
                parent.document.getElementById('id_cuenta').value = id_cuenta;
                parent.document.getElementById('txt_cuenta').value = txt_cuenta;
                parent.document.getElementById('id_unidad').value = id_unidad;
                parent.document.getElementById('txt_unidad').value = txt_unidad;
                parent.document.getElementById('targetDiv').innerHTML = '';
                parent.IniciarBotonBuscar();
                parent.TINY.box.hide();
            }

        </script>

    </head>
    <body>
        <section class="container_marco">
            <div class="marco" align="center">
                <h2>BUSQUEDA DE ARTICULOS</h2>


                <form name="catalogo_articulos_buscar"  action="javascript:buscarAceptar('Ajax/catalogo_articulos_buscar_aceptar.php?txt_nombre='+catalogo_articulos_buscar.txt_nombre.value,'targetDiv');">

                    <table>

                        <tr>
                            <td>Articulo</td>
                            <td><input type="text" name="txt_nombre" id="txt_nombre" size="35" autofocus="true" /></td>
                        </tr>

                    </table>

                    <input type="button" name="btnAceptar" id="btnAceptar" value="Aceptar" 
                           onClick="javascript:buscarAceptar('Ajax/catalogo_articulos_buscar_aceptar.php?txt_nombre=' + catalogo_articulos_buscar.txt_nombre.value, 'targetDiv');"/>
                </form>

                <div id="targetDiv"></div>

            </div>
        </section>
    </body>
</html>
