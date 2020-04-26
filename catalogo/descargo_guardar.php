<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_POST['Tipo'])) {
            require_once('../conexion/conexion_usuario.php');


            if ($_POST['Tipo'] == 1) {
                $Codigo = $_POST['Codigo'];
                $Oficina = $_POST['Oficina'];
                $Fecha = $_POST['Fecha'];

                $sql = "insert into descargo (Codigo,Fecha,Oficina,Usuario) values ('$Codigo','$Fecha',$Oficina," . $_SESSION["IdUsuario"] . ") ";
                $resultado = mysqli_query($cn, $sql);

                //echo $sql . '<br>';
                if ($resultado) {
                    echo "<img src='../images/agregar.jpg' border='0'>";
                    //echo "<img src='images/modificar.jpg' border='0'>";
                } else {
                    echo ' <div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> No Agregado.</strong></div>';
                }
            }

            if ($_POST['Tipo'] == 2) {
                $Codigo = $_POST['Codigo'];
                $Oficina = $_POST['Oficina'];
                $Fecha = $_POST['Fecha'];
                $Id = $_POST['Id'];

                $sql = "update descargo set Codigo = '$Codigo',Fecha = '$Fecha',Oficina = $Oficina where Id = $Id ";
                $resultado = mysqli_query($cn, $sql);

                //echo $sql . '<br>';
                if ($resultado) {
                     echo "<img src='../images/modificar.jpg' border='0'>";
                } else {
                    echo ' <div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> No Agregado.</strong></div>';
                }
            }
            
            
            
              if ($_POST['Tipo'] == 3) {
                $Id = $_POST['Id'];

                $sql = "delete from   descargo  where Id = $Id";
                $resultado = mysqli_query($cn, $sql);
                //echo $sql;
                if ($resultado) {
                   echo "<img src='../images/eliminar.jpg' border='0'>";
                } else {
                    echo ' <div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> No eliminado.</strong></div>';
                }
            }
        }
        ?>
    </body>
</html>
