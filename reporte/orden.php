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


        <script src="../select2/jquery.js" type="text/javascript"></script>
        
        

    </head>
    <body>
        <section class="container">
            <div class="login" align="center">
                <h1><?php include_once('../titulo_sistema.html'); ?></h1>
                <h2>BUSQUEDA DE ORDEN DE COMPRA</h2>

                <form name="kardex" method="post" >

                    <table height="60" border="1">

                        <tr>
                            <td>Orden</td>
                            <td> 
                                <input type="text"  id="Orden" autofocus="true" style="width: 400px; height: 27px">
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

                if (document.getElementById('Orden').value.trim() == '') {
                    alert('Error!, debe elegir un orden');
                    return false;
                }
                
                $.post('orden_aceptar.php',
                        {
                            Orden: document.getElementById('Orden').value,
                        },
                        function (data, status) {
                            $('#targetDiv').html(data);
                             //alert(data);
                        });


            });
        });


    </script>

</html>
<?php
mysqli_close($cn);
?>