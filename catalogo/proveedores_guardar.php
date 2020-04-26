<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_POST['Tipo'])) {
            require_once('../conexion/conexion.php');
            if ($_POST['Tipo'] == 1) {
                $Proveedor = $_POST['Proveedor'];

                $sql = "insert into proveedor (Descripcion) values ('$Proveedor')";
                $resultado = mysqli_query($cn, $sql);
                //echo $sql.'<br>';

                if ($resultado) {
                    echo ' <div align="center" class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> Registro creado correctamente.</strong></div>';
                } else {
                    echo ' <div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> No Agregado.</strong></div>';
                }
            }


            if ($_POST['Tipo'] == 2) {
                $Proveedor = $_POST['Proveedor'];
                $Activo = $_POST['Activo'];
                $Id = $_POST['Id'];

                $sql = "update proveedor set Descripcion = '$Proveedor',Activo = $Activo where Id = $Id ";
                $resultado = mysqli_query($cn, $sql);

               // echo $sql.
                '<br>';
                if ($resultado) {
                    echo ' <div align="center" class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> Registro modificado correctamente.</strong></div>';
                } else {
                    echo ' <div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> No Agregado.</strong></div>';
                }
            }



            if ($_POST['Tipo'] == 3) {
                $Id = $_POST['Id'];

                $sql = "delete from proveedor  where Id = $Id";
                $resultado = mysqli_query($cn, $sql);
                //echo $sql;
                if ($resultado) {
                    echo ' <div align="center" class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> Registro eliminado correctamente.</strong></div>';
                    // header("Location: usuario.php");
                } else {
                    echo ' <div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> No eliminado.</strong></div>';
                }
            }
        }
        ?>
    </body>
</html>
