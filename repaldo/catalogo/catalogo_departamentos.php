<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <!--para ventana modal js-->
        <link rel="stylesheet" href="style_tinybox.css" />
        <script type="text/javascript" src="tinybox.js"></script>

        <!--FIN para ventana modal js-->


        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/botones.css" />
    </head>

    <script language="JavaScript">
        var modoop = 0;


        function change_option(parametro) {
            switch (parametro) {
                case 'btnSalir':
                    document.catalogo_departamentos.action = "../index.php";
                    break;
            }
            document.catalogo_departamentos.submit();
        }

        function LimpiarTodo() {
            var i;
            for (i = 0; i < document.forms.catalogo_departamentos.elements.length; i++) {
                if (document.forms.catalogo_departamentos.elements[i].type == "text") {
                    document.forms.catalogo_departamentos.elements[i].value = '';
                }
                if (document.forms.catalogo_departamentos.elements[i].type == "checkbox") {
                    document.forms.catalogo_departamentos.elements[i].value = 0;
                }
            }
        }

        function DeshabilitarTodo() {
            var i;
            for (i = 0; i < document.forms.catalogo_departamentos.elements.length; i++) {
                if (document.forms.catalogo_departamentos.elements[i].type != "button") {
                    document.forms.catalogo_departamentos.elements[i].disabled = true;
                }
            }
        }

        function HabilitarTodo() {
            var i;
            for (i = 0; i < document.forms.catalogo_departamentos.elements.length; i++) {
                if (document.forms.catalogo_departamentos.elements[i].type != "button") {
                    document.forms.catalogo_departamentos.elements[i].disabled = false;
                }
            }
        }

        function IniciarBotones() {
            catalogo_departamentos.btnBuscar.disabled = false;
            catalogo_departamentos.btnAgregar.disabled = false;
            catalogo_departamentos.btnModificar.disabled = true;
            catalogo_departamentos.btnEliminar.disabled = true;
            catalogo_departamentos.btnGuardar.disabled = true;
            catalogo_departamentos.btnCancelar.disabled = true;
            catalogo_departamentos.btnSalir.disabled = false;
        }

        function IniciarBotonAgregar() {
            catalogo_departamentos.btnBuscar.disabled = true;
            catalogo_departamentos.btnAgregar.disabled = true;
            catalogo_departamentos.btnModificar.disabled = true;
            catalogo_departamentos.btnEliminar.disabled = true;
            catalogo_departamentos.btnGuardar.disabled = false;
            catalogo_departamentos.btnCancelar.disabled = false;
            catalogo_departamentos.btnSalir.disabled = true;
        }

        function IniciarBotonModificar() {
            catalogo_departamentos.btnBuscar.disabled = true;
            catalogo_departamentos.btnAgregar.disabled = true;
            catalogo_departamentos.btnModificar.disabled = true;
            catalogo_departamentos.btnEliminar.disabled = true;
            catalogo_departamentos.btnGuardar.disabled = false;
            catalogo_departamentos.btnCancelar.disabled = false;
            catalogo_departamentos.btnSalir.disabled = true;
        }


        function IniciarBotonBuscar() {
            catalogo_departamentos.btnBuscar.disabled = false;
            catalogo_departamentos.btnAgregar.disabled = true;
            catalogo_departamentos.btnModificar.disabled = false;
            catalogo_departamentos.btnEliminar.disabled = false;
            catalogo_departamentos.btnGuardar.disabled = true;
            catalogo_departamentos.btnCancelar.disabled = false;
            catalogo_departamentos.btnSalir.disabled = true;
        }




    </script>
</head>
<body onLoad="DeshabilitarTodo(); IniciarBotones()">
    <section class="container">
        <div class="login" align="center">

            <h1><?php include_once('titulo_sistema.html'); ?></h1>

            <h2>MANTENIMIENTO DE DEPARTAMENTOS</h2>

            <br />
            <form name="catalogo_departamentos" method="post">

                <table>
                    <tr>
                        <td>Departamento</td>
                        <td>
                            <input type="hidden" name="id_departamento" id="id_departamento" size="5" />
                            <input type="text" name="txt_departamento" id="txt_departamento" size="50" 
                                   onBlur="this.value = this.value.toUpperCase();" />
                            <input type="button" onClick="TINY.box.show({iframe: 'catalogo_departamentos_buscar.php', boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}});
                                   " name="btnBuscar" value="Buscar" title="Buscar proveedores" />    
                        </td>
                    </tr>
                </table>



                <table border="0">
                    <tr>
                        <td><input type="button" name="btnAgregar" value="Agregar"  size="10" onClick="HabilitarTodo(); IniciarBotonModificar(); LimpiarTodo(); catalogo_departamentos.txt_departamento.focus(); modoop = 1; document.getElementById('targetDiv').innerHTML = ''"/></td>

                        <td><input type="button" name="btnModificar" value="Modificar"   size="10" onClick="
            if (catalogo_departamentos.txt_departamento.value == '' && catalogo_departamentos.txt_departamento.value == '') {
                alert('Por favor, Buscar registro a Modificar')
            } else {
                HabilitarTodo();
                IniciarBotonModificar();
                modoop = 2
            }"/>
                        </td>

                        <td><input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
            if (catalogo_departamentos.id_departamento.value != '') {
                if (confirm('Esta seguro que desea Eliminar este Registro?')) {
                    sendQueryToDelete('catalogo_departamentos_eliminar.php?id_departamento=' + catalogo_departamentos.id_departamento.value, 'targetDiv');
                    catalogo_departamentos.txt_departamento.value = '';
                }
            } else
                alert('Por favor, Buscar registro a Eliminar')"/>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="button" name="btnGuardar" value="Guardar"   size="10" onClick="
            if (modoop == 1)
                sendQueryToAdd('catalogo_departamentos_guardar.php?modoop=1&txt_departamento=' + catalogo_departamentos.txt_departamento.value,
                        'targetDiv');
            if (modoop == 2)
                sendQueryToEdit('catalogo_departamentos_guardar.php?modoop=2&txt_departamento=' + catalogo_departamentos.txt_departamento.value +
                        '&id_departamento=' + catalogo_departamentos.id_departamento.value,
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
        </div>
    </section>
</body>
</html>
