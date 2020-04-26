<?php
require_once('../conexion/conexion.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Almacen</title>

        <!--para ventana modal js-->
        <link rel="stylesheet" href="../style_tinybox.css" />
        <script type="text/javascript" src="../tinybox.js"></script>

        <!--FIN para ventana modal js-->
        <script src="../select2/jquery-3.3.1.js" type="text/javascript"></script>
        <script type="text/javascript" src="../Ajax/Ajax.js"></script>
        <link rel="stylesheet" href="../css/style_form.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="../css/botones.css" />
    </head>

    <script language="JavaScript">
        var modoop = 0;


        function change_option(parametro) {
            switch (parametro) {
                case 'btnSalir':
                    document.catalogo_articulos.action = "../index.php";
                    break;
            }
            document.catalogo_articulos.submit();
        }

        function LimpiarTodo() {
            var i;
            for (i = 0; i < document.forms.catalogo_articulos.elements.length; i++) {
                if (document.forms.catalogo_articulos.elements[i].type == "text") {
                    document.forms.catalogo_articulos.elements[i].value = '';
                }
                if (document.forms.catalogo_articulos.elements[i].type == "checkbox") {
                    document.forms.catalogo_articulos.elements[i].value = 0;
                }
            }
        }

        function DeshabilitarTodo() {
            var i;
            for (i = 0; i < document.forms.catalogo_articulos.elements.length; i++) {
                if (document.forms.catalogo_articulos.elements[i].type != "button") {
                    document.forms.catalogo_articulos.elements[i].disabled = true;
                }
            }
        }

        function HabilitarTodo() {
            var i;
            for (i = 0; i < document.forms.catalogo_articulos.elements.length; i++) {
                if (document.forms.catalogo_articulos.elements[i].type != "button") {
                    document.forms.catalogo_articulos.elements[i].disabled = false;
                }
            }
        }

        function IniciarBotones() {
            catalogo_articulos.btnBuscar.disabled = false;
            catalogo_articulos.btnAgregar.disabled = false;
            catalogo_articulos.btnModificar.disabled = true;
            catalogo_articulos.btnEliminar.disabled = true;
            catalogo_articulos.btnGuardar.disabled = true;
            catalogo_articulos.btnCancelar.disabled = true;
            catalogo_articulos.btnSalir.disabled = false;
        }

        function IniciarBotonAgregar() {
            catalogo_articulos.btnBuscar.disabled = true;
            catalogo_articulos.btnAgregar.disabled = true;
            catalogo_articulos.btnModificar.disabled = true;
            catalogo_articulos.btnEliminar.disabled = true;
            catalogo_articulos.btnGuardar.disabled = false;
            catalogo_articulos.btnCancelar.disabled = false;
            catalogo_articulos.btnSalir.disabled = true;
        }

        function IniciarBotonModificar() {
            catalogo_articulos.btnBuscar.disabled = true;
            catalogo_articulos.btnAgregar.disabled = true;
            catalogo_articulos.btnModificar.disabled = true;
            catalogo_articulos.btnEliminar.disabled = true;
            catalogo_articulos.btnGuardar.disabled = false;
            catalogo_articulos.btnCancelar.disabled = false;
            catalogo_articulos.btnSalir.disabled = true;
        }


        function IniciarBotonBuscar() {
            catalogo_articulos.btnBuscar.disabled = false;
            catalogo_articulos.btnAgregar.disabled = true;
            catalogo_articulos.btnModificar.disabled = false;
            catalogo_articulos.btnEliminar.disabled = false;
            catalogo_articulos.btnGuardar.disabled = true;
            catalogo_articulos.btnCancelar.disabled = false;
            catalogo_articulos.btnSalir.disabled = true;
        }




    </script>
</head>
<body onLoad="DeshabilitarTodo();
        IniciarBotones()">
    <section class="container">
        <div class="login" align="center">
            <h1>
                <?php include_once('../titulo_sistema.html'); ?>
            </h1>


            <h2>MANTENIMIENTO DE ARTICULOS</h2>

            <br />
            <form name="catalogo_articulos" method="post">

                <table>
                    <tr>
                        <td>Nombre</td>
                        <td>
                            <input type="hidden" name="Articulo" id="Articulo" size="5" />
                            <input type="text" name="NombreArticulo" id="NombreArticulo" style="width: 400px; height: 30px"
                                   onBlur="this.value = this.value.toUpperCase();" />

                            <input type="button" onClick="TINY.box.show({iframe: 'articulo_buscar.php'
                                        , boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {
                                        }});
                                   " name="btnBuscar" value="Buscar" title="Buscar articulos" />    

                        </td>
                    </tr>
                    <tr>
                        <td>Estante</td>
                        <td>
                            <input type="text" name="Estante" id="Estante" style="width: 400px; height: 30px"  />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Casilla
                        </td>
                        <td>	
                            <input type="text" name="Casilla" id="Casilla" style="width: 400px; height: 30px"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Cuenta</td>
                        <td>
                            <select id="Cuenta" style="width: 400px; height: 30px">
                                <?php
                                $rs2 = mysqli_query($cn, "SELECT * FROM cuenta");
                                while ($row2 = mysqli_fetch_array($rs2)) {
                                    ?>
                                    <option value="<?php echo $row2[0]; ?>"><?php echo $row2[3]; ?></option> 
                                    <?php
                                }
                                ?>
                            </select>	   
                        </td>
                    </tr>

                    <tr>
                        <td>Unidad Medida</td>
                        <td>
                            <select id="Medida" style="width: 400px; height: 30px">
                                <?php
                                $rs2 = mysqli_query($cn, "SELECT * FROM medida");
                                while ($row2 = mysqli_fetch_array($rs2)) {
                                    ?>
                                    <option value="<?php echo $row2[0]; ?>"><?php echo $row2[1]; ?></option> 
                                    <?php
                                }
                                ?>
                            </select>	   
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Estado Articulo
                        </td>
                        <td>
                            <select name="Estado" id="Estado" style="width: 400px; height: 30px">
                                <option value="1">ACTIVO</option>
                                <option value="0">INACTIVO</option>
                            </select>	   
                        </td>
                    </tr>

                </table>

                <table border="0">
                    <tr>
                        <td><input type="button" name="btnAgregar" value="Agregar"  size="10" onClick="modoop = 1;
                                HabilitarTodo();
                                IniciarBotonModificar();
                                LimpiarTodo();
                                catalogo_articulos.txt_articulo.focus();
                                document.getElementById('targetDiv').innerHTML = ''"/></td>

                        <td><input type="button" name="btnModificar" value="Modificar"   size="10" onClick="
                                IniciarBotonModificar();
                                modoop = 2;
                                HabilitarTodo();"/>
                        </td>

                        <td><input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
                                if (catalogo_articulos.id_articulo.value != '') {
                                    if (confirm('Esta seguro que desea Eliminar este Registro?')) {
                                        sendQueryToDelete('catalogo_articulos_eliminar.php?id_articulo=' + catalogo_articulos.id_articulo.value, 'targetDiv');
                                        LimpiarTodo();
                                    }
                                } else
                                    alert('Por favor, Buscar registro a Eliminar')"/>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="button" name="btnGuardar" value="Guardar"   size="10" onClick="

                                if (modoop == 2) {
                                    modificar();
                                }
                                /* if (modoop == 2)
                                 sendQueryToEdit('catalogo_articulos_guardar.php?modoop=2&txt_articulo=' + catalogo_articulos.txt_articulo.value + '&casilla=' + catalogo_articulos.casilla.value + '&id_cuenta=' + catalogo_articulos.id_cuenta.value + '&id_unidad=' + catalogo_articulos.id_unidad.value + '&id_articulo=' + catalogo_articulos.id_articulo.value + '&cmb_estado=' + catalogo_articulos.cmb_estado.value + '&cmb_bodega=' + catalogo_articulos.cmb_bodega.value + '&txt_estante=' + catalogo_articulos.txt_estante.value,
                                 'targetDiv');
                                 IniciarBotones();*/
                                   "/>
                        </td>
                        <td><input type="button" name="btnCancelar" value="Cancelar"   size="10" onClick="DeshabilitarTodo();
                                IniciarBotones()"/></td>
                        <td><input type="button" name="btnSalir" value="     Salir    "   size="10" onClick="change_option('btnSalir')"/></td>
                    </tr>
                </table>

                <br />
                <br />
                <br />

                <div id="targetDiv"></div>

            </form>
        </div>
    </section>

    <script type="text/javascript">


        function modificar() {


            if (document.getElementById('NombreArticulo').value.trim() == '') {
                alert('Error!, Digite el Nombre del Articulo');
                return false;
            }



            $.post('articulo_guardar.php',
                    {
                        Tipo: '2',
                        Nombre: document.getElementById('NombreArticulo').value.trim(),
                        Estante: document.getElementById('Estante').value.trim(),
                        Casilla: document.getElementById('Casilla').value.trim(),
                        Cuenta: document.getElementById('Cuenta').value,
                        Medida: document.getElementById('Medida').value,
                        Estado: document.getElementById('Estado').value,
                        Id: document.getElementById('Articulo').value,
                    },
                    function (data, status) {
                        $('#targetDiv').html(data);
                        //alert(data);
                    });


            document.getElementById('NombreArticulo').value = '';
            document.getElementById('Estante').value = '';
            document.getElementById('Casilla').value = '';
        }



        function aa()
        {
            alert('hola');
        }

    </script>
</body>
</html>
<?php
mysqli_close($cn);
?>