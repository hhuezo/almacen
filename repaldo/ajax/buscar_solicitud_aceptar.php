<?php
$conn = odbc_connect("odbcTaller", "taller", "Ta11er")or die("error EN LA CONEXION");

if (!$conn) {
    exit("Error al conectar: " . $conn);
}


if (isset($_GET["txt_numeroSolicitud"])) {

    $sql = "select s.Oid,s.CodSolicitud,a.NumeroEquipo,a.NumeroPlaca from SolicitudReparacion s left join Automovil a on s.Automovil= a.Oid 
  where s.CodSolicitud = " . $_GET['txt_numeroSolicitud'] . " and s.GCRecord is null ";

    //echo  $sql;
    $rs = odbc_exec($conn, $sql);

    if (!$rs) {

        echo '<div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>No existen registros</strong> </div>';
    } else {
        odbc_fetch_row($rs);
        include('../conexion/conexion.php');

        $rs_auto = mysql_query("select id_auto from automovil where equipo like '%" . odbc_result($rs, "NumeroEquipo") . "%' and placa like '%" . odbc_result($rs, "NumeroPlaca") . "%'");
        //echo "select id_auto from automovil where equipo like '%".odbc_result($rs, "NumeroEquipo")."%' and placa like '%".odbc_result($rs, "NumeroPlaca")."%'";	
        $row = mysql_fetch_array($rs_auto);
        //mysql_close();


        if ($row[0] == '') {
            echo '<div align="center" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Error! el equipo ' . odbc_result($rs, "NumeroEquipo") . ' no existe en la base de datos del sistema</strong> </div>';
        } else {
            ?>

            <table width="314" align="center">
                <thead bgcolor=#e5eecc>
                <th><div align="center">SOLICITUD</div></th>
                <th><div align="center">EQUIPO</div></th>
                <th><div align="center">PLACA</div></th>
            </thead>
            <div align="center"></div>

            <tr>
                <td><div align="center"><a href="#" onclick="SolicitudSelect('<?php echo odbc_result($rs, "Oid"); ?>', '<?php echo odbc_result($rs, "CodSolicitud"); ?>', '<?php echo odbc_result($rs, "NumeroEquipo"); ?>', '<?php echo odbc_result($rs, "NumeroPlaca"); ?>', '<?php echo $row[0]; ?>')"><?php echo odbc_result($rs, "CodSolicitud"); ?></a> </div></td>
                <td><div align="center"><a href="#" onclick="SolicitudSelect('<?php echo odbc_result($rs, "Oid"); ?>', '<?php echo odbc_result($rs, "CodSolicitud"); ?>', '<?php echo odbc_result($rs, "NumeroEquipo"); ?>', '<?php echo odbc_result($rs, "NumeroPlaca"); ?>', '<?php echo $row[0]; ?>')"><?php echo odbc_result($rs, "NumeroEquipo"); ?></a> </div></td>
                <td><div align="center"><a href="#" onclick="SolicitudSelect('<?php echo odbc_result($rs, "Oid"); ?>', '<?php echo odbc_result($rs, "CodSolicitud"); ?>', '<?php echo odbc_result($rs, "NumeroEquipo"); ?>', '<?php echo odbc_result($rs, "NumeroPlaca"); ?>', '<?php echo $row[0]; ?>')"><?php echo odbc_result($rs, "NumeroPlaca"); ?></a> </div></td>
            </tr>

            </table>


            <?php
        }
    }
}
?>



