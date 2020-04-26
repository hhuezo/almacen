<?php
   session_start();
    include('conexion/conexion.php');

    if (!isset($_SESSION['username'])){
        header("Location: index.php");
       exit();
    }  



if (isset($_GET['orden_compra_editar'])) {
    $orden_compra_editar = $_GET['orden_compra_editar'];

    $rs = mysql_query("select
		o.fecha,
		o.orden_compra,
		a.id_agru,
		a.nom_agru,
		p.id_prov,
		p.nom_prov,
		o.para_uso
		from orden_compra o
		inner join proveedor p on o.id_prov = p.id_prov
		left join agrupacion_operacional a on o.id_agru = a.id_agru
		where orden_compra = $orden_compra_editar");

    $row_orden = mysql_fetch_array($rs);

    $fecha = "$row_orden[fecha]";
    $id_proveedor = "$row_orden[id_prov]";
    $id_agru = "$row_orden[id_agru]";
    $nom_agru = "$row_orden[nom_agru]";
    $uso = "$row_orden[para_uso]";
    $nom_proveedor = "$row_orden[nom_prov]";
    $orden = "$row_orden[orden_compra]";
} else {
    $fecha = "";
    $id_proveedor = "";
    $id_agru = "";
    $nom_agru = "";
    $uso = "";
    $nom_proveedor = "";
    $orden = "";
    $orden_compra_editar = "";
}

mysql_close();
?>

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
        <link rel="stylesheet" type="text/css" href="css/botones.css" />

        <!-- script para calendario -->
        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="css/botones.css" />
        <script src="js/jquery-1.4.1.js" type="text/javascript"></script>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui.min.js" type="text/javascript"></script>

        <script language="javascript">
            function change_option(parametro) {
                switch (parametro) {
                    case 'btnCancelar':
                        document.kardex.action = "inicio.php";
                        break;
                }
                document.kardex.submit();
            }


            function consultar() {
                //alert(kardex.orden_compra_editar.value);
                buscarAceptar('entrada_consultar.php?orden_compra=' + kardex.orden_compra_editar.value, 'targetDiv');
            }
            function LimpiarTodo() {
                var i;
                for (i = 0; i < document.forms.kardex.elements.length; i++) {
                    if (document.forms.kardex.elements[i].type == "text") {
                        document.forms.kardex.elements[i].value = '';
                    }
                    if (document.forms.kardex.elements[i].type == "checkbox") {
                        document.forms.kardex.elements[i].value = 0;
                    }
                }
            }


        </script>

    </head>
    <body onLoad="consultar();">
        <section class="container">
            <div class="login" align="center">

                <h1><?php include_once('titulo_sistema.html'); ?></h1>
                <h2>INGRESO DE ORDENES DE COMPRA</h2>

                <form name="kardex" method="post" >
                    <input type="hidden" name="orden_compra_editar" value="<?php echo "$orden_compra_editar"; ?>">

                    <table height="310"  align="center">
                        <tr>
                        </tr>
                        <tr>
                            <td >Fecha</td>
                            <td>&nbsp;<input type="date" name="fecha" id="fecha"  style="width: 350px" value="<?php echo $fecha; ?>"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Orden de Compra</td>
                            <td>&nbsp;<input type="number" name="orden_compra" style="width: 350px" value="<?php echo $orden; ?>"  onBlur="sendQueryToSelect('ajax/validar_existe_oden_compra.php?orden_compra=' + kardex.orden_compra.value, 'targetDiv')" ></td>
                            <td align='center'>
                                <input type="button" name="btnGuardar" value="Guardar" 
                                       onClick="sendQueryToEdit('entrada_guardar.php?orden_compra=' + kardex.orden_compra.value, 'targetDiv'); LimpiarTodo(); kardex.fecha.value = '';kardex.orden_compra.value = '';">
                            </td>
                        </tr>
                        <tr>
                            <td>Agrupacion Ope.</td>
                            <td>
                                <select name="id_agru" style="width: 350px">
                                    <option value="1">Fondo General</option>
                                    <option value="2">Agroindustrial</option>
                                </select>	   
                            </td>
                        </tr>
                        <tr>
                            <td >Proveedor</td>
                            <td><input type="hidden" name="id_proveedor" id="id_proveedor" style="width: 350px" value="<?php echo $id_proveedor; ?>" readonly> 	     
                                <input type="text" name="txt_proveedor" id="txt_proveedor" style="width: 350px"  value="<?php echo $nom_proveedor; ?>" readonly>
                            </td>
                            <td align='center'>
                                <a href="#" onClick="TINY.box.show({iframe: 'catalogo_proveedores_buscar.php', boxid: 'frameless', width: 750, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                   class="enlacebotonimagen" name="btnBuscar"><img src="css/16-Search.ico"></a>
                            </td>
                        </tr>
                        <tr>
                            <td >Para Uso de</td>
                            <td><input type="text" name="uso" id="uso" style="width: 350px" value="<?php echo $uso; ?>">
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td >Factura</td>
                            <td><input type="text" name="txt_factura" id="txt_factura" style="width: 350px">
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td >Articulo</td>
                            <td> 
                                <input type="hidden" name="id_articulo" id="id_articulo" style="width: 350px" readonly>
                                <input type="text" name="txt_articulo" id="txt_articulo" style="width: 350px" readonly>
                                <input type="hidden" name="txt_existencia" id="txt_existencia" style="width: 350px" readonly>
                            </td>
                            <td align='center'>
                                <a href="#" onClick="TINY.box.show({iframe: 'articulo_activo_buscar.php', boxid: 'frameless', width: 750, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                   class="enlacebotonimagen" name="btnBuscar">
                                    <img src="css/16-Search.ico"></a>
                            </td>

                        </tr>
                        <tr>
                            <td colspan>Cantidad </td>
                            <td>&nbsp;<input type="number" name="cantidad" id="cantidad" style="width: 350px"></td>
                            <td></td>
                        </tr>

                        <tr>

                            <td colspan>Precio ($) </td>
                            <td>&nbsp;<input type="number" step="0.01"  name="precio" id="precio" style="width: 350px"></td>
                            <td></td>
                        </tr>

                        <tr align='center'>
                            <td colspan="2">

                                <input type="button" name="aceptarbtn" value="Aceptar" onClick="
                                        if (kardex.fecha.value == '') {
                                            alert('Por favor, No dejar la fecha en blanco')} else if (kardex.orden_compra.value == '') {
                                            alert('Por favor, No dejar la orden de compra en blanco')
                                        } else if (kardex.txt_proveedor.value == '') {
                                            alert('Por favor, No dejar el proveedor en blanco')
                                        } else if (kardex.uso.value == '') {
                                            alert('Por favor, No dejar el capo para uso de en blanco')
                                        } else if (kardex.txt_articulo.value == '') {
                                            alert('Por favor, No dejar el articulo en blanco')
                                        } else if (kardex.cantidad.value == '') {
                                            alert('Por favor, No dejar la cantidad en blanco')
                                        } else if (kardex.precio.value == '') {
                                            alert('Por favor, No dejar el precio en blanco')
                                        } else {
                                            sendQueryToSelect('entrada_guardar.php?id_articulo=' + kardex.id_articulo.value +
                                                    '&cantidad=' + kardex.cantidad.value +
                                                    '&precio=' + kardex.precio.value +
                                                    '&fecha=' + kardex.fecha.value +
                                                    '&orden_compra=' + kardex.orden_compra.value +
                                                    '&id_agru=' + kardex.id_agru.value +
                                                    '&id_proveedor=' + kardex.id_proveedor.value +
                                                    '&txt_factura=' + kardex.txt_factura.value +
                                                    '&uso=' + kardex.uso.value, 'targetDiv');
                                            kardex.txt_articulo.value = '';
                                            kardex.cantidad.value = '';
                                            kardex.precio.value = '';
                                            kardex.txt_articulo.focus();
                                        }" >
                                <input type="button" name="btnCancelar" value="Cancelar" onClick="change_option('btnCancelar')">

                            </td>
                        </tr>

                    </table>
                    <div id="targetDiv"></div>
                </form>

            </div>
        </section>

    </body>
</html>
