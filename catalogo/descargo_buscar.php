
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

            function articuloSelect(Id, Codigo, Fecha, Oficina) {
                parent.document.getElementById('Id').value = Id;
                parent.document.getElementById('Codigo').value = Codigo;
                parent.document.getElementById('Fecha').value = Fecha;
                parent.document.getElementById('Oficina').value = Oficina;
                parent.document.getElementById('targetDiv').innerHTML = '';
                parent.IniciarBotonBuscar();
                parent.TINY.box.hide();
            }

        </script>

    </head>
    <body>
        <section class="container_marco">
            <div class="marco" align="center">
                <h2>BUSQUEDA DE DESCARGOS</h2>


                <form name="catalogo_articulos_buscar"  action="javascript:buscarAceptar('descargo_buscar_aceptar.php?txt_nombre='+catalogo_articulos_buscar.txt_nombre.value,'targetDiv');">

                    <table>

                        <tr>
                            <td>Descargo</td>
                            <td><input type="text" name="txt_nombre" id="txt_nombre" size="35" autofocus="true" /></td>
                        </tr>

                    </table>

                    <input type="button" name="btnAceptar" id="btnAceptar" value="Aceptar" 
                           onClick="javascript:buscarAceptar('descargo_buscar_aceptar.php?txt_nombre=' + catalogo_articulos_buscar.txt_nombre.value, 'targetDiv');"/>
                </form>

                <div id="targetDiv"></div>

            </div>
        </section>
    </body>
</html>
