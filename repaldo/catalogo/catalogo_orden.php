<?php
include('conexion/Conexion_usuario.php');
mysql_close();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Orden</title>
        <!--para ventana modal js-->
        <link rel="stylesheet" href="style_tinybox.css" />
        <script type="text/javascript" src="tinybox.js"></script>
        <!--FIN para ventana modal js-->

        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />

        <script language="JavaScript">
            var modoop = 0;


            function change_option(parametro) {
                switch (parametro) {
                    case 'btnSalir':
                        document.catalogo_orden.action = "../index.php";
                        break;
                }
                document.catalogo_orden.submit();
            }

            function LimpiarTodo() {
                var i;
                for (i = 0; i < document.forms.catalogo_orden.elements.length; i++) {
                    if (document.forms.catalogo_orden.elements[i].type == "text") {
                        document.forms.catalogo_orden.elements[i].value = '';
                    }
                    if (document.forms.catalogo_orden.elements[i].type == "checkbox") {
                        document.forms.catalogo_orden.elements[i].value = 0;
                    }
                }
            }

            function DeshabilitarTodo() {
                var i;
                for (i = 0; i < document.forms.catalogo_orden.elements.length; i++) {
                    if (document.forms.catalogo_orden.elements[i].type != "button") {
                        document.forms.catalogo_orden.elements[i].disabled = true;
                    }
                }
            }


            function HabilitarTodo() {
                var i;
                for (i = 0; i < document.forms.catalogo_orden.elements.length; i++) {
                    if (document.forms.catalogo_orden.elements[i].type != "button") {
                        document.forms.catalogo_orden.elements[i].disabled = false;
                    }
                }
            }

            function IniciarBotones() {
                catalogo_orden.btnBuscar.disabled = false;
                catalogo_orden.btnAgregar.disabled = false;
                catalogo_orden.btnModificar.disabled = true;
                catalogo_orden.btnEliminar.disabled = true;
                catalogo_orden.btnGuardar.disabled = true;
                catalogo_orden.btnCancelar.disabled = true;
                catalogo_orden.btnSalir.disabled = false;
            }

            function IniciarBotonAgregar() {
                catalogo_orden.btnBuscar.disabled = true;
                catalogo_orden.btnAgregar.disabled = true;
                catalogo_orden.btnModificar.disabled = true;
                catalogo_orden.btnEliminar.disabled = true;
                catalogo_orden.btnGuardar.disabled = false;
                catalogo_orden.btnCancelar.disabled = false;
                catalogo_orden.btnSalir.disabled = true;
            }

            function IniciarBotonModificar() {
                catalogo_orden.btnBuscar.disabled = true;
                catalogo_orden.btnAgregar.disabled = true;
                catalogo_orden.btnModificar.disabled = true;
                catalogo_orden.btnEliminar.disabled = true;
                catalogo_orden.btnGuardar.disabled = false;
                catalogo_orden.btnCancelar.disabled = false;
                catalogo_orden.btnSalir.disabled = true;
            }


            function IniciarBotonBuscar() {
                catalogo_orden.btnBuscar.disabled = false;
                catalogo_orden.btnAgregar.disabled = true;
                catalogo_orden.btnModificar.disabled = false;
                catalogo_orden.btnEliminar.disabled = false;
                catalogo_orden.btnGuardar.disabled = false;
                catalogo_orden.btnCancelar.disabled = false;
                catalogo_orden.btnSalir.disabled = true;
            }

        </script>


    </head>
    <body onLoad="DeshabilitarTodo(); IniciarBotones()">
        <section class="container">
            <div class="login" align="center">

                <h1><?php include_once('titulo_sistema.html'); ?></h1>


                <h2>MANTENIMIENTO DE ORDEN DE COMPRA</h2>

                <form name="catalogo_orden" method="post">

                    <table>
                        <tr>
                            <td >Orden</td><td > 
                                <input type="hidden" name="ordenTemp" id="ordenTemp" size="5"  onKeyUp="this.value = this.value.toUpperCase();"> 
                                <input type="text" name="orden_compra" id="orden_compra" size="5"  onKeyUp="this.value = this.value.toUpperCase();">
                                <input type="button" onClick="TINY.box.show({iframe: 'catalogo_orden_buscar.php'
                                            , boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}});
                                       " name="btnBuscar" value="Buscar" title="Buscar articulos" />   
                            </td>

                        </tr>
                        <tr>
                            <td >Fecha</td>
                            <td>&nbsp;<input type="date" name="txt_fecha"  id="txt_fecha" style="width: 280px"></td>
                        </tr> 
                        <tr>
                            <td>Agrupacion Ope</td>
                            <td>
                                <select name="cmb_agrupacion">
                                    <option value="1">GENERAL</option>
                                    <option value="2">AGROINDUSTRIAL</option>
                                </select>	   
                            </td>
                        </tr>
                        <tr>
                            <td>Proveedor</td>
                            <td>
                                <input type="hidden" name="id_proveedor" id="id_proveedor" size="5" />
                                <input type="text" name="txt_proveedor" id="txt_proveedor" size="50" onBlur="this.value = this.value.toUpperCase();" />

                                <a href="#" onClick="TINY.box.show({iframe: 'catalogo_proveedores_buscar.php', boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                   class="enlacebotonimagen" name="btnBuscar">
                                    <img src="css/16-Search.ico"></a> 
                            </td>
                        </tr>

                        </tr>
                        <tr>
                            <td >Para uso de</td>
                            <td><input type="text" name="txt_uso" id="txt_uso"></td>
                        </tr> 
                        <?php
                        if ($_SESSION['id_tipo'] == 1) {
                            ?>
                            <tr>
                                <td >Usuario</td>
                                <td>	 
                                    <input type="hidden" name="id_usuario" id="id_usuario" size="5" readonly="true" onKeyUp="this.value = this.value.toUpperCase();">
                                    <input type="text" name="txt_usuario" id="txt_usuario" size="35" onKeyUp="this.value = this.value.toUpperCase();">
                                    <input type="hidden" name="txt_clave" id="txt_clave">
                                    <input type="hidden" name="id_rol" id="id_rol" size="5" readonly="true">
                                    <input type="hidden" name="txt_rol" id="txt_rol" size="35" readonly="true">
                                    <input type="hidden" name="cmb_estado" id="cmb_estado" size="35" readonly="true">
                                    <a href="#" onClick="TINY.box.show({iframe: 'catalogo_usuario_buscar.php', boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                       class="enlacebotonimagen" name="btnBuscar">
                                        <img src="css/16-Search.ico"></a> 
                                </td>    
                            </tr>

                            <tr>
                                <td>Bodega</td>
                                <td>

                                    <select name="cmb_bodega" id="cmb_bodega">
                                        <option value="1">ALMACEN DE BIENES</option>
                                        <option value="2">BODEGA DE LUBRICANTES</option>
                                    </select> 
                                </td>
                            </tr>


                        <?php } else {
                            ?>
                            <input type="hidden" name="cmb_bodega" id="cmb_bodega">
                            <input type="hidden" name="id_usuario" id="id_usuario" size="5" readonly="true" onKeyUp="this.value = this.value.toUpperCase();">
                            <input type="hidden" name="txt_usuario" id="txt_usuario" size="35" onKeyUp="this.value = this.value.toUpperCase();">
                            <input type="hidden" name="txt_clave" id="txt_clave">
                            <input type="hidden" name="id_rol" id="id_rol" size="5" readonly="true">
                            <input type="hidden" name="txt_rol" id="txt_rol" size="35" readonly="true">
                            <input type="hidden" name="cmb_estado" id="cmb_estado" size="35" readonly="true">
                            <?php
                        }
                        ?>


                    </table>


                    <table border="0">

                        <tr>
                            <td><input type="button" name="btnAgregar" value="Agregar"  size="10" onClick="modoop = 1; HabilitarTodo(); IniciarBotonModificar(); LimpiarTodo(); catalogo_orden.txt_auto.focus(); document.getElementById('targetDiv').innerHTML = ''"/></td>

                            <td><input type="button" name="btnModificar" value="Modificar"   size="10" onClick="
                                    if (catalogo_orden.orden_compra.value == '') {
                                        alert('Por favor, Buscar registro a Modificar')
                                    } else {
                                        HabilitarTodo();
                                        IniciarBotonModificar();
                                        modoop = 2
                                    }"/>
                            </td>

                            <td><input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
                                    if (catalogo_orden.orden_compra.value != '') {
                                        if (confirm('Esta seguro que desea Eliminar este Registro?')) {
                                            sendQueryToDelete('catalogo_orden_eliminar.php?orden_compra=' + catalogo_orden.orden_compra.value, 'targetDiv');
                                            LimpiarTodo();
                                        }
                                    } else
                                        alert('Por favor, Buscar registro a Eliminar')"/>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="button" name="btnGuardar" value="Guardar"   size="10" onClick="
