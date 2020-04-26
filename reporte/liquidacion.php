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
                <h2>LIQUIDACION</h2>

                <form name="kardex" method="post" >

                    <table height="180" border="1">

                        <tr>
                            <td>Agrupacion Operacional</td>
                            <td> 
                                <select id="Agrupacion" style="width: 400px; height: 27px">
                                    <option value="0">LIQUIDACION COMPLETA</option>
                                    <option value="1">FONDO GENERAL</option>
                                    <option value="2">AGROINDUSTRIAL</option>
									<option value="3">LUBRICANTES</option>
                                </select>
                            </td> 
                        </tr>


                        <tr>
                            <td>Fecha Inicio</td>
                            <td> 
                                <input type="date"  id="FechaInicio"  style="width: 400px; height: 27px">
                            </td>                         

                        </tr>

                        <tr>
                            <td>Fecha Final</td>
                            <td> 
                                <input type="date"  id="FechaFinal"  style="width: 400px; height: 27px">
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

                if (document.getElementById('FechaInicio').value.trim() == '') {
                    alert('Error!, debe digitar la fecha inicial');
                    return false;
                }
                if (document.getElementById('FechaFinal').value.trim() == '') {
                    alert('Error!, debe digitar la fecha final');
                    return false;
                }

				if(document.getElementById('Agrupacion').value == '3')
				{
					 window.open('liquidacion_lubricantes_aceptar.php?FechaInicio=' + document.getElementById('FechaInicio').value +
                        '&FechaFinal=' + document.getElementById('FechaFinal').value+
                        '&Opcion=' + document.getElementById('Opcion').value, '_blank');
                        return false;
					
				}
				else{
                window.open('liquidacion_aceptar.php?Agrupacion=' + document.getElementById('Agrupacion').value +
                        '&FechaInicio=' + document.getElementById('FechaInicio').value +
                        '&FechaFinal=' + document.getElementById('FechaFinal').value+
                        '&Opcion=' + document.getElementById('Opcion').value, '_blank');
                        return false;
						
				}

            });
        });


    </script>

</html>
<?php
mysqli_close($cn);
?>