
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="css/principal.css">
    </head>
    <body>

        <?php
        require_once('../conexion/conexion.php');

        if (isset($_GET["txt_nombre"])) {
            $rs = mysql_query("SELECT * FROM proveedor where nom_prov like '%" . $_GET['txt_nombre'] . "%'");

            $numFilas = mysql_num_rows($rs);
            if ($numFilas > 0) {
                ?>
                <table border='0' align='center' >
                    <tr class="row1" bgcolor=#e5eecc><td><b>PROVEEDOR</b></td></tr>  
                                <?php
                                $cont = 1;
                                while ($row = mysql_fetch_array($rs)) { ?>
                                <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                                    <td><a href="#" onClick="javascript:proveedorSelect('<?php echo $row[0]; ?>', '<?php echo $row[1]; ?>');"><?php echo $row[1]; ?> </a></td>
                                </tr>
                        <?php
                        $cont++;
                                }
                } else {
                    echo "<center><img src='images/error.jpg'></center>";
                }
            }
            mysql_close();
            ?>
    </body>
</html>
