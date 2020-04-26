
<html>
    <head>

        <!--para ventana modal js-->
        <link rel="stylesheet" href="../css/style_form.css" />
        <script type="text/javascript" src="../js/Ajax.js"></script>

        <title></title>

    </head>



    <script language="JavaScript">

        function articuloSelect(Id, Nombre, Existencia) {
            parent.document.getElementById('IdArticulo').value = Id;
            parent.document.getElementById('Articulo').value = Nombre;
            parent.document.getElementById('Existencia').value = Existencia;
            parent.document.getElementById('targetDiv').innerHTML = '';
            parent.TINY.box.hide();
        }

    </script>
    <section class="container_marco">
        <div class="marco">

            <h2>BUSQUEDA DE ARTICULOS</h2>

            <body>

            <center>

                <form name="catalogo_articulos_buscar"  
                      action="javascript:buscarAceptar('articulo_activo_buscar_aceptar.php?txt_nombre='+catalogo_articulos_buscar.txt_nombre.value,'targetDiv');">

                    <table>

                        <tr>
                            <td>
                                Articulo:
                            </td>
                            <td>
                                <input type="text" name="txt_nombre" id="txt_nombre" size="35" />
                            </td>
                        </tr>

                    </table>

                    <input type="button" name="btnAceptar" id="btnAceptar" value="Aceptar" 
                           onClick="javascript:buscarAceptar('articulo_activo_buscar_aceptar.php?txt_nombre=' + catalogo_articulos_buscar.txt_nombre.value, 'targetDiv');"/>
                </form>
                <div id="targetDiv"></div>
            </center>
            </body>

        </div>
    </section>

</html>