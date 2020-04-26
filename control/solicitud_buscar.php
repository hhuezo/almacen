
<html>
    <head>

        <!--para ventana modal js-->
        <link rel="stylesheet" href="../css/style_form.css" />
        <script type="text/javascript" src="../js/Ajax.js"></script>

        <title></title>

    </head>



    <script language="JavaScript">

        function solicitudSelect(Oid, CodSolicitud, OidAutomovil, NumeroEquipo, NumeroPlaca, Descripcion,MarcaAuto) {
            parent.document.getElementById('Oid').value = Oid;
            parent.document.getElementById('CodSolicitud').value = CodSolicitud;
            parent.document.getElementById('OidAutomovil').value = OidAutomovil;
            parent.document.getElementById('Equipo').value = NumeroEquipo;
            parent.document.getElementById('Placa').value = NumeroPlaca;
            parent.document.getElementById('Descripcion').value = Descripcion;
            parent.document.getElementById('Marca').value = MarcaAuto;
            parent.document.getElementById('targetDiv').innerHTML = '';
            parent.TINY.box.hide();
        }

    </script>
    <section class="container_marco">
        <div class="marco">

            <h2>BUSQUEDA DE SOLICITUDES</h2>

            <body>

            <center>

                <form name="catalogo_solicituds_buscar"  
                      action="javascript:buscarAceptar('solicitud_buscar_aceptar.php?txt_solicitud='+catalogo_solicituds_buscar.txt_solicitud.value,'targetDiv');">

                    <table height="35">

                        <tr>
                            <td>
                                Articulo:
                            </td>
                            <td>
                                <input type="number" name="txt_solicitud" id="txt_solicitud" style="width: 200px; height: 27px" />
                            </td>
                        </tr>

                    </table>

                    <input type="button" name="btnAceptar" id="btnAceptar" value="Aceptar" 
                           onClick="javascript:buscarAceptar('solicitud_buscar_aceptar.php?txt_solicitud=' + catalogo_solicituds_buscar.txt_solicitud.value, 'targetDiv');"/>
                </form>
                <div id="targetDiv"></div>
            </center>
            </body>

        </div>
    </section>

</html>