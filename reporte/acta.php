<?php
$date = date('Y-m-j H:i:s');
$newDate = strtotime('-1 hour', strtotime($date));
$fecha = date('Y-m-d', $newDate);
$hora = date('H:i:s', $newDate);
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
                <h2>ACTA DE RECEPCION</h2>

                <form name="kardex" method="post" >

                    <table height="350" border="1">

                        <tr>
                            <td>Orden</td>
                            <td> 
                                &nbsp;  <input type="number"  id="Orden" autofocus="true" style="width: 400px; height: 27px">
                            </td> 
                        </tr>
                        <tr>
                            <td>Acta</td>
                            <td> 
                                <input type="text"  id="Acta" readonly="true" style="width: 400px; height: 27px">
                            </td> 
                        </tr>

                        <tr>
                            <td>Fecha</td>
                            <td> 
                                &nbsp; <input type="date" value="<?php echo $fecha; ?>"  id="Fecha"  style="width: 400px; height: 27px">
                            </td>  
                        </tr>

                        <tr>
                            <td>Hora</td>
                            <td> 
                                &nbsp;<input type="time" id="hora" value="<?php echo $hora; ?>"  min="07:30:00"  style="width: 400px; height: 27px">
                            </td>  
                        </tr>
                        <tr>
                            <td>Factura</td>
                            <td> 
                                <input type="text"  id="Factura"  style="width: 400px; height: 27px">
                            </td>                        
                        </tr>

                        <tr>
                            <td>Representante</td>
                            <td> 
                                <input type="text"  id="Representante"  style="width: 400px; height: 27px">
                            </td> 
                        </tr>

                        <tr>
                            <td>Recibe</td>
                            <td> 
                                <input type="text"  id="Recibe"  style="width: 400px; height: 27px">
                            </td>  
                        </tr>

                        <tr>
                            <td>Cargo</td>
                            <td> 
                                <input type="text"  id="Cargo"  style="width: 400px; height: 27px">
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


            $('#Orden').change(function () {
                consultar();
            });



            function consultar()
            {
                //alert(document.getElementById('Orden').value);
                $.post('acta_validar.php',
                        {
                            Orden: document.getElementById('Orden').value,
                        },
                        function (data, status) {
                            $('#targetDiv').html(data);
                            //alert(data);
                        });
            }


        });




    </script>

</html>
