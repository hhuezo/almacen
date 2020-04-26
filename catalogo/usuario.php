<?php
require_once('../conexion/conexion_admin.php');
$rs = mysqli_query($cn, "SELECT usuario.Id,
       usuario.Usuario,
       usuario.Clave,
       rol.Rol,
       usuario.Activo
FROM usuario usuario
     INNER JOIN rol rol ON (usuario.Rol = rol.Id) ");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Usuarios</title>

        <!-- data tables -->        
        <link href="../select2/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../select2/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../select2/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <script src="../select2/jquery-3.3.1.js" type="text/javascript"></script>
        <script src="../select2/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../select2/dataTables.bootstrap.min.js" type="text/javascript"></script>  
        <script src="../select2/dataTables.responsive.min.js" type="text/javascript"></script>
        <script src="../select2/responsive.bootstrap.min.js" type="text/javascript"></script>

        <script>
            $(document).ready(function () {
                $('#example').DataTable();
            });
        </script>
        <!-- // data tables -->



        <link rel="stylesheet" href="../css/style_form.css" type="text/css" />


    </head>
    <body>

        <section class="container">
            <div class="login" align="center">
                <h1><?php include_once('../titulo_sistema.html'); ?></h1>
                <h2>USUARIOS</h2>

                <a href="usuario_nuevo.php"><button  class="btn btn-primary">Nuevo Usuario</button></a>
                <a href="../index.php"><input type="button" value="Cancelar" class="btn btn-warning"></a>
                <form  method="post" >
                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" >
                        <thead>
                            <tr>
                                <th><center>Id</center></th>                       
                        <th><center>Usuario</center></th>  
                        <th><center>Rol</center></th>                         
                        <th><center>Activo</center></th> 
                        <th><center>Modificar</center></th>
                        </tr>
                        </thead>


                        <tbody>
                            <?php
                            if (mysqli_num_rows($rs) > 0) {

                                while ($row = mysqli_fetch_array($rs)) {
                                    ?>
                                    <tr align="center">
                                        <td><?php echo $row["Id"]; ?></td>   
                                        <td><?php echo $row["Usuario"]; ?></td> 
                                        <td><?php echo $row["Rol"]; ?></td>   
                                        <td><input type="checkbox" <?php
                                            if ($row["Activo"] == '1') {
                                                echo 'checked';
                                            }
                                            ?> 
                                                   >
                                        </td> 

                                        <td>
                                            <a href="usuario_modificar.php?Id=<?php echo $row['Id']; ?>"> <input type="button" class="btn btn-success" value="Modificar"></a>
                                        </td>
                                      
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                               <strong>No existen registros!</strong> </div>';
                            }
                            ?>

                        </tbody>
                    </table>

                </form>
            </div>

        </section>
    </body>

</html>
<?php
mysqli_close($cn);
?>