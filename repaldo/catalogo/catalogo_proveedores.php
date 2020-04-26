
<html>
    <head>
        <meta charset="UTF-8">
        <title>Almacen</title>
        <!--para ventana modal js-->
        <link rel="stylesheet" href="style_tinybox.css" />
        <script type="text/javascript" src="tinybox.js"></script>

        <!--FIN para ventana modal js-->


        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />
    </head>

    <script language="JavaScript">
        //var modoop=0;


        function change_option(parametro) {
            switch (parametro) {
                case 'btnSalir':
                    document.catalogo_proveedores.action = "../index.php";
                    break;
            }
            document.catalogo_proveedores.submit();
        }

        function LimpiarTodo() {
            var i;
            for (i = 0; i < document.forms.catalogo_proveedores.elements.length; i++) {
                if (document.forms.catalogo_proveedores.elements[i].type == "text") {
                    document.forms.catalogo_proveedores.elements[i].value = '';
                }
                if (document.forms.catalogo_proveedores.elements[i].type == "checkbox") {
                    document.forms.catalogo_proveedores.elements[i].value = 0;
                }
            }
        }

        function DeshabilitarTodo() {
            var i;
            for (i = 0; i < document.forms.catalogo_proveedores.elements.length; i++) {
                if (document.forms.catalogo_proveedores.elements[i].type != "button") {
                    document.forms.catalogo_proveedores.elements[i].disabled = true;
                }
            }
        }

        function HabilitarTodo() {
            var i;
            for (i = 0; i < document.forms.catalogo_proveedores.elements.length; i++) {
                if (document.forms.catalogo_proveedores.elements[i].type != "button") {
                    document.forms.catalogo_proveedores.elements[i].disabled = false;
                }
            }
        }

        function IniciarBotones() {
            catalogo_proveedores.btnBuscar.disabled = false;
            catalogo_proveedores.btnAgregar.disabled = false;
            catalogo_proveedores.btnModificar.disabled = true;
            catalogo_proveedores.btnEliminar.disabled = true;
            catalogo_proveedores.btnGuardar.disabled = true;
            catalogo_proveedores.btnCancelar.disabled = true;
            catalogo_proveedores.btnSalir.disabled = false;
        }

        function IniciarBotonAgregar() {
            catalogo_proveedores.btnBuscar.disabled = true;
            catalogo_proveedores.btnAgregar.disabled = true;
            catalogo_proveedores.btnModificar.disabled = true;
            catalogo_proveedores.btnEliminar.disabled = true;
            catalogo_proveedores.btnGuardar.disabled = false;
            catalogo_proveedores.btnCancelar.disabled = false;
            catalogo_proveedores.btnSalir.disabled = true;
        }

        function IniciarBotonModificar() {
            catalogo_proveedores.btnBuscar.disabled = true;
            catalogo_proveedores.btnAgregar.disabled = true;
            catalogo_proveedores.btnModificar.disabled = true;
            catalogo_proveedores.btnEliminar.disabled = true;
            catalogo_proveedores.btnGuardar.disabled = false;
            catalogo_proveedores.btnCancelar.disabled = false;
            catalogo_proveedores.btnSalir.disabled = true;
        }


        function IniciarBotonBuscar() {
            catalogo_proveedores.btnBuscar.disabled = false;
            catalogo_proveedores.btnAgregar.disabled = true;
            catalogo_proveedores.btnModificar.disabled = false;
            catalogo_proveedores.btnEliminar.disabled = false;
            catalogo_proveedores.btnGuardar.disabled = true;
            catalogo_proveedores.btnCancelar.disabled = false;
            catalogo_proveedores.btnSalir.disabled = false;
        }



    </script>

</head>
<body onLoad="DeshabilitarTodo(); IniciarBotones()">
    <section class="container">
        <div class="login" align="center">
            <h1>
                <?php include_once('titulo_sistema.html'); ?>
            </h1>

            <h2>MANTENIMIENTO DE PROVEEDORES</h2>

            <br />
            <form name="catalogo_proveedores" method="post">

                <table>
                    <tr>
                        <td>Proveedor</td>
                        <td>
                            <input type="hidden" name="id_proveedor" id="id_proveedor" size="5" />
                            <input type="text" name="txt_proveedor" id="txt_proveedor" size="50" onBlur="this.value = this.value.toUpperCase();" />
                            <input type="button" onClick="TINY.box.show({iframe: 'catalogo_proveedores_buscar.php' , boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}});
                                   " name="btnBuscar" value="Buscar" title="Buscar proveedores" />    

                        </td>
                    </tr>
                </table>
                <table border="0">

                    <tr>
                        <td><input type="button" name="btnAgregar" value="Agregar"  size="10" onClick="HabilitarTodo(); IniciarBotonModificar(); LimpiarTodo(); catalogo_proveedores.txt_proveedor.focus(); modoop = 1; document.getElementById('targetDiv').innerHTML = ''"/></td>

                        <td><input type="button" name="btnModificar" value="Modificar"   size="10" onClick="
                            if (catalogo_proveedores.txt_proveedor.value == '' && catalogo_proveedores.txt_proveedor.value == '') {
                                alert('Por favor, Buscar registro a Modificar')
                            } else {
                                HabilitarTodo();
                                IniciarBotonModificar();
                                modoop = 2
                            }"/>
                        </td>
                        <td><input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
                        if (catalogo_proveedores.id_proveedor.value != '') {
                            if (confirm('Esta seguro que desea Eliminar este Registro?')) {
                                sendQueryToDelete('catalogo_proveedores_eliminar.php?id_proveedor=' + catalogo_proveedores.id_proveedor.value, 'targetDiv');
                                catalogo_proveedores.txt_proveedor.value = '';
                            }
                        } else
                            alert('Por favor, Buscar registro a Eliminar')"/>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="button" name="btnGuardar" value="Guardar"   size="10" onClick="
                        if (modoop == 1)
                            sendQueryToAdd('catalogo_proveedores_guardar.php?modoop=1&txt_proveedor=' + catalogo_proveedores.txt_proveedor.value,
                                    'targetDiv');
                            if (modoop == 2)
                                sendQueryToEdit('catalogo_proveedores_guardar.php?modoop=2&txt_proveedor=' + catalogo_proveedores.txt_proveedor.value +
                                        '&id_proveedor=' + catalogo_proveedores.id_proveedor.value,
                                        'targetDiv');
                                IniciarBotones();
                                   "/>
                        </td>
                        <td><input type="button" name="btnCancelar" value="Cancelar"   size="10" onClick="DeshabilitarTodo(); IniciarBotones()"/></td>
                        <td><input type="button" name="btnSalir" value="     Salir    "   size="10" onClick="change_option('btnSalir')"/></td>
                    </tr>

                </table>

                <div id="targetDiv"></div>

            </form>

        </div>
    </section>
</body>
</html>
