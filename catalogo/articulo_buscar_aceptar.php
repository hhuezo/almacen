
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../css/principal.css">
    </head>
    <body>
        <?php
        require_once('../conexion/conexion.php ');

        if (isset($_GET["txt_nombre"])) {
            $rs = mysqli_query($cn, "SELECT articulo.Id,
                    articulo.Descripcion,
                    articulo.Estante,
                    articulo.Casilla,
                    medida.Id as IdMedida,
                    medida.Descripcion AS Medida,
                    cuenta.Id as IdCuenta,
                    cuenta.Descripcion AS Cuenta,
                    articulo.Activo
             FROM (articulo articulo
                   LEFT JOIN medida medida ON (articulo.Medida = medida.Id))
                  LEFT JOIN cuenta cuenta ON (articulo.Cuenta = cuenta.Id)
                         where articulo.Descripcion like'%" . $_GET['txt_nombre'] . "%'");

//echo $sql;

            $numFilas = mysqli_num_rows($rs);
            if ($numFilas > 0) {
                ?>
                <table border='0' align='center' >
                    <tr class="row1" bgcolor=#e5eecc><td><b>ARTICULO</b></td>
                        <td><b>MEDIDA</b></td>
                        <td><b>CUENTA</b></td>
                        <?php
                        $cont = 1;
                        while ($row = mysqli_fetch_array($rs)) {
                            ?>
                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                            <td><a href="#" onClick="javascript:articuloSelect('<?php echo $row["Id"]; ?>', '<?php echo $row["Descripcion"]; ?>', '<?php echo $row["Estante"]; ?>', '<?php echo $row["Casilla"]; ?>', '<?php echo $row["IdCuenta"]; ?>', '<?php echo $row["IdMedida"]; ?>', '<?php echo $row["Activo"]; ?>');"><?php echo $row[1]; ?> 
                                </a></td>
                            <td><?php echo $row["Medida"]; ?></td>
                            <td><?php echo $row["Cuenta"]; ?></td>
                            <?php
                            $cont++;
                        }
                    } else {
                        echo "<center><img src='images/error.jpg'></center>";
                    }
                    mysqli_close($cn);
                }
                ?>
                </body>
                </html>
