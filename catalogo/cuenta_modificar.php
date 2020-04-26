<?php
if (isset($_GET["Id"])) {
    require_once('../conexion/conexion_admin.php');


    $rs = mysqli_query($cn, "SELECT * FROM cuenta  where Id = " . $_GET["Id"]);

    $row = mysqli_fetch_array($rs);
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Cuentas</title>

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
                            <input type="hidden" id="Id" value="<?php echo $row["Id"] ?>"  style="width: 400px; height: 30px">
                            </tr>
                            <tr>
                                <td >Codigo</td>
                                <td>&nbsp;<input type="text" id="Codigo" value="<?php echo $row["Codigo"] ?>"  style="width: 400px; height: 30px"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td >Descripcion</td>
                                <td>&nbsp;<input type="text" id="Descripcion" value="<?php echo $row["Descripcion"] ?>" style="width: 400px; height: 30px" ></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td >Alias</td>
                                <td>&nbsp;<input type="text" id="Alias" value="<?php echo $row["Alias"] ?>" style="width: 400px; height: 30px" ></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td >Numero</td>
                                <td>&nbsp;<input type="text" id="Numero" value="<?php echo $row["Numero"] ?>" style="width: 400px; height: 30px" ></td>
                                <td></td>
                            </tr>

                           <tr>
                                <td>Activo</td>
                                <td>&nbsp;<input type="checkbox" id="Activo" 
                                    <?php
                                    if ($row["Activo"] == '1') {
                                        echo 'checked';
                                    }
                                    ?>></td>
                                <td></td>
                            </tr>

                            <tr align="center">                           
                                <td colspan="2">
                                    <input type="button" class="btn btn-success" id="btn_aceptar" value="Aceptar"/>&nbsp;&nbsp;&nbsp;
                                    <input type="button" class="btn btn-danger" id="btn_eliminar" value="Eliminar"/>&nbsp;&nbsp;&nbsp;
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
                consultar();

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
                        alert('Error!, Digite el Alias');
                        return false;
                    }
                    
                    if (document.getElementById('Numero').value.trim() == '') {
                        alert('Error!, Digite la Numero');
                        return false;
                    }
                    if (document.getElementById('Activo').checked == true) {
                        document.getElementById('Activo').value = '1'
                    }
                     if (document.getElementById('Activo').checked == false) {
                        document.getElementById('Activo').value = '0'
                     }
                    

                    
                    $.post('cuenta_guardar.php',
                            {

                                Tipo: '2',
                                Codigo: document.getElementById('Codigo').value.trim(),
                                Descripcion: document.getElementById('Descripcion').value.trim(),
                                Alias: document.getElementById('Alias').value,
                                Numero: document.getElementById('Numero').value,
                                Activo: document.getElementById('Activo').value,
                                Id: document.getElementById('Id').value,
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
                        $.post('cuenta_guardar.php',
                                {
                                    Tipo: '3',
                                    Id: document.getElementById('Id').value,

                                },
                                function (data, status) {
                                    $('#targetDiv').html(data);
                                    //alert(data);
                                });



                        document.getElementById('Usuario').value = '';
                        document.getElementById('Descripcion').value = '';
                        document.getElementById('Alias').value = '';
                        document.getElementById('Numero').value = '';
                        document.getElementById('Id').value = '';

                    }
                });


                $('#btn_agregar').click(function () {

                    if (confirm('Esta seguro que desea agregar este Registro?')) {


                        $.post('usuario_oficina_agregar.php',
                                {
                                    Tipo: '1',
                                    Oficina: document.getElementById('Oficina').value,
                                    Id: document.getElementById('Id').value,

                                },
                                function (data, status) {
                                    $('#targetDiv2').html(data);
                                    //alert(data);
                                });

                        alert('Registro agregado');
                        consultar();
                    }
                });


                function consultar()
                {

                    $.post('oficina_consultar.php',
                            {
                                Id: document.getElementById('Id').value,

                            },
                            function (data, status) {
                                $('#targetDiv2').html(data);
                                //alert(data);
                            });
                }

            });



        </script>
    </html>
    <?php
    mysqli_close($cn);
    sqlsrv_close();
}
?>