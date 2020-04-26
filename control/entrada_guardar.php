<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once('../conexion/conexion_usuario.php');

        if (isset($_POST["Opcion"])) {

            if ($_POST["Opcion"] == 1) {
                $Fecha = $_POST["Fecha"];
                $Orden = $_POST["Orden"];
                $Agrupacion = $_POST["Agrupacion"];
                $Proveedor = $_POST["Proveedor"];
                $Uso = $_POST["Uso"];
                $Factura = $_POST["Factura"];
                $Articulo = $_POST["Articulo"];
                $Cantidad = $_POST["Cantidad"];
                $Precio = $_POST["Precio"];
                $Existencia = $_POST["Existencia"];


                $rs = mysqli_query($cn, "SELECT *  FROM orden where Codigo = '$Orden' ");

                if (mysqli_num_rows($rs) == 0) {
                    $sql = "insert into orden (Codigo,Fecha,Proveedor,Agrupacion,Uso,Usuario) "
                            . "values ('$Orden','$Fecha' ,$Proveedor,$Agrupacion,'$Uso','" . $_SESSION["IdUsuario"] . "')";

					//echo $sql.'<br>';
                    mysqli_query($cn, $sql);
                }


                $sql = "insert into kardex (Fecha,Orden,Articulo,Cantidad,Precio,Total,Movimiento,Existencia,Factura,Usuario,FechaIngreso) values
                    ( '$Fecha',(select Id from orden where orden.Codigo = '$Orden'),$Articulo,$Cantidad,$Precio,$Cantidad * $Precio,1,"
                        . "$Existencia + $Cantidad,'$Factura'," . $_SESSION["IdUsuario"] . ",Now()) ";

                $resultado = mysqli_query($cn, $sql);

                if ($resultado) {
                    ?>
                    <script type="text/javascript">
                        consultar();
                    </script>


            <?php
        } else {
            echo ' <div align="center" class="alert alert-danger alert-dismissable">
                          <strong> No Agregado.</strong></div>';
        }
    }
}




mysqli_close($cn);
?>
    </body>
</html>
