<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="css/principal.css">
    </head>
    <body>
        <?php
        include('../conexion/Conexion_usuario.php');
        if (isset($_GET["txt_nombre_orden"])) {
            if ($_SESSION['id_tipo'] == 2) {
                $rs = mysql_query("select o.orden_compra,o.fecha,p.id_prov,p.nom_prov,o.para_uso,u.id_usuario,u.username,o.NumBodega,date_format(o.fecha, '%d/%m/%Y') as fecha
		FROM orden_compra o 
		inner join proveedor p ON p.id_prov = o.id_prov
		inner join usuarios u on o.id_usuario = u.id_usuario 
		where orden_compra like '%" . $_GET['txt_nombre_orden'] . "%' and NumBodega <>2 order by orden_compra desc");
            } else if ($_SESSION['id_tipo'] == 3) {
                $rs = mysql_query("select o.orden_compra,o.fecha,p.id_prov,p.nom_prov,o.para_uso,u.id_usuario,u.username,o.NumBodega,date_format(o.fecha, '%d/%m/%Y') as fecha  
		FROM orden_compra o 
		inner join proveedor p ON p.id_prov = o.id_prov
		inner join usuarios u on o.id_usuario = u.id_usuario 
		where orden_compra like '%" . $_GET['txt_nombre_orden'] . "%' and NumBodega =2 order by orden_compra desc");
            } else {
                $rs = mysql_query("select o.orden_compra,o.fecha,p.id_prov,p.nom_prov,o.para_uso,u.id_usuario,u.username,o.NumBodega,date_format(o.fecha, '%d/%m/%Y') as fecha  
		FROM orden_compra o 
		inner join proveedor p ON p.id_prov = o.id_prov
		inner join usuarios u on o.id_usuario = u.id_usuario 
		where orden_compra like '%" . $_GET['txt_nombre_orden'] . "%'  order by orden_compra desc");
            }
            $numFilas = mysql_num_rows($rs);
            echo $numFilas;
            if ($numFilas > 0) {
                ?>
                <table border='0' align='center' >
                    <tr class="row1" bgcolor=#e5eecc><td align="center"><b>No Orden</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td align="center"><b>Fecha</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td align="center"><b>Proveedor</b></td>
                    </tr>  
                    <?php
                    $cont = 1;
                    while ($row = mysql_fetch_array($rs)) {
                        ?>
                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                            <td><a href="#" onClick="javascript:ordenSelect('<?php echo $row[0]; ?>', '<?php echo $row[1]; ?>', '<?php echo $row[2]; ?>', '<?php echo $row[3]; ?>', '<?php echo $row[4]; ?>', '<?php echo $row[5]; ?>', '<?php echo $row[6]; ?>', '<?php echo $row[0]; ?>', '<?php echo $row[7]; ?>');"><?php echo $row[0]; ?>
                                </a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><?php echo $row[8]; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><?php echo $row[3]; ?></td>
                        </tr>
                        <?php
                        $cont++;
                    }
                } else {
                    echo "<center><img src='images/error.jpg'></center>";
                }
            }
            ?>
    </body>
</html>
