<?php
require_once('../conexion/conexion_usuario.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>entrada</title>

        <!--para ventana modal js-->
        <link rel="stylesheet" href="../style_tinybox.css" />
        <script type="text/javascript" src="../tinybox.js"></script>
        <!--FIN para ventana modal js-->

        <link rel="stylesheet" href="../css/style_form.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="../css/botones.css" />         
        
        <!--  select 2 -->
        <script src="../select2/jquery.js" type="text/javascript"></script>
        <script src="../select2/select2.min.js" type="text/javascript"></script>
        <link href="../select2/select2.min.css" rel="stylesheet" type="text/css"/>
        <!-- // select 2 -->


    </head>
    <body>
        <section class="container">
            <div class="login" align="center">
                <h1><?php include_once('../titulo_sistema.html'); ?></h1>
                <h2>INGRESO DE ORDENES DE COMPRA</h2>

                <form name="kardex" method="post" >

                    <table height="353" border="1">

                        <tr>
                            <td height="33">Orden de Compra</td>
                            <td>&nbsp;&nbsp;<input type="text"  id="Orden" style="width: 400px; height: 27px"   /></td>
                            <td>
                                <a href="entrada.php"><input type="button" value="Guardar"></a>
                            </td>
                        </tr>
                        <tr>
                            <td height="33">Fecha</td>
                            <td>&nbsp;&nbsp;<input type="date"  id="Fecha" style="width: 400px; height: 27px"  /></td>
                        </tr>


                        <tr>
                            <td>Agrupacion Ope.</td>
                            <td>
                                <select id="Agrupacion" style="width: 400px; height: 27px">
                                    <option value="1">Fondo General</option>
                                    <option value="2">Agroindustrial</option>
                                </select>	   
                            </td>
                        </tr>



                        <tr>
                            <td>Proveedor</td>
                            <td>
                                <select  id="Proveedor" style="width: 400px; height: 27px" class="myselect">

                                    <?php
                                    $rs2 = mysqli_query($cn, "SELECT *  FROM proveedor where Activo = 1 ");
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
                            <td >Para Uso de</td>
                            <td><input type="text" id="Uso" style="width: 400px; height: 27px">
                            </td>

                        </tr>

                        <tr>
                            <td >Factura</td>
                            <td><input type="text"  id="Factura" style="width: 400px; height: 27px">
                            </td>

                        </tr>

                        <tr>
                            <td >Articulo</td>
                            <td> 
                                <input type="hidden"  id="IdArticulo" style="width: 350px" readonly>
                                <input type="text"  id="Articulo" style="width: 400px; height: 27px" readonly>
                                <input type="hidden"  id="Existencia" style="width: 350px" readonly>
                            </td>
                            <td>
                                <a href="#" onClick="TINY.box.show({iframe: 'articulo_activo_buscar.php', boxid: 'frameless', width: 750, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                   class="enlacebotonimagen" name="btnBuscar">
                                    <img src="../css/16-Search.ico"></a>
                            </td>

                        </tr>

                        <tr>
                            <td colspan>Cantidad </td>
                            <td><input type="number"  id="Cantidad" style="width: 400px; height: 27px"></td>
                        </tr>

                        <tr>
                            <td height="36" colspan>Precio ($) </td>
                            <td><input type="number" step="0.01"  id="Precio" style="width: 400px; height: 27px"></td>
                        </tr>
                        <tr align='center'>
                            <td colspan="2">
                                <input type="button" id="btn_aceptar" value="Aceptar"> 
                                <a href="../inicio.php"> <input type="button"  value="Cancelar"> </a>
                            </td>

                        </tr>

                    </table>
                    <div id="targetDiv"  style="width: 700px;"></div>
                </form>


            </div>
        </section>
    </body>

    <script type="text/javascript">
        $(".myselect").select2();
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#btn_aceptar').click(function () {
                if (document.getElementById('Fecha').value.trim() == '') {
                    alert('Error!, elija una Fecha');
                    return false;
                }
                if (document.getElementById('Orden').value.trim() == '' || document.getElementById('Orden').value.trim() < 1) {
                    alert('Error!, debe digitar una orden de compra');
                    return false;
                }
                if (document.getElementById('Articulo').value.trim() == '') {
                    alert('Error!, debe elegir un articulo');
                    return false;
                }

                if (document.getElementById('Cantidad').value.trim() == '' || document.getElementById('Cantidad').value.trim() < 1) {
                    alert('Error!, debe digitar la cantidad');
                    return false;
                }

                if (document.getElementById('Precio').value.trim() == '' || document.getElementById('Precio').value.trim() < 0.01) {
                    alert('Error!, debe digitar el precio');
                    return false;
                }


                $.post('entrada_guardar.php',
                        {
                            Opcion: 1,
                            Fecha: document.getElementById('Fecha').value,
                            Orden: document.getElementById('Orden').value,
                            Agrupacion: document.getElementById('Agrupacion').value.trim(),
                            Proveedor: document.getElementById('Proveedor').value,
                            Uso: document.getElementById('Uso').value,
                            Factura: document.getElementById('Factura').value,
                            Articulo: document.getElementById('IdArticulo').value,
                            Cantidad: document.getElementById('Cantidad').value,
                            Existencia: document.getElementById('Existencia').value,
                            Precio: document.getElementById('Precio').value,
                        },
                        function (data, status) {
                            $('#targetDiv').html(data);
                            // alert(data);
                        });
						
						document.getElementById('Articulo').value = '';
                document.getElementById('Cantidad').value = '';
                document.getElementById('Precio').value = '';


            });
        });


        $('#Orden').change(function () {
            cargar();
            consultar();
        });

        function cargar()
        {
            $.post('entrada_cargar.php',
                    {
                        Orden: document.getElementById('Orden').value,
                    },
                    function (data, status) {
                        $('#targetDiv').html(data);
                        //alert(data);
                    });
        }

        function consultar()
        {
            $.post('entrada_consultar.php',
                    {
                        Orden: document.getElementById('Orden').value,
                    },
                    function (data, status) {
                        $('#targetDiv').html(data);
                        //alert(data);
                    });
        }


    </script>

</html>
<?php
mysqli_close($cn);
?>