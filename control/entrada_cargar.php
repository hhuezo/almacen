<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../select2/jquery.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
        if (isset($_POST["Orden"])) {
            require_once('../conexion/conexion.php');
            $Orden = $_POST["Orden"];

            $rs = mysqli_query($cn, "SELECT orden.Id,
                    orden.Codigo,
                    orden.Fecha,
                    proveedor.Id as IdProveedor,
                    proveedor.Descripcion as Proveedor,
                    orden.Agrupacion,
                    orden.Uso
             FROM orden orden
                  INNER JOIN proveedor proveedor
                     ON (orden.Proveedor = proveedor.Id) where orden.Codigo = '$Orden' ");

            if (mysqli_num_rows($rs) > 0) {
                $row = mysqli_fetch_array($rs);
                ?>
                <script type="text/javascript">
                    document.getElementById('Fecha').value = '<?php echo $row["Fecha"]; ?>';
                    document.getElementById('Agrupacion').value = '<?php echo $row["Agrupacion"]; ?>';
                    document.getElementById('Proveedor').value = '<?php echo $row["IdProveedor"]; ?>';
                    document.getElementById('Uso').value = '<?php echo $row["Uso"]; ?>';
                    
                </script>


                <?php
            }

            mysqli_close($cn);
        }
        ?>
    </body>
</html>
