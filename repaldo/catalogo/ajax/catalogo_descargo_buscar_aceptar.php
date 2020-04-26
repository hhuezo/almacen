
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
        if (isset($_GET["txt_nombre_descargo"])) {
            if ($_SESSION['id_tipo'] == 2) {
                $rs = mysql_query("select d.descargo,d.fecha,dep.id_dto,dep.nom_dto,
                a.id_auto,a.detalle,a.equipo,a.placa,u.id_usuario,u.username,d.NumBodega,date_format(d.fecha, '%d/%m/%Y') as fecha
                from descargo d 
                left join automovil a ON a.id_auto = d.id_auto
                left join departamento dep ON dep.id_dto = d.id_dto
                left join usuarios u ON u.id_usuario = d.id_usuario
                where descargo like '%" . $_GET['txt_nombre_descargo'] . "%' and NumBodega <>2 order by descargo desc");
            }
            else if ($_SESSION['id_tipo'] == 3) {
                
                $rs = mysql_query("select d.descargo,d.fecha,dep.id_dto,dep.nom_dto,
                a.id_auto,a.detalle,a.equipo,a.placa,u.id_usuario,u.username,d.NumBodega,date_format(d.fecha, '%d/%m/%Y') as fecha
                from descargo d 
                left join automovil a ON a.id_auto = d.id_auto
                left join departamento dep ON dep.id_dto = d.id_dto
                left join usuarios u ON u.id_usuario = d.id_usuario
                where descargo like '%" . $_GET['txt_nombre_descargo'] . "%' and NumBodega =2 order by descargo desc");
            }
            else {
                $rs = mysql_query("select d.descargo,d.fecha,dep.id_dto,dep.nom_dto,
                a.id_auto,a.detalle,a.equipo,a.placa,u.id_usuario,u.username,d.NumBodega,date_format(d.fecha, '%d/%m/%Y') as fecha
                from descargo d 
                left join automovil a ON a.id_auto = d.id_auto
                left join departamento dep ON dep.id_dto = d.id_dto
                left join usuarios u ON u.id_usuario = d.id_usuario
                where descargo like '%" . $_GET['txt_nombre_descargo'] . "%'  order by descargo desc");
            }
            $numFilas = mysql_num_rows($rs);
            if ($numFilas > 0) {
                ?>
                <table border='0' align='center' >
                    <tr class="row1" bgcolor=#e5eecc><td align="center"><b>No Descargo</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td align="center"><b>Fecha</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td align="center"><b>Unidad</b></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td align="center"><b>Equipo</b></td>
                    </tr>  
                    <?php
                    $cont = 1;
                    while ($row = mysql_fetch_array($rs)) {
                        ?>
                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                            <td align="center"><a href="#" onClick="javascript:descargoSelect('<?php echo $row[0]; ?>', '<?php echo $row[1]; ?>', '<?php echo $row[2]; ?>', '<?php echo $row[3]; ?>', '<?php echo $row[4]; ?>', '<?php echo $row[5]; ?>', '<?php echo $row[6]; ?>', '<?php echo $row[7]; ?>', '<?php echo $row[8]; ?>', '<?php echo $row[9]; ?>', '<?php echo $row[0]; ?>', '<?php echo $row[10]; ?>');"><?php echo $row[0]; ?>
                                </a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><?php echo $row[11]; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><?php echo $row[3]; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><?php echo $row[6]; ?></td>
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
