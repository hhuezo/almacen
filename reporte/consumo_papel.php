<?php
require_once('../conexion/conexion_usuario.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Consumo de papel</title>

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
                <h2>BUSQUEDA DE DESCARGO</h2>

                <form name="kardex" method="post" >

                    <table height="140" border="1">

                        <tr>
                            <td>Descargo</td>
                            <td> 
                                <input type="number"  id="Descargo" autofocus="true" style="width: 400px; height: 27px">
                            </td>                         

                        </tr>

                        <?php
                        if ($_SESSION["Rol"] < 3) {
                            ?>

                            <tr>
                                <td>Recibe</td>
                                <td> 
                                    <input type="text"  id="Recibe"  style="width: 400px; height: 27px" onBlur="this.value = this.value.toUpperCase();">
                                </td>                         

                            </tr>

                            <tr>
                                <td>Cargo</td>
                                <td>
                                    <select id="Cargo" style="width: 400px; height: 30px" class="myselect">
                                        <?php
                                        $rs2 = mysqli_query($cn, "SELECT * FROM cargo order by Id");
                                        while ($row2 = mysqli_fetch_array($rs2)) {
                                            ?>
                                            <option value="<?php echo $row2[1]; ?>"><?php echo $row2[1]; ?></option> 
                                            <?php
                                        }
                                        ?>
                                    </select>	   
                                </td>
                            </tr>                          
                            <?php
                        }
                        ?>

                        <tr align='center'>
                            <td height="22" colspan="2">
                                <input type="button" id="btn_aceptar" value="Aceptar">
                                <?php
                                if ($_SESSION["Rol"] < 3) {
                                    ?>

                                    <input type="button" id="btn_imprimir" value="Imprimir"> 
                                    <?php
                                }
                                ?>	

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
        $(".myselect").select2();
    </script>


    <script type="text/javascript">
        $(document).ready(function () {

            $('#btn_aceptar').click(function () {

                if (document.getElementById('Descargo').value.trim() == '') {
                    alert('Error!, debe elegir un descargo');
                    return false;
                }

                $.post('descargo_aceptar.php',
                        {
                            Descargo: document.getElementById('Descargo').value,
                        },
                        function (data, status) {
                            $('#targetDiv').html(data);
                            //alert(data);
                        });


            });


            $('#btn_imprimir').click(function () {

                if (document.getElementById('Descargo').value.trim() == '') {
                    alert('Error!, debe elegir un descargo');
                    return false;
                }
                if (document.getElementById('Recibe').value.trim() == '') {
                    alert('Error!, digite quien recibe');
                    return false;
                }

                if (document.getElementById('Cargo').value.trim() == '') {
                    alert('Error!, digite el cargo');
                    return false;
                }

                window.open('descargo_imprimir.php?Descargo=' + document.getElementById('Descargo').value +
                        '&Recibe=' + document.getElementById('Recibe').value +
                        '&Cargo=' + document.getElementById('Cargo').value,
                        '_blank');
                return false;


            });


        });


    </script>

</html>
<?php
mysqli_close($cn);
?>