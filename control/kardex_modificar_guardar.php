<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <link href="../select2/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        if (isset($_POST["Opcion"])) {
            require_once('../conexion/conexion.php');

            if ($_POST["Opcion"] == 1) {
                $Id = $_POST["Id"];
                $Orden = $_POST["Orden"];
                $OrdenAnterior = $_POST["OrdenAnterior"];
                $Articulo = $_POST["Articulo"];
                $Cantidad = $_POST["Cantidad"];
                $Precio = $_POST["Precio"];
                $PrecioAnterior = $_POST["PrecioAnterior"];

                $sql = "update kardex set Orden = $Orden,Cantidad =  $Cantidad, Precio = $Precio, Total = $Precio * $Cantidad where Id = $Id ";

                mysqli_query($cn, $sql);
                echo $sql.'<br>';

                $sql = "update kardex set Orden = $Orden, Precio = $Precio, Total = $Precio * Cantidad where Orden = $OrdenAnterior and Precio = $PrecioAnterior and Articulo = $Articulo ";

                echo $sql.'<br>';

                $resultado = mysqli_query($cn, $sql);
                //echo $sql;
                if ($resultado) {
                    echo ' <div align="center" class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> Registro creado correctamente.</strong></div>';
                    // header("Location: usuario.php");
                } else {
                    echo ' <div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <strong> No Agregado.</strong></div>';
                }
            } else if ($_POST["Opcion"] == 2) {
                $Id = $_POST["Id"];
                $Descargo = $_POST["Descargo"];
                $DescargoAnterior = $_POST["DescargoAnterior"];
                $CodigoDescargo = $_POST["CodigoDescargo"];
                $CodSolicitudAnterior = $_POST["CodSolicitudAnterior"];
                $CodSolicitud = $_POST["CodSolicitud"];
                $Articulo = $_POST["Articulo"];
                $Cantidad = $_POST["Cantidad"];
                $Precio = $_POST["Precio"];
                $OidAutomovil = $_POST["OidAutomovil"];
                $Oid = $_POST["Oid"];


                $sql = "update kardex set Descargo = $Descargo,Cantidad = $Cantidad, Total = Precio * $Cantidad,Solicitud = $CodSolicitud, Vehiculo = (select Id from vehiculo where Oid = '$OidAutomovil') where Id = $Id ";
                $resultado = mysqli_query($cn, $sql);

                if ($resultado) {
                    require_once('../conexion/conexion_taller.php');
                    $sql = "update CompraRepuesto set Cantidad =  $Cantidad,  CompraRepuestos = (select Oid from SolicitudReparacion where CodSolicitud = $CodSolicitud ), NumeroDescargo = '$CodigoDescargo' where IdAlmacen =  $Id";
                    // echo $sql . '<br>';
                    $params = array(1, "some data");

                    $stmt = sqlsrv_query($conn, $sql, $params);
                    sqlsrv_close();

                    echo '<div align="center" class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Registro modificado Correctamente!</strong> </div>';
                } else {
                    echo '<div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Registro no se modifico Correctamente!</strong> </div>';
                }
            } else if ($_POST["Opcion"] == 23) {
                $Id = $_POST["Id"];

                $sql = "delete from kardex where Id = $Id";
                $resultado = mysqli_query($cn, $sql);

                if ($resultado) {
                    require_once('../conexion/conexion_taller.php');
                    $sql = "delete from  CompraRepuesto  where IdAlmacen =  $Id";
                    // echo $sql . '<br>';
                    $params = array(1, "some data");

                    $stmt = sqlsrv_query($conn, $sql, $params);
                    sqlsrv_close();

                    echo '<div align="center" class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Registro eliminado Correctamente!</strong> </div>';
                } else {
                    echo '<div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Registro no se eliminado Correctamente!</strong> </div>';
                }
            } else if ($_POST["Opcion"] == 3) {
                $Id = $_POST["Id"];
                $Descargo = $_POST["Descargo"];
                $Articulo = $_POST["Articulo"];
                $Cantidad = $_POST["Cantidad"];
                $Precio = $_POST["Precio"];


                $sql = "update kardex set Descargo = $Descargo,Cantidad = $Cantidad, Total = Precio * $Cantidad where Id = $Id ";
                echo $sql . '<br>';
                $resultado = mysqli_query($cn, $sql);

                if ($resultado) {

                    echo '<div align="center" class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Registro modificado Correctamente!</strong> </div>';
                } else {
                    echo '<div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Registro no se modifico Correctamente!</strong> </div>';
                }
            } else if ($_POST["Opcion"] == 32) {
                $Id = $_POST["Id"];

                $sql = "delete from kardex where Id = $Id";
                $resultado = mysqli_query($cn, $sql);

                if ($resultado) {                 

                    echo '<div align="center" class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Registro eliminado Correctamente!</strong> </div>';
                } else {
                    echo '<div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Registro no se eliminado Correctamente!</strong> </div>';
                }
            }

            mysqli_close($cn);
        }
        ?>
    </body>
</html>
