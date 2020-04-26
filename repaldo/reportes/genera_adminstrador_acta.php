<?php
include('../conexion/conexion.php');
$Orden = $_GET["Orden"];

$rs = mysql_query("SELECT Administrador FROM acta b where Orden='$Orden'");
$numFilas = mysql_num_rows($rs);
if ($numFilas > 0) {
    $row = mysql_fetch_array($rs);
    echo $row[0];
}

mysql_close($cn);
?>
