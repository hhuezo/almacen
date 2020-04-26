<html>
    <head>
        <meta charset="UTF-8">
        <title>kardex</title>
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
        <?php
        if (isset($_GET["Id"])) {

            require_once('../conexion/conexion_usuario.php');

            if ($_GET["Mov"] == 1) {

                $rs = mysqli_query($cn, "SELECT kardex.Id,
                        kardex.Fecha,
                        kardex.Orden,
                        articulo.Id as IdArticulo,
                        articulo.Descripcion AS Articulo,
                        kardex.Cantidad,
                        kardex.Precio,
                        (SELECT ifnull(SUM(Cantidad),0) from kardex k where k.Articulo = articulo.Id and kardex.Orden = k.Orden and kardex.Precio = k.Precio and k.Movimiento = 2)
                        as Existencia
                 FROM kardex kardex
                      INNER JOIN articulo articulo
                         ON (kardex.Articulo = articulo.Id) where kardex.Id = " . $_GET["Id"]);




                $row = mysqli_fetch_array($rs);
                ?>

                <section class="container">
                    <div class="login" align="center">
                        <h1><?php include_once('../titulo_sistema.html'); ?></h1>
                        <h2>MODIFICACION DE REGISTRO </h2>

                        <form name="kardex" method="post" >

                            <table height="195" border="1">

                                <tr>
                                    <td>Orden</td>
                                    <td>
                                        <input type="hidden" id="Id" value="<?php echo $row["Id"]; ?>">
                                        <input type="hidden" id="IdArticulo" value="<?php echo $row["IdArticulo"]; ?>">
                                        <input type="hidden" id="OrdenAnterior" value="<?php echo $row["Orden"]; ?>">
                                        <select  id="Orden" style="width: 400px; height: 27px" class="myselect">

                                            <?php
                                            $rs2 = mysqli_query($cn, "SELECT *  FROM orden");
                                            while ($row2 = mysqli_fetch_array($rs2)) {
                                                ?>
                                                <option value="<?php echo $row2[0]; ?>"
                                                <?php
                                                if ($row2[0] == $row["Orden"]) {
                                                    echo 'selected';
                                                }
                                                ?>
                                                        ><?php echo $row2[1]; ?></option> 
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td >Articulo</td>
                                    <td><input type="text" id="Articulo" value="<?php echo $row["Articulo"]; ?>" readonly="true" style="width: 400px; height: 27px">
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan>Cantidad </td>
                                    <td><input type="number"  id="Cantidad" value="<?php echo $row["Cantidad"]; ?>" style="width: 400px; height: 27px">
                                        <input type="hidden"  id="Existencia" value="<?php echo $row["Existencia"]; ?>" style="width: 400px; height: 27px">
                                    </td>
                                </tr>

                                <tr>
                                    <td height="36" colspan>Precio ($) </td>
                                    <td><input type="hidden"   id="PrecioAnterior" value="<?php echo $row["Precio"]; ?>" style="width: 400px; height: 27px">
                                        <input type="number" step="0.01"  id="Precio" value="<?php echo $row["Precio"]; ?>" style="width: 400px; height: 27px"></td>
                                </tr>

                                <tr align='center'>
                                    <td height="22" colspan="2">
                                        <input type="button" id="btn_aceptar" value="Modificar"> &nbsp;&nbsp;&nbsp;
                                        <input type="button" id="btn_eliminar" value="Eliminar"> &nbsp;&nbsp;&nbsp;
                                        <input type="button" id="btn_volver"  value="Cancelar"> </a>
                                    </td>

                                </tr>

                            </table>
                            <div id="targetDiv"  style="width: 700px;"></div>
                        </form>

                    </div>
                </section>

                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#btn_aceptar').click(function () {
                            var cantidad = parseInt(document.getElementById('Cantidad').value);
                            var existencia = parseInt(document.getElementById('Existencia').value);

                            if (cantidad < existencia) {
                                alert('Error!, La cantidad digitada es mayor que la existencia');
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

                            $.post('kardex_modificar_guardar.php',
                                    {
                                        Opcion: 1,
                                        Id: document.getElementById('Id').value,
                                        Orden: document.getElementById('Orden').value,
                                        OrdenAnterior: document.getElementById('OrdenAnterior').value,
                                        Articulo: document.getElementById('IdArticulo').value,
                                        Cantidad: document.getElementById('Cantidad').value,
                                        Precio: document.getElementById('Precio').value,
                                        PrecioAnterior: document.getElementById('PrecioAnterior').value,

                                    },
                                    function (data, status) {
                                        $('#targetDiv').html(data);
                                        // alert(data);
                                    });


                        });



                        $('#btn_eliminar').click(function () {
                            if (confirm('Esta seguro que desea Eliminar este Registro?')) {

                                if (document.getElementById('Id').value == '') {
                                    alert('Error!, el registro no existe');
                                    return false;
                                }

                                var existencia = parseInt(document.getElementById('Existencia').value);

                                if (existencia > 0) {
                                    alert('Error!, La existen descargo de esta orden');
                                    return false;
                                }

                                $.post('kardex_modificar_guardar.php',
                                        {
                                            Opcion: '23',
                                            Id: document.getElementById('Id').value,

                                        },
                                        function (data, status) {
                                            $('#targetDiv').html(data);
                                            //alert(data);
                                        });

                                document.getElementById('Id').value = '';

                            }

                        });


                        $('#btn_volver').click(function () {
                            window.location = "kardex.php?IdArticulo=" + document.getElementById('IdArticulo').value + "&Articulo=" + document.getElementById('Articulo').value;
                        });




                    });
                </script>


                <?php
            } else if ($_GET["Vehiculo"] > 1) {

                $rs = mysqli_query($cn, "SELECT kardex.Id,
                        kardex.Fecha,
                        kardex.Descargo,
                        descargo.Codigo,
                        kardex.Solicitud,
                        articulo.Id as IdArticulo,
                        articulo.Descripcion AS Articulo,
                        kardex.Cantidad,
                        kardex.Precio,
                        ((SELECT SUM(Cantidad) from kardex k where k.Articulo = articulo.Id and kardex.Orden = k.Orden and kardex.Precio = k.Precio and k.Movimiento = 1)-
                        (SELECT SUM(Cantidad) from kardex k where k.Articulo = articulo.Id and kardex.Orden = k.Orden and kardex.Precio = k.Precio and k.Movimiento = 2))
                        + kardex.Cantidad
                        as Existencia,
                        vehiculo.Oid,
                        vehiculo.Equipo,
                        vehiculo.Placa
                        FROM kardex kardex
                        INNER JOIN articulo articulo     ON kardex.Articulo = articulo.Id
                        INNER JOIN vehiculo ON kardex.Vehiculo = vehiculo.Id
                        INNER JOIN descargo ON kardex.Descargo = descargo.Id
                        where kardex.Id = " . $_GET["Id"]);


                $row = mysqli_fetch_array($rs);
                ?>

                <section class="container">
                    <div class="login" align="center">
                        <h1><?php include_once('../titulo_sistema.html'); ?></h1>
                        <h2>MODIFICACION DE REGISTRO </h2>

                        <form name="kardex" method="post" >

                            <table height="300" border="1">

                                <tr>
                                    <td>Descargo</td>
                                    <td>
                                        <input type="hidden" id="Id" value="<?php echo $row["Id"]; ?>">
                                        <input type="hidden" id="IdArticulo" value="<?php echo $row["IdArticulo"]; ?>">
                                        <input type="hidden" id="DescargoAnterior" value="<?php echo $row["Descargo"]; ?>">
                                        <input type="hidden"  id="IdDescargo" value="<?php echo $row["Descargo"]; ?>"  style="width: 400px; height: 27px">  
                                        <input type="text"  id="Descargo" value="<?php echo $row["Codigo"]; ?>"  style="width: 400px; height: 27px">    
                                    </td>
                                    <td>
                                        <a href="#" onClick="TINY.box.show({iframe: 'descargo_buscar.php', boxid: 'frameless', width: 750, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                           class="enlacebotonimagen" name="btnBuscar">
                                            <img src="../css/16-Search.ico"></a>
                                    </td>
                                </tr>



                                <tr>
                                    <td>Solicitud</td>
                                    <td> 
                                        <input type="hidden"  id="Oid" style="width: 350px" readonly>
                                        <input type="hidden"  id="OidAutomovil" value="<?php echo $row["Oid"]; ?>" style="width: 350px" readonly>
                                        <input type="hidden"  id="Descripcion" style="width: 350px" readonly>
                                        <input type="hidden"  id="Marca" style="width: 350px" readonly>
                                        <input type="hidden"  id="CodSolicitudAnterior" value="<?php echo $row["Solicitud"]; ?>" style="width: 400px; height: 27px" readonly> 
                                        <input type="text"  id="CodSolicitud" value="<?php echo $row["Solicitud"]; ?>" style="width: 400px; height: 27px" readonly>                              
                                    </td>
                                    <td>
                                        <a href="#" onClick="TINY.box.show({iframe: 'solicitud_buscar.php', boxid: 'frameless', width: 750, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                           class="enlacebotonimagen" name="btnBuscar">
                                            <img src="../css/16-Search.ico"></a>
                                    </td>

                                </tr>

                                <tr>
                                    <td>Equipo</td>
                                    <td><input type="text" id="Equipo" value="<?php echo $row["Equipo"]; ?>" readonly="true" style="width: 400px; height: 27px">
                                    </td>

                                </tr>

                                <tr>
                                    <td>Placa</td>
                                    <td><input type="text" id="Placa" value="<?php echo $row["Placa"]; ?>" readonly="true" style="width: 400px; height: 27px">
                                    </td>

                                </tr>


                                <tr>
                                    <td >Articulo</td>
                                    <td><input type="text" id="Articulo" value="<?php echo $row["Articulo"]; ?>" readonly="true" style="width: 400px; height: 27px">
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan>Cantidad </td>
                                    <td><input type="number"  id="Cantidad" value="<?php echo $row["Cantidad"]; ?>" style="width: 400px; height: 27px">
                                        <input type="hidden"  id="Existencia" value="<?php echo $row["Existencia"]; ?>" style="width: 400px; height: 27px">
                                    </td>
                                </tr>

                                <tr>
                                    <td height="36" colspan>Precio ($) </td>
                                    <td><input type="number" step="0.01"  id="Precio" value="<?php echo $row["Precio"]; ?>" readonly="true" style="width: 400px; height: 27px"></td>
                                </tr>

                                <tr align='center'>
                                    <td height="22" colspan="2">
                                        <input type="button" id="btn_aceptar" value="Modificar"> &nbsp;&nbsp;&nbsp;
                                        <input type="button" id="btn_eliminar" value="Eliminar"> &nbsp;&nbsp;&nbsp;
                                        <input type="button" id="btn_volver"  value="Cancelar">
                                    </td>

                                </tr>

                            </table>
                            <div id="targetDiv"  style="width: 700px;"></div>
                        </form>

                    </div>
                </section>

                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#btn_aceptar').click(function () {
                            var cantidad = parseInt(document.getElementById('Cantidad').value);
                            var existencia = parseInt(document.getElementById('Existencia').value);

                            if (cantidad > existencia) {
                                alert('Error!, La cantidad digitada es mayor que la existencia');
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

                            $.post('kardex_modificar_guardar.php',
                                    {
                                        Opcion: 2,
                                        Id: document.getElementById('Id').value,
                                        Descargo: document.getElementById('IdDescargo').value,
                                        CodigoDescargo: document.getElementById('Descargo').value,
                                        DescargoAnterior: document.getElementById('DescargoAnterior').value,
                                        CodSolicitudAnterior: document.getElementById('CodSolicitudAnterior').value,
                                        CodSolicitud: document.getElementById('CodSolicitud').value,
                                        Articulo: document.getElementById('IdArticulo').value,
                                        Cantidad: document.getElementById('Cantidad').value,
                                        Precio: document.getElementById('Precio').value,
                                        OidAutomovil: document.getElementById('OidAutomovil').value,
                                        Oid: document.getElementById('Oid').value,

                                    },
                                    function (data, status) {
                                        $('#targetDiv').html(data);
                                        //alert(data);
                                    });


                        });


                        $('#btn_eliminar').click(function () {
                            if (confirm('Esta seguro que desea Eliminar este Registro?')) {

                                if (document.getElementById('Id').value == '') {
                                    alert('Error!, el registro no existe');
                                    return false;
                                }

                                $.post('kardex_modificar_guardar.php',
                                        {
                                            Opcion: '23',
                                            Id: document.getElementById('Id').value,

                                        },
                                        function (data, status) {
                                            $('#targetDiv').html(data);
                                            //alert(data);
                                        });

                                document.getElementById('Id').value = '';

                            }

                        });

                        $('#btn_volver').click(function () {
                            window.location = "kardex.php?IdArticulo=" + document.getElementById('IdArticulo').value + "&Articulo=" + document.getElementById('Articulo').value;
                        });



                    });
                </script>




                <?php
            } else {
                $rs = mysqli_query($cn, "SELECT kardex.Id,
                        kardex.Fecha,
                        kardex.Descargo,
                        descargo.Oficina,
                        descargo.Codigo,                      
                        articulo.Id as IdArticulo,
                        articulo.Descripcion AS Articulo,
                        kardex.Cantidad,
                        kardex.Precio,
                        ((SELECT SUM(Cantidad) from kardex k where k.Articulo = articulo.Id and kardex.Orden = k.Orden and kardex.Precio = k.Precio and k.Movimiento = 1)-
                        (SELECT SUM(Cantidad) from kardex k where k.Articulo = articulo.Id and kardex.Orden = k.Orden and kardex.Precio = k.Precio and k.Movimiento = 2))
                        + kardex.Cantidad
                        as Existencia
                        FROM kardex kardex
                        INNER JOIN articulo articulo     ON kardex.Articulo = articulo.Id
                        INNER JOIN descargo ON kardex.Descargo = descargo.Id
                        where kardex.Id = " . $_GET["Id"]);


                $row = mysqli_fetch_array($rs);
                ?>



                <section class="container">
                    <div class="login" align="center">
                        <h1><?php include_once('../titulo_sistema.html'); ?></h1>
                        <h2>MODIFICACION DE REGISTRO </h2>

                        <form name="kardex" method="post" >

                            <table height="200" border="1">

                                <tr>
                                    <td>Descargo</td>
                                    <td>
                                        <input type="hidden" id="Id" value="<?php echo $row["Id"]; ?>">
                                        <input type="hidden" id="IdArticulo" value="<?php echo $row["IdArticulo"]; ?>">
                                        <input type="hidden" id="DescargoAnterior" value="<?php echo $row["Descargo"]; ?>">
                                        <input type="hidden"  id="IdDescargo" value="<?php echo $row["Descargo"]; ?>"  style="width: 400px; height: 27px">  
                                        <input type="text"  id="Descargo" value="<?php echo $row["Codigo"]; ?>"  style="width: 400px; height: 27px">    
                                    </td>
                                    <td>
                                        <a href="#" onClick="TINY.box.show({iframe: 'descargo_buscar.php', boxid: 'frameless', width: 750, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                           class="enlacebotonimagen" name="btnBuscar">
                                            <img src="../css/16-Search.ico"></a>
                                    </td>
                                </tr>


                                <tr>
                                    <td >Articulo</td>
                                    <td><input type="text" id="Articulo" value="<?php echo $row["Articulo"]; ?>" readonly="true" style="width: 400px; height: 27px">
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan>Cantidad </td>
                                    <td><input type="number"  id="Cantidad" value="<?php echo $row["Cantidad"]; ?>" style="width: 400px; height: 27px">
                                        <input type="hidden"  id="Existencia" value="<?php echo $row["Existencia"]; ?>" style="width: 400px; height: 27px">
                                    </td>
                                </tr>

                                <tr>
                                    <td height="36" colspan>Precio ($) </td>
                                    <td><input type="number" step="0.01"  id="Precio" value="<?php echo $row["Precio"]; ?>" readonly="true" style="width: 400px; height: 27px"></td>
                                </tr>

                                <tr align='center'>
                                    <td height="22" colspan="2">
                                        <input type="button" id="btn_aceptar" value="Modificar"> &nbsp;&nbsp;&nbsp;
                                        <input type="button" id="btn_eliminar" value="Eliminar"> &nbsp;&nbsp;&nbsp;
                                       <input type="button" id="btn_volver"  value="Cancelar"> 
                                    </td>

                                </tr>

                            </table>
                            <div id="targetDiv"  style="width: 700px;"></div>
                        </form>

                    </div>
                </section>

                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#btn_aceptar').click(function () {
                            var cantidad = parseInt(document.getElementById('Cantidad').value);
                            var existencia = parseInt(document.getElementById('Existencia').value);

                            if (cantidad > existencia) {
                                alert('Error!, La cantidad digitada es mayor que la existencia');
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

                            $.post('kardex_modificar_guardar.php',
                                    {
                                        Opcion: 3,
                                        Id: document.getElementById('Id').value,
                                        Descargo: document.getElementById('IdDescargo').value,
                                        CodigoDescargo: document.getElementById('Descargo').value,
                                        DescargoAnterior: document.getElementById('DescargoAnterior').value,
                                        Articulo: document.getElementById('IdArticulo').value,
                                        Cantidad: document.getElementById('Cantidad').value,
                                        Precio: document.getElementById('Precio').value,

                                    },
                                    function (data, status) {
                                        $('#targetDiv').html(data);
                                        alert(data);
                                    });


                        });


                        $('#btn_eliminar').click(function () {
                            if (confirm('Esta seguro que desea Eliminar este Registro?')) {

                                if (document.getElementById('Id').value == '') {
                                    alert('Error!, el registro no existe');
                                    return false;
                                }

                                $.post('kardex_modificar_guardar.php',
                                        {
                                            Opcion: '32',
                                            Id: document.getElementById('Id').value,

                                        },
                                        function (data, status) {
                                            $('#targetDiv').html(data);
                                            //alert(data);
                                        });

                                document.getElementById('Id').value = '';

                            }

                        });
                        
                        
                          $('#btn_volver').click(function () {
                            window.location = "kardex.php?IdArticulo=" + document.getElementById('IdArticulo').value + "&Articulo=" + document.getElementById('Articulo').value;
                        });



                    });
                </script>


                <?php
            }
        }
        ?>
    </body>

    <script type="text/javascript">
        $(".myselect").select2();
    </script>
</html>
