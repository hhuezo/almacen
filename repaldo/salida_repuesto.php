<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include('conexion/Conexion.php');

if (isset($_GET['descargo_editar'])) {
    $descargo_editar = $_GET['descargo_editar'];

    $rs = mysql_query("select fecha from descargo where descargo = $descargo_editar");
    echo mysql_num_rows($rs);
    $row = mysql_fetch_array($rs);
    $fecha = $row[0];
} else {
    $fecha = "";
    $descargo = "";
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Almacen</title>
        <link rel="stylesheet" href="style_tinybox.css" />
        <script type="text/javascript" src="tinybox.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />
        <script src="js/jquery-1.4.1.js" type="text/javascript"></script>
    </head>


    <body>

        <section class="container">
            <div class="login" align="center">

                <h1><?php include_once('titulo_sistema.html'); ?></h1>
                <h2>SALIDA DE REPUESTOS</h2>

                <form name="kardex" method="post">
                    <table height="333" >
                        <tr>
                            <td>Descargo</td>
                            <td colspan="2">
                                &nbsp;<input type="text" id="Descargo" style="width: 350px" value="<?php echo $descargo_editar; ?>" autofocus="true"> 
                            </td>                            
                        </tr>
                        <tr>
                            <td>Fecha</td>
                            <td>&nbsp;<input type="date"  id="Fecha" style="width: 350px" value="<?php echo $fecha; ?>"></td>   
                            <td align='center'><input type="button" id="btn_guardar" value="Guardar"></td>
                        </tr>
                        <tr>
                            <td>Numero Solicitud</td>
                            <td>                              
                                <input type="hidden" id="Oid" readonly size="50">		
                                <input type="text"  readonly style="width: 350px" id="Solicitud">
                            </td>
                            <td align="center"> 
                                <a href="#" onClick="TINY.box.show({iframe: 'buscar_solicitud.php', boxid: 'frameless', width: 750, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                   class="enlacebotonimagen" name="btnBuscar"><img src="css/16-Search.ico"></a>                            
                            </td>
                        </tr>                        
                        <tr>
                            <td>Equipo</td>
                        <input type="hidden"  id="Vehiculo" readonly="true" style="width: 350px" />
                        <td colspan="2"><input type="text"  id="Equipo" readonly="true" style="width: 350px" ></td>                               
                        </tr>
                        <tr>
                            <td>Placa</td>
                            <td colspan="2"><input type="text"  id="Placa" readonly="true" style="width: 350px" ></td>    
                        </tr>
                        <tr>
                            <td>Existencia</td>
                            <td colspan="2"><input type="number"  id="Existencia" readonly="true" style="width: 350px" ></td>    
                        </tr>

                        <tr>   
                            <td >Articulo</td>
                            <td> 
                                <input type="hidden"  id="Articulo" size="50" readonly>
                                <input type="text"  id="Nombre" style="width: 350px" readonly>                            </td>
                            <td align="center"> 			
                                <a href="#" onClick="TINY.box.show({iframe: 'repuesto_buscar.php', boxid: 'frameless', width: 750, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                   class="enlacebotonimagen" name="btnBuscar">
                                    <img src="css/16-Search.ico"></a>                            </td>   
                        </tr>

                        <tr>
                            <td>Cantidad</td>
                            <td colspan="2">&nbsp;<input type="number"  id="Cantidad" style="width: 350px" ></td>    
                        </tr>

                        <tr>
                            <td colspan="3" align="center">
                                <input type="button" id="btn_aceptar" class="btn-info" value="Aceptar"/>&nbsp;&nbsp;&nbsp;
                                <a href="inicio.php"><input type="button" class="btn-info" value="Cancelar"/></a>                                
                            </td>

                        </tr>

                    </table>



                </form>
                <div id="targetDiv"></div>
            </div>

        </section>

        <script type="text/javascript">
            $(document).ready(function () {
                consultar() ;
                $("#btn_aceptar").click(function () {
                    if (document.getElementById('Descargo').value == '' || document.getElementById('Descargo').value < 0) {
                        alert("Por favor digitar un descargo");
                        return false;
                    }
                    if (document.getElementById('Fecha').value == '') {
                        alert("Por favor digitar la fecha");
                        return false;
                    }
                    if (document.getElementById('Solicitud').value == '') {
                        alert("Por favor digitar una solicitud");
                        return false;
                    }
                    if (document.getElementById('Nombre').value == '') {
                        alert("Por favor digitar un articulo");
                        return false;
                    }
                    if (document.getElementById('Cantidad').value < 1 || document.getElementById('Cantidad').value == '') {
                        alert("Por favor digitar una cantidad valida");
                        return false;
                    }
                    /*if (document.getElementById('Cantidad').value > document.getElementById('Existencia').value) {
                        alert("Error, la cantidad digitada es mayor que la existencia");
                        return false;
                    }*/

                    $.post('salida_repuesto_guardar.php',
                            {
                                Operacion: '1',
                                Fecha: document.getElementById('Fecha').value,
                                Descargo: document.getElementById('Descargo').value,
                                Solicitud: document.getElementById('Solicitud').value,
                                Vehiculo: document.getElementById('Vehiculo').value,
                                Articulo: document.getElementById('Articulo').value,
                                Cantidad: document.getElementById('Cantidad').value,
                                Oid: document.getElementById('Oid').value,
                            },
                            function (data, status) {
                                $('#targetDiv').html(data);
                                //alert(data);
                            });



                    document.getElementById('Nombre').value = '';
                    document.getElementById('Articulo').value = '';
                    document.getElementById('Cantidad').value = '0';
                    document.getElementById('Existencia').value = '';

                    //alert('Registro ingresado correctamente');
                    consultar();


                });


                $("#Descargo").blur(function () {
                    consultar();
                });

            });

            function consultar() {
                $.post('salida_repuesto_consultar.php',
                        {
                            descargo_editar: document.getElementById('Descargo').value,
                        },
                        function (data, status) {
                            $('#targetDiv').html(data);
                            //alert(data);
                        });
            }

        </script>

    </body>
</html>
