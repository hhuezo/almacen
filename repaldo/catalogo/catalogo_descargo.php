<?php
include('conexion/Conexion_usuario.php');
mysql_close();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Descargo</title>
        <!--para ventana modal js-->
        <!--para ventana modal js-->
        <link rel="stylesheet" href="style_tinybox.css" />
        <script type="text/javascript" src="tinybox.js"></script>

        <!--FIN para ventana modal js-->


        <script type="text/javascript" src="ajax/Ajax.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />


        <script language="JavaScript">
            var modoop = 0;


            function change_option(parametro) {
                switch (parametro) {
                    case 'btnSalir':
                        document.catalogo_descargo.action = "../index.php";
                        break;
                }
                document.catalogo_descargo.submit();
            }

            function LimpiarTodo() {
                var i;
                for (i = 0; i < document.forms.catalogo_descargo.elements.length; i++) {
                    if (document.forms.catalogo_descargo.elements[i].type == "text") {
                        document.forms.catalogo_descargo.elements[i].value = '';
                    }
                    if (document.forms.catalogo_descargo.elements[i].type == "checkbox") {
                        document.forms.catalogo_descargo.elements[i].value = 0;
                    }
                }
            }

            function DeshabilitarTodo() {
                var i;
                for (i = 0; i < document.forms.catalogo_descargo.elements.length; i++) {
                    if (document.forms.catalogo_descargo.elements[i].type != "button") {
                        document.forms.catalogo_descargo.elements[i].disabled = true;
                    }
                }
            }


            function HabilitarTodo() {
                var i;
                for (i = 0; i < document.forms.catalogo_descargo.elements.length; i++) {
                    if (document.forms.catalogo_descargo.elements[i].type != "button") {
                        document.forms.catalogo_descargo.elements[i].disabled = false;
                    }
                }
            }

            function IniciarBotones() {
                catalogo_descargo.btnBuscar.disabled = false;
                catalogo_descargo.btnAgregar.disabled = false;
                catalogo_descargo.btnModificar.disabled = true;
                catalogo_descargo.btnEliminar.disabled = true;
                catalogo_descargo.btnGuardar.disabled = true;
                catalogo_descargo.btnCancelar.disabled = true;
                catalogo_descargo.btnSalir.disabled = false;
            }

            function IniciarBotonAgregar() {
                catalogo_descargo.btnBuscar.disabled = true;
                catalogo_descargo.btnAgregar.disabled = true;
                catalogo_descargo.btnModificar.disabled = true;
                catalogo_descargo.btnEliminar.disabled = true;
                catalogo_descargo.btnGuardar.disabled = false;
                catalogo_descargo.btnCancelar.disabled = false;
                catalogo_descargo.btnSalir.disabled = true;
            }

            function IniciarBotonModificar() {
                catalogo_descargo.btnBuscar.disabled = true;
                catalogo_descargo.btnAgregar.disabled = true;
                catalogo_descargo.btnModificar.disabled = true;
                catalogo_descargo.btnEliminar.disabled = true;
                catalogo_descargo.btnGuardar.disabled = false;
                catalogo_descargo.btnCancelar.disabled = false;
                catalogo_descargo.btnSalir.disabled = true;
            }


            function IniciarBotonBuscar() {
                catalogo_descargo.btnBuscar.disabled = false;
                catalogo_descargo.btnAgregar.disabled = true;
                catalogo_descargo.btnModificar.disabled = false;
                catalogo_descargo.btnEliminar.disabled = false;
                catalogo_descargo.btnGuardar.disabled = false;
                catalogo_descargo.btnCancelar.disabled = false;
                catalogo_descargo.btnSalir.disabled = true;
            }

        </script>


    </head>
    <body onLoad="DeshabilitarTodo(); IniciarBotones()">

        <section class="container">
            <div class="login" align="center">

                <h1><?php include_once('titulo_sistema.html'); ?></h1>



                <br/>
                <form name="catalogo_descargo" method="post">

                    <table>

                        <tr>
                            <td >Descargo</td><td > 
                                <input type="hidden" name="descargoTemp" id="descargoTemp" size="5"  onKeyUp="this.value = this.value.toUpperCase();"> 
                                <input type="text" name="descargo" id="descargo" size="5"  onKeyUp="this.value = this.value.toUpperCase();">
                                <input type="button" onClick="TINY.box.show({iframe: 'catalogo_descargo_buscar.php'
                                            , boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}});
                                       " name="btnBuscar" value="Buscar" title="Buscar descargo" /> 
                            </td>

                        </tr>
                        <tr>
                            <td >Fecha</td>
                            <td>&nbsp;<input type="date" name="txt_fecha"  id="txt_fecha" style="width: 280px"></td>
                        </tr> 
                        <tr>
                            <td>
                                Departamento
                            </td>
                            <td>
                                <input type="hidden" name="id_departamento" id="id_departamento" size="5" />
                                <input type="text" name="txt_departamento" id="txt_departamento" size="50" 
                                       onBlur="this.value = this.value.toUpperCase();" />
                                <a href="#" onClick="TINY.box.show({iframe: 'catalogo_departamentos_buscar.php', boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                   class="enlacebotonimagen" name="btnBuscar">
                                    <img src="css/16-Search.ico"></a> 

                            </td>
                        </tr>

                        <tr>
                            <td >Automovil</td><td > 

                                <input type="hidden" name="id_auto" id="id_auto" size="5" readonly="true" onKeyUp="this.value = this.value.toUpperCase();">
                                <input type="text" name="txt_auto" id="txt_auto" size="35" onKeyUp="this.value = this.value.toUpperCase();">
                                <input type="hidden" name="cmb_estado" id="cmb_estado" size="35" readonly="true">
                                <a href="#" onClick="TINY.box.show({iframe: 'catalogo_auto_buscar.php', boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                   class="enlacebotonimagen" name="btnBuscar">
                                    <img src="css/16-Search.ico"></a>    		 

                            </td>    
                        </tr>
                        <tr>
                            <td >Equipo</td>
                            <td><input type="text" name="equipo" id="equipo"></td>
                        </tr> 
                        <tr>
                            <td >Placa</td>
                            <td><input type="text" name="placa" id="placa"> </td>
                        </tr>  
                        <tr>

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



                        <table border="0">

                            <tr>
                                <td><input type="button" name="btnAgregar" value="Agregar"  size="10" onClick="modoop = 1; HabilitarTodo(); IniciarBotonModificar(); LimpiarTodo(); catalogo_descargo.descargo.focus(); document.getElementById('targetDiv').innerHTML = ''"/></td>

                                <td><input type="button" name="btnModificar" value="Modificar"   size="10" onClick="
                                        if (catalogo_descargo.descargo.value == '') {
                                            alert('Por favor, Buscar registro a Modificar')
                                        } else {
                                            HabilitarTodo();
                                            IniciarBotonModificar();
                                            modoop = 2
                                        }"/>
                                </td>

                                <td><input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
                                        if (catalogo_descargo.descargo.value != '') {
                                            if (confirm('Esta seguro que desea Eliminar este Registro?')) {
                                                sendQueryToDelete('catalogo_descargo_eliminar.php?descargo=' + catalogo_descargo.descargo.value, 'targetDiv');
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
                                            sendQueryToAdd('catalogo_descargo_guardar.php?modoop=1&descargo=' + catalogo_descargo.descargo.value + '&txt_fecha=' + catalogo_descargo.txt_fecha.value + '&id_departamento=' + catalogo_descargo.id_departamento.value + '&id_auto=' + catalogo_descargo.id_auto.value + '&id_usuario=' + catalogo_descargo.id_usuario.value + '&cmb_bodega=' + catalogo_descargo.cmb_bodega.value,
                                                    'targetDiv');
                                        if (modoop == 2)
                                            sendQueryToEdit('catalogo_descargo_guardar.php?modoop=2&descargo=' + catalogo_descargo.descargo.value + '&txt_fecha=' + catalogo_descargo.txt_fecha.value + '&id_departamento=' + catalogo_descargo.id_departamento.value + '&id_auto=' + catalogo_descargo.id_auto.value + '&id_usuario=' + catalogo_descargo.id_usuario.value + '&cmb_bodega=' + catalogo_descargo.cmb_bodega.value + '&descargoTemp=' + catalogo_descargo.descargoTemp.value,
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

                </table>
            </div>

        </section>
    </body>
</html>
