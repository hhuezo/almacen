<?php
require_once('../conexion/conexion_admin.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cuenta</title>

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
                <h2>NUEVA CUENTA</h2>

                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">


                    <table height="200"  align="center">
                        <tr>
                        </tr>
                        <tr>
                            <td >Codigo</td>
                            <td>&nbsp;<input type="text" id="Codigo"  style="width: 400px; height: 30px" autofocus="true" ></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td >Descripcion</td>
                            <td>&nbsp;<input type="text" id="Descripcion"  style="width: 400px; height: 30px" autofocus="true" ></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td >Alias</td>
                            <td>&nbsp;<input type="text" id="Alias"  style="width: 400px; height: 30px" autofocus="true" ></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td >Numero</td>
                            <td>&nbsp;<input type="text" id="Numero"  style="width: 400px; height: 30px" ></td>
                            <td></td>
                        </tr>

                        <tr align="center">                           
                            <td colspan="2">
                                <input type="button" class="btn btn-primary" id="btn_aceptar" value="Aceptar"/>&nbsp;&nbsp;&nbsp;
                                <a href="cuenta.php"> <input type="button" class="btn btn-warning"  value="Cancelar"/></a>

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

                if (document.getElementById('Codigo').value.trim() == '') {
                    alert('Error!, Digite el Codigo');
                    return false;
                }

                if (document.getElementById('Descripcion').value.trim() == '') {
                    alert('Error!, Digite la Descripcion');
                    return false;
                }

                if (document.getElementById('Alias').value.trim() == '') {
                    alert('Error!, Digite la Alias');
                    return false;
                }

                if (document.getElementById('Numero').value.trim() == '') {
                    alert('Error!, Digite la Numero');
                    return false;
                }

                $.post('cuenta_guardar.php',
                        {

                            Tipo: '1',
                            Codigo: document.getElementById('Codigo').value.trim(),
                            Descripcion: document.getElementById('Descripcion').value.trim(),
                            Alias: document.getElementById('Alias').value.trim(),
                            Numero: document.getElementById('Numero').value.trim(),
                          

                        },
                        function (data, status) {
                            $('#targetDiv').html(data);
                            //alert(data);
                        });


                document.getElementById('Codigo').value = '';
                document.getElementById('Descripcion').value = '';
                document.getElementById('Alias').value = '';
                document.getElementById('Numero').value = '';

            });

        });



    </script>
</html>
<?php
mysqli_close($cn);
?>