<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    </head>
    <body>
        <?php
        if (isset($_GET["txt_nombre"])) {
            require_once('../conexion/conexion.php');
            $rs = mysqli_query($cn, "SELECT articulo.Id,
                    articulo.Descripcion,
                    cuenta.Alias AS Cuenta,
                    (select ifnull(sum(Cantidad),0) from kardex where kardex.Articulo = articulo.Id and kardex.Movimiento = 1)-
                    (select ifnull(sum(Cantidad),0) from kardex where kardex.Articulo = articulo.Id and kardex.Movimiento = 2) AS Existencia,
                    medida.Descripcion AS Medida
             FROM articulo articulo 
                   INNER JOIN cuenta cuenta ON cuenta.Id = articulo.Cuenta
                  INNER JOIN medida medida ON medida.Id = articulo.Medida
                  where articulo.Activo = 1 and articulo.Descripcion like '%" . $_GET['txt_nombre'] . "%' order by articulo.Id");
           

            if (mysqli_num_rows($rs) > 0) {
                ?>
                <table border='0' align='center' >
                    <tr class="row1" bgcolor=#e5eecc><td align="center"><b>ARTICULO</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td align="center"><b>CUENTA</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td align="center"><b>MEDIDA</b></td>
                    </tr>

                    <?php
                    $cont = 1;
                    while ($row = mysqli_fetch_array($rs)) {
                        ?>
                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                            <td><a href="#" onClick="javascript:articuloSelect('<?php echo $row["Id"]; ?>', '<?php echo $row["Descripcion"]; ?>', '<?php echo $row["Existencia"]; ?>');">
                                    <?php echo $row["Descripcion"]; ?> 
                                </a></td> 
                            <td>&nbsp;&nbsp;</td>
                            <td><?php echo $row["Cuenta"]; ?></td>
                            <td>&nbsp;&nbsp;</td>
                            <td><?php echo $row["Medida"]; ?></td>
                        </tr>

                        <?php
                        $cont++;
                    }
                }
            } else {
                echo "<center><img src='../images/error.jpg'></center>";
            }
            ?>
    </body>
</html>
