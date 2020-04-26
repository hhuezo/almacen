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
                $Descripcion = $_POST['Nombre'];
                $Casilla = $_POST['Casilla'];
                $Estante = $_POST['Estante'];
                $Cuenta = $_POST['Cuenta'];
                $Medida = $_POST['Medida'];
                $Activo = $_POST['Estado'];


                $sql = "";
            }

            if ($_POST['Tipo'] == 2) {
                $Descripcion = $_POST['Nombre'];
                $Casilla = $_POST['Casilla'];
                $Estante = $_POST['Estante'];
                $Cuenta = $_POST['Cuenta'];
                $Medida = $_POST['Medida'];
                $Activo = $_POST['Estado'];
                $Id = $_POST['Id'];

                $sql = "update articulo set Descripcion = '$Descripcion',Cuenta = '$Cuenta',Medida = $Medida, Casilla = '$Casilla',Estante = '$Estante', Activo = $Activo where Id = $Id ";
                $resultado = mysqli_query($cn, $sql);

                //echo $sql . '<br>';
                if ($resultado) {
                    echo ' <div align="center" class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> Registro modificado correctamente.</strong></div>';
                } else {
                    echo ' <div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> No Agregado.</strong></div>';
                }
            }
        }
        ?>
    </body>
</html>
