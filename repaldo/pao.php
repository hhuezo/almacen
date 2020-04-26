<?php
include('conexion/conexion.php');
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pao</title>
        <!--para ventana modal js-->
        <link rel="stylesheet" href="style_tinybox.css" />
        <link rel="stylesheet" href="css/style_f.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/botones.css" />
    </head>
    <body>
        <section class="container">
            <div class="login" align="center">

                <h1><?php include_once('titulo_sistema.html'); ?></h1>
                <h2>REPORTE DE PAO</h2>
                <?php
                    $rs = mysql_query("select u.username,t.nom_tipo from usuarios u inner join tipo_usuario t on t.id_tipo = u.id_tipo where u.estado = '1' order by t.id_tipo");
                    $i = 1;
                    ?>
                    <strong>Usuarios</strong>
                    <table border="1" WIDTH="50%">
                        <tr align="center">
                            <td><strong>Numero</strong></td>
                            <td><strong>Usuario</strong></td>
                            <td><strong>Rol</strong></td>
                        </tr>
                        <?php
                        while ($row = mysql_fetch_array($rs)) {
                            ?>
                            <tr>
                                <td align="center"><?php echo $i; ?></td>
                                <td><?php echo $row[0]; ?></td>
                                <td><?php echo $row[1]; ?></td>                            
                            </tr> 
                            <?php
                            $i++;
                        }
                        echo '</table>';


                        $rs = mysql_query("select (select count(*) from articulo) as articulo,
                        (select count(*) from kardex a ) as kardex,(select count(*) from orden_compra a ) as orden,
                        (select count(*) from descargo a ) as descargo from articulo art where art.id_art = 1");
                        $row = mysql_fetch_array($rs);
                        
                        echo '<br><strong>REGISTROS</strong>';
                        echo '<table border="1" WIDTH="50%">
                        <tr align="center">
                            <td>'.$row[0].'</td>
                            <td>Artículos</td>
                        </tr>';
                         echo '<tr align="center">
                            <td>'.$row[1].'</td>
                            <td>Kardex</td>
                        </tr>';
                         echo '<tr align="center">
                            <td>'.$row[2].'</td>
                            <td>Órdenes de compra</td>
                        </tr>';
                        echo '<tr align="center">
                            <td>'.$row[3].'</td>
                            <td>Descargos</td>
                        </tr></table>';
                    mysql_close();
                    ?>

            </div>
        </section>
    </body>
</html>