//	alert(modoop);
                                    if (modoop == 1)
                                        sendQueryToAdd('catalogo_orden_guardar.php?modoop=1&orden_compra=' + catalogo_orden.orden_compra.value + '&txt_fecha=' + catalogo_orden.txt_fecha.value + '&id_proveedor=' + catalogo_orden.id_proveedor.value + '&txt_uso=' + catalogo_orden.txt_uso.value + '&id_usuario=' + catalogo_orden.id_usuario.value + '&cmb_agrupacion=' + catalogo_orden.cmb_agrupacion.value + catalogo_orden.id_usuario.value + '&cmb_bodega=' + catalogo_orden.cmb_bodega.value,
                                                'targetDiv');
                                    if (modoop == 2)
                                        sendQueryToEdit('catalogo_orden_guardar.php?modoop=2&orden_compra=' + catalogo_orden.orden_compra.value + '&txt_fecha=' + catalogo_orden.txt_fecha.value + '&id_proveedor=' + catalogo_orden.id_proveedor.value + '&txt_uso=' + catalogo_orden.txt_uso.value + '&id_usuario=' + catalogo_orden.id_usuario.value + '&cmb_agrupacion=' + catalogo_orden.cmb_agrupacion.value + '&ordenTemp=' + catalogo_orden.ordenTemp.value + '&cmb_bodega=' + catalogo_orden.cmb_bodega.value,
                                                'targetDiv');
                                    IniciarBotones();
                                       "/>
                            </td>
                            <td><input type="button" name="btnCancelar" value="Cancelar"   size="10" onClick="DeshabilitarTodo();
                                    IniciarBotones()"/></td>
                            <td><input type="button" name="btnSalir" value="     Salir    "   size="10" onClick="change_option('btnSalir')"/></td>
                        </tr>

                    </table>

                    <div id="targetDiv"></div>
                </form>
            </div>
        </section>
    </body>
</html>
