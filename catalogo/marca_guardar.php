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
                $Marca = $_POST['Marca'];
                
                $sql = "insert into marca (Descripcion) values ('$Marca')";
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
                $Marca = $_POST['Marca'];
                $Activo = $_POST['Activo'];
                $Id = $_POST['Id'];

                $sql = "update marca set Descripcion = '$Marca',Activo = $Activo where Id = $Id ";
                $resultado = mysqli_query($cn, $sql);

                //echo $sql.
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

                $sql = "delete from marca  where Id = $Id";
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
