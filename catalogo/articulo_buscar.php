
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <!--para ventana modal js-->
        <link rel="stylesheet" href="../css/style_form.css" />
        <link rel="stylesheet" type="text/css" href="../css/botones.css" />

        <script type="text/javascript" src="../js/tinybox.js"></script>
        <script src="Ajax.js" type="text/javascript"></script>

        <!--FIN para ventana modal js-->

        <!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.7.2.custom.css" />
        <script src="../js/jquery-1.4.1.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/principal.css" />



        <script language="JavaScript">

            function articuloSelect(Articulo, NombreArticulo, Estante, Casilla, Cuenta, Medida, Estado) {
                parent.document.getElementById('Articulo').value = Articulo;
                parent.document.getElementById('NombreArticulo').value = NombreArticulo;
                parent.document.getElementById('Estante').value = Estante;
                parent.document.getElementById('Casilla').value = Casilla;
                parent.document.getElementById('Cuenta').value = Cuenta;
                parent.document.getElementById('Medida').value = Medida;
                parent.document.getElementById('Estado').value = Estado;
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


                <form name="catalogo_articulos_buscar"  action="javascript:buscarAceptar('articulo_buscar_aceptar.php?txt_nombre='+catalogo_articulos_buscar.txt_nombre.value,'targetDiv');">

                    <table>

                        <tr>
                            <td>Articulo</td>
                            <td><input type="text" name="txt_nombre" id="txt_nombre" size="35" autofocus="true" /></td>
                        </tr>

                    </table>

                    <input type="button" name="btnAceptar" id="btnAceptar" value="Aceptar" 
                           onClick="javascript:buscarAceptar('articulo_buscar_aceptar.php?txt_nombre=' + catalogo_articulos_buscar.txt_nombre.value, 'targetDiv');"/>
                </form>

                <div id="targetDiv"></div>

            </div>
        </section>
    </body>
</html>
