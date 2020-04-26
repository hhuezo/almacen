<?php

include('conexion/conexion.php');
include('conexion/conexion_sql.php');

$rs = mysql_query("SELECT  articulo.numero_bodega, 
    DATE_FORMAT(kardex.fecha, '%d/%m/%Y') as fecha,
    kardex.numero_factura,
    kardex.descargo,
    kardex.id_kar,
    kardex.cantidad,
    uni_med.nom_med,
    articulo.nom_art, 
    kardex.precio,
    kardex.NumSolicitud
    FROM (articulo articulo
    INNER JOIN uni_med uni_med ON (articulo.id_um = uni_med.id_um))
    INNER JOIN kardex kardex ON (articulo.id_art = kardex.id_art) where fecha > '2019-01-01' and id_auto > 0 and NumSolicitud > 0 order by kardex.id_kar ");

while ($row = mysql_fetch_array($rs)) {
    $stmt_conteo = sqlsrv_query($conn, "select * from  CompraRepuesto where IdAlmacen = " . $row["id_kar"] . "  and GCRecord is null", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
    if (sqlsrv_num_rows($stmt_conteo) == 0) {

        $stmt = sqlsrv_query($conn, "select Oid from  SolicitudReparacion where CodSolicitud = " . $row["NumSolicitud"] . "  and GCRecord is null", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
        $row2 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($row["numero_bodega"] == 2) {
            $documento = 4;
        } else {
            $documento = 1;
        }

        $sql = "insert into CompraRepuesto (Oid,CompraRepuestos,TipoDocumentos,fecha,NumeroOrdenFactura,NumeroDescargo,Cantidad,UnidadMedida,Descripcion,PrecioUnitario,IdAlmacen) values"
                . " (NEWID(),'" . $row2["Oid"] . "',$documento,'" . $row["fecha"] . "','" . $row["numero_factura"] . "','" . $row["descargo"] . "','" . $row["cantidad"] . "','" . $row["nom_med"] . "',"
                . "'" . $row["nom_art"] . "','" . $row["precio"] . "','" . $row["id_kar"] . "'  )";


        //echo $sql.'<br>';

        $params = array(1, "some data");

        $stmt = sqlsrv_query($conn, $sql, $params);
        
        echo $sql.'<br>';
        if ($stmt === false) {
            echo ' <div align="center" class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong> No Agregado.</strong></div>';
        } else {
            echo ' <div align="center" class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong> Registro creado correctamente.</strong></div>';
        }
    }
}
?>



