<?php
include('../conexion/conexion.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inventario</title>
        <link rel="stylesheet" href="../css/style_form.css" type="text/css" />
        <script src="../js/jquery-1.4.1.js" type="text/javascript"></script>
        <script src="../ajax/Ajax.js" type="text/javascript"></script>
    </head>


    <body>
        <section class="container">
            <div class="login" align="center">
                <h2>REPORTE DE ORDEN DE COMPRA</h2>	
                <form name="inventario">
                    <table align="center" border="0">
                        <tr>
                            <td>ORDEN DE COMPRA</td>
                            <td><input type="hidden"  id="id">
                                <input type="text"  id="orden" size="12" style="width: 400px"></td>
                        </tr>
                        <tr>                        
                            <td>FECHA</td>
                            <td>&nbsp;<input type="date"  id="fecha" value="<?php echo date("Y-m-d")  ?>" style="width: 400px"></td>
                        </tr>
                        <tr>
                            <td>NUMERO ACTA</td>
                            <td><input type="text" id="acta" style="width: 400px" readonly="true"></td>
                        </tr>
                        <tr>
                            <td>REPRESENTANTE</td>
                            <td><input type="text" id="representante" style="width: 400px" onBlur="this.value = this.value.toUpperCase();"></td>
                        </tr>
                        <tr>
                            <td>FACTURAS</td>
                            <td><input type="text" id="facturas" style="width: 400px" ></td>
                        </tr>
                         <tr>
                            <td>ADMINSTRADOR DE CONTRATO</td>
                            <td><input type="text" id="administrador" style="width: 400px" onBlur="this.value = this.value.toUpperCase();"></td>
                        </tr>
                         <tr>
                            <td>CARGO DE ADMINSTRADOR DE CONTRATO</td>
                            <td><input type="text" id="cargo" style="width: 400px" onBlur="this.value = this.value.toUpperCase();"></td>
                        </tr>
                         <tr>
                            <td>ENCARGADO DE ALMACEN</td>
                            <td><input type="text" id="encargado" value="SANTOS ANTONIO HERRERA" style="width: 400px" onBlur="this.value = this.value.toUpperCase();"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr><td colspan="2"><center><input type="button" id="btn_aceptar" value="Aceptar">
                            <a href="../inicio.php"><input type="button" name="btncancelar" value="Cancelar"></a></center></td>
                        </tr>

                    </table>

                    <div id="targetDiv"></div>


                    <script type="text/javascript">
                        $(document).ready(function () {

                            $('#btn_aceptar').click(function () {
                                if (document.getElementById('orden').value.trim() == '') {
                                    alert('Error!, Digite la orden');
                                    return false;
                                }
                                if (document.getElementById('fecha').value.trim() == '') {
                                    alert('Error!, Digite una fecha');
                                    return false;
                                }
                                if (document.getElementById('representante').value.trim() == '') {
                                    alert('Error!, Digite un representante');
                                    return false;
                                }
                                if (document.getElementById('facturas').value.trim() == '') {
                                    alert('Error!, Digite las facturas');
                                    return false;
                                }


                                window.open('acta_guardar.php?Orden=' + document.getElementById('orden').value.trim() +
                                        '&Id=' + document.getElementById('id').value.trim() +
                                        '&Acta=' + document.getElementById('acta').value.trim() +
                                        '&Fecha=' + document.getElementById('fecha').value.trim() +
                                        '&Representante=' + document.getElementById('representante').value.trim() +
                                        '&Administrador=' + document.getElementById('administrador').value.trim() +
                                        '&Cargo=' + document.getElementById('cargo').value.trim() +
                                        '&Encargado=' + document.getElementById('encargado').value.trim() +
                                        '&Facturas=' + document.getElementById('facturas').value.trim(),
                                        '_blank');

                            });


                            $('#orden').blur(function () {
                                if (document.getElementById('orden').value.trim() != '')
                                {
                                    sendQueryToText('genera_id_acta.php?Orden=' + document.getElementById('orden').value, 'id');
                                    sendQueryToText('genera_numero_acta.php?Orden=' + document.getElementById('orden').value, 'acta');
                                    sendQueryToText('genera_fecha_acta.php?Orden=' + document.getElementById('orden').value, 'fecha');
                                    sendQueryToText('genera_representante_acta.php?Orden=' + document.getElementById('orden').value, 'representante');
                                    sendQueryToText('genera_facturas_acta.php?Orden=' + document.getElementById('orden').value, 'facturas');
                                    sendQueryToText('genera_adminstrador_acta.php?Orden=' + document.getElementById('orden').value, 'administrador');
                                    sendQueryToText('genera_cargo_acta.php?Orden=' + document.getElementById('orden').value, 'cargo');
                                }


                            });

                        });



                    </script>





                </form>

            </div>






        </section>
    </body>
</html>
