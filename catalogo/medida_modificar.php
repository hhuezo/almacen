<?php
if (isset($_GET["Id"])) {
    require_once('../conexion/conexion_admin.php');


    $rs = mysqli_query($cn, "SELECT * FROM medida  where Id = " . $_GET["Id"]);

    $row = mysqli_fetch_array($rs);
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
                    <h2>NUEVA MEDIDA</h2>

                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">


                        <table height="200"  align="center">
                            <tr>
                            <input type="hidden" id="Id" value="<?php echo $row["Id"] ?>"  style="width: 400px; height: 30px">
                            </tr>
                            <tr>
                                <td >Unidad de Medida</td>
                                <td>&nbsp;<input type="text" id="Medida" value="<?php echo $row["Descripcion"] ?>"  style="width: 400px; height: 30px"></td>
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
                consultar();

                $('#btn_aceptar').click(function () {

                    if (document.getElementById('Medida').value.trim() == '') {
                        alert('Error!, Digite la Unidad de Medida');
                        return false;
                    }

                   

                    if (document.getElementById('Activo').checked == true) {
                        document.getElementById('Activo').value = '1'
                    }

                    if (document.getElementById('Activo').checked == false) {
                        document.getElementById('Activo').value = '0'
                    }

                    $.post('medida_guardar.php',
                            {

                                Tipo: '2',
                                Medida: document.getElementById('Medida').value.trim(),                        
                                Activo: document.getElementById('Activo').value,
                                Id: document.getElementById('Id').value,
                            },
                            function (data, status) {
                                $('#targetDiv').html(data);
                                //alert(data);
                                
                                document.getElementById('Medida').value = '';
                                
                            });


                });





                $('#btn_eliminar').click(function () {

                    if (confirm('Esta seguro que desea Eliminar este Registro?')) {

                        if (document.getElementById('Id').value == '') {
                            alert('Error!, el registro no existe');
                            return false;
                        }
                        $.post('medida_guardar.php',
                                {
                                    Tipo: '3',
                                    Id: document.getElementById('Id').value,

                                },
                                function (data, status) {
                                    $('#targetDiv').html(data);
                                    //alert(data);
                                });



                        document.getElementById('Medida').value = '';
                 

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
