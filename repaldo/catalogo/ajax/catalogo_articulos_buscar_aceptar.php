
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="css/principal.css">
    </head>
    <body>
        <?php
        require_once('../conexion/conexion.php ');

        if (isset($_GET["txt_nombre"])) {
            $rs = mysql_query("SELECT a.id_art, a.nom_art,a.estante,a.casilla, 
            c.id_cuenta, c.nom_cuenta, u.id_um, u.nom_med
            FROM articulo a
            LEFT OUTER JOIN cuenta_contable c ON a.id_cuenta=c.id_cuenta
            LEFT OUTER JOIN uni_med u ON a.id_um=u.id_um
            where a.nom_art like'%" . $_GET['txt_nombre'] . "%'");

//echo $sql;

            $numFilas = mysql_num_rows($rs);
            if ($numFilas > 0) {
                ?>
                <table border='0' align='center' >
                    <tr class="row1" bgcolor=#e5eecc><td><b>ARTICULO</b></td><td><b>CUENTA</b></td>
                                <?php
                                $cont = 1;
                                while ($row = mysql_fetch_array($rs)) {
                                    ?>
                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                            <td><a href="#" onClick="javascript:articuloSelect('<?php echo $row[0]; ?>', '<?php echo $row[1]; ?>', '<?php echo $row[2]; ?>', '<?php echo $row[3]; ?>', '<?php echo $row[4]; ?>', '<?php echo $row[5]; ?>', '<?php echo $row[6]; ?>', '<?php echo $row[7]; ?>');"><?php echo $row[1]; ?> 
                                </a></td>
                            <td><?php echo $row[5]; ?></td>
                            <?php
                            $cont++;
                        }
                    } else {
                        echo "<center><img src='images/error.jpg'></center>";
                    }
                    mysql_close();
                }
                ?>
    </body>
</html>
