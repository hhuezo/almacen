<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    </head>
    <body>
        <?php
        if (isset($_GET["txt_solicitud"])) {
            require_once('../conexion/conexion_taller.php');
            $stmt = sqlsrv_query($conn, "SELECT     dbo.SolicitudReparacion.Oid, dbo.SolicitudReparacion.CodSolicitud, dbo.Automovil.Oid AS OidAutomovil, dbo.Automovil.NumeroEquipo, dbo.Automovil.NumeroPlaca, 
                      dbo.AutoModelo.Modelo, dbo.AutoClase.ClaseAuto, dbo.AutoMarca.MarcaAuto
                        FROM         dbo.SolicitudReparacion left JOIN
                          dbo.Automovil ON dbo.SolicitudReparacion.Automovil = dbo.Automovil.Oid left JOIN
                          dbo.AutoModelo ON dbo.Automovil.AutoModelo = dbo.AutoModelo.Oid left JOIN
                          dbo.AutoMarca ON dbo.Automovil.AutoMarca = dbo.AutoMarca.Oid left JOIN
                          dbo.AutoClase ON dbo.Automovil.AutoClase = dbo.AutoClase.Oid  where dbo.SolicitudReparacion.CodSolicitud = '" . $_GET["txt_solicitud"] . "'  ", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));



            if (sqlsrv_num_rows($stmt) > 0) {
                ?>
                <table border='0' align='center' >
                            <tr class="row1" bgcolor=#e5eecc><td align="center"><b>NUM. SOLICITUD</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td align="center"><b>EQUIPO</b></td>
                        <td>&nbsp;&nbsp;</td>
                        <td align="center"><b>PLACA</b></td>
                    </tr>

                    <?php
                    $cont = 1;
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                            <td><a href="#" onClick="javascript:solicitudSelect('<?php echo $row["Oid"]; ?>', '<?php echo $row["CodSolicitud"]; ?>', '<?php echo $row["OidAutomovil"]; ?>', '<?php echo $row["NumeroEquipo"]; ?>', '<?php echo $row["NumeroPlaca"]; ?>', '<?php echo $row["Modelo"].' '.$row["ClaseAuto"]; ?>', '<?php echo $row["MarcaAuto"]; ?>');">
                                    <?php echo $row["CodSolicitud"]; ?> 
                                </a></td> 
                            <td>&nbsp;&nbsp;</td>
                            <td><?php echo $row["NumeroEquipo"]; ?></td>
                            <td>&nbsp;&nbsp;</td>
                            <td><?php echo $row["NumeroPlaca"]; ?></td>
                        </tr>

                        <?php
                        $cont++;
                    }
                    sqlsrv_close();
                }
                
                else {
                echo "<center><img src='../images/error.jpg'></center>";
            }
            } 
            ?>
    </body>
</html>
