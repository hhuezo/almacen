<?php
require_once('../conexion/conexion_admin.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Unidad de Medida</title>

        <!-- data tables -->        
        <link href="../select2/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- // data tables -->



        <link rel="stylesheet" href="../css/style_form.css" type="text/css" />

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
                <h2>NUEVA UNIDAD DE MEDIDA</h2>

                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">


                    <table height="200"  align="center">
                        <tr>
                        </tr>
                         <tr>
                            <td >Medida</td>
                            <td>&nbsp;<input type="text" id="Medida"  style="width: 400px; height: 30px" autofocus="true" ></td>
                            <td></td>
                        </tr>

                        <tr align="center">                           
                            <td colspan="2">
                                <input type="button" class="btn btn-primary" id="btn_aceptar" value="Aceptar"/>&nbsp;&nbsp;&nbsp;
                                <a href="medida.php"> <input type="button" class="btn btn-warning"  value="Cancelar"/></a>

                            </td>
                            <td></td>
                        </tr>


                    </table>


                    <div id="targetDiv">

                    </div>

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

                if (document.getElementById('Medida').value.trim() == '') {
                    alert('Error!, Digite la Medida');
                    return false;
                }

                
                $.post('medida_guardar.php',
                        {

                            Tipo: '1',
                            Medida: document.getElementById('Medida').value.trim(),
                          
                        },
                        function (data, status) {
                            $('#targetDiv').html(data);
                            //alert(data);
                        });


                document.getElementById('Medida').value = '';
              

            });

        });



    </script>
</html>
<?php
mysqli_close($cn);

?>