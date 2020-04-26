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


        <script src="../select2/jquery.js" type="text/javascript"></script>



    </head>
    <body>
        <section class="container">
            <div class="login" align="center">
                <h1><?php include_once('../titulo_sistema.html'); ?></h1>
                <h2>INVENTARIO</h2>

                <form name="kardex" method="post" >

                    <table height="150" border="1">

                        <tr>
                            <td>CUENTA CONTABLE</td>
                            <td> 
                                <select  id="Cuenta" style="width: 400px; height: 27px" class="myselect">
                                    <option value="0">NO APLICA</option>
                                    <?php
                                    $rs2 = mysqli_query($cn, "SELECT *  FROM cuenta where Activo = 1 ");
                                    while ($row2 = mysqli_fetch_array($rs2)) {
                                        ?>
                                        <option value="<?php echo $row2[0]; ?>"><?php echo $row2[2]; ?></option> 
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td> 
                        </tr>


                        <tr>
                            <td>Fecha</td>
                            <td> 
                                <input type="date"  id="Fecha"  style="width: 400px; height: 27px">
                            </td>                         

                        </tr>

                        <tr>
                            <td>Opcion</td>
                            <td> 
                                <select id="Opcion" style="width: 400px; height: 27px">
                                    <option value="1">EXPORTAR</option>
                                    <option value="2">CONSULTAR</option>
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

                if (document.getElementById('Fecha').value.trim() == '') {
                    alert('Error!, debe digitar la fecha');
                    return false;
                }
             

                window.open('inventario_aceptar.php?Cuenta=' + document.getElementById('Cuenta').value +
                        '&Fecha=' + document.getElementById('Fecha').value +
                        '&Opcion=' + document.getElementById('Opcion').value, '_blank');
                return false;

            });
        });


    </script>

</html>
<?php
mysqli_close($cn);
?>