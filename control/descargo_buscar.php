
<html>
    <head>

        <!--para ventana modal js-->
        <link rel="stylesheet" href="../css/style_form.css" />
        <script type="text/javascript" src="../js/Ajax.js"></script>

        <title></title>

    </head>



    <script language="JavaScript">

        function descargoSelect(Id, Descargo) {
            parent.document.getElementById('IdDescargo').value = Id;
            parent.document.getElementById('Descargo').value = Descargo;           
            parent.document.getElementById('targetDiv').innerHTML = '';
            parent.TINY.box.hide();
        }

    </script>
    <section class="container_marco">
        <div class="marco">

            <h2>BUSQUEDA DE SOLICITUDES</h2>

            <body>

            <center>

                <form name="catalogo_descargos_buscar"  
                      action="javascript:buscarAceptar('descargo_buscar_aceptar.php?txt_descargo='+catalogo_descargos_buscar.txt_descargo.value,'targetDiv');">

                    <table height="35">

                        <tr>
                            <td>
                                Articulo:
                            </td>
                            <td>
                                <input type="number" name="txt_descargo" id="txt_descargo" style="width: 200px; height: 27px" />
                            </td>
                        </tr>

                    </table>

                    <input type="button" name="btnAceptar" id="btnAceptar" value="Aceptar" 
                           onClick="javascript:buscarAceptar('descargo_buscar_aceptar.php?txt_descargo=' + catalogo_descargos_buscar.txt_descargo.value, 'targetDiv');"/>
                </form>
                <div id="targetDiv"></div>
            </center>
            </body>

        </div>
    </section>

</html>