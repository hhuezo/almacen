<?php
require_once('../conexion/conexion_usuario.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>liquidacion</title>

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
                <h2>INVENTARIO</h2>

                <form name="kardex" method="post" >

                    <table height="170" border="1">

                        <tr>
                            <td>Vehiculo</td>
                            <td> 
                                <select  id="Vehiculo" style="width: 400px; height: 27px" class="myselect">
                                    <?php
                                    $rs2 = mysqli_query($cn, "SELECT *  FROM vehiculo where Id > 1");
                                    while ($row2 = mysqli_fetch_array($rs2)) {
                                        ?>
                                        <option value="<?php echo $row2[0]; ?>">P-<?php echo $row2["Placa"]; ?> EQ-<?php echo $row2["Equipo"]; ?>  </option> 
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td> 
                        </tr>


                        <tr>
                            <td>FechaInicio Inicio</td>
                            <td> 
                                <input type="date"  id="FechaInicio"  style="width: 400px; height: 27px">
                            </td>                         

                        </tr>

                        <tr>
                            <td>FechaInicio Final</td>
                            <td> 
                                <input type="date"  id="FechaFinal"  style="width: 400px; height: 27px">
                            </td>                         

                        </tr>


                        <tr>
                            <td>Opcion</td>
                            <td> 
                                <select id="Opcion" style="width: 400px; height: 27px">
                                    <option value="2">CONSULTAR</option>
                                    <option value="1">EXPORTAR</option>

                                </select>
                            </td>                         

                        </tr>

                        <tr align='center'>
                            <td height="22" colspan="2">
                                <input type="button" id="btn_aceptar" value="Aceptar"> 
                                <a href="../inicio.php"> <input type="button"  value="Cancelar"> </a>
                            </td>

                        </tr>

                    </table>
                    <div id="targetDiv"></div>
                </form>


            </div>
        </section>
    </body>




    <script type="text/javascript">
        $(document).ready(function () {

            $('#btn_aceptar').click(function () {

                if (document.getElementById('FechaInicio').value.trim() == '') {
                    alert('Error!, debe digitar la fecha');
                    return false;
                }
                if (document.getElementById('FechaFinal').value.trim() == '') {
                    alert('Error!, debe digitar la fecha');
                    return false;
                }

                $.get('vehiculo_aceptar.php',
                        {
                            Vehiculo: document.getElementById('Vehiculo').value,
                            Opcion: document.getElementById('Opcion').value,
                            FechaInicio: document.getElementById('FechaInicio').value,
                            FechaFinal: document.getElementById('FechaFinal').value,
                        },
                        function (data, status) {
                            $('#targetDiv').html(data);
                            //alert(data);
                        });

                // alert(document.getElementById('Opcion').value);


                /*  window.open('vehiculo_aceptar.php?Vehiculo=' + document.getElementById('Vehiculo').value +
                 '&Opcion=' + document.getElementById('Opcion').value +
                 '&FechaInicio=' + document.getElementById('FechaInicio').value +
                 '&FechaFinal=' + document.getElementById('FechaFinal').value, '_blank');
                 return false;*/



            });
        });


    </script>

    <script type="text/javascript">
        $(".myselect").select2();
    </script>

</html>
<?php
mysqli_close($cn);
?>