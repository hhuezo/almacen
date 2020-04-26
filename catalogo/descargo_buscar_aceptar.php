
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
            $rs = mysqli_query($cn, "SELECT descargo.Id,
                    descargo.Codigo,
                    descargo.Fecha,
                    descargo.Oficina,
                    Nombreoficina.Descripcion,
                    usuario.Usuario
             FROM descargo descargo
                   LEFT JOIN oficina Nombreoficina 
                      ON Nombreoficina.Id = descargo.Oficina
                  left JOIN usuario usuario ON usuario.Id = descargo.Usuario
            where descargo.Codigo like'%" . $_GET['txt_nombre'] . "%' ORDER BY descargo.Codigo DESC ");

//echo $sql;

            $numFilas = mysqli_num_rows($rs);
            if ($numFilas > 0) {
                ?>
                <table border='0' align='center' >
                    <tr class="row1" bgcolor=#e5eecc><td><b>DESCARGO</b></td>
                        <td><b>FECHA</b></td>
                        <td><b>DEP.</b></td>
                        <td><b>USUARIO</b></td>
                        <?php
                        $cont = 1;
                        while ($row = mysqli_fetch_array($rs)) {
                            ?>
                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                            <td><a href="#" onClick="javascript:articuloSelect('<?php echo $row["Id"]; ?>', '<?php echo $row["Codigo"]; ?>', '<?php echo $row["Fecha"]; ?>', '<?php echo $row["Oficina"]; ?>');"><?php echo $row[1]; ?> 
                                </a></td>
                            <td><?php echo $row["Fecha"]; ?>&nbsp;&nbsp;&nbsp;</td>
                            <td><?php echo $row["Descripcion"]; ?></td>
                             <td><?php echo $row["Usuario"]; ?></td>
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
