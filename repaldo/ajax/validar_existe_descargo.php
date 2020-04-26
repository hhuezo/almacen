<?php

include('../conexion/conexion.php');
session_start();
$descargo = $_GET['descargo'];


if ($descargo != "") {
    $rs = mysql_query("SELECT count(*) as cuenta FROM kardex k where descargo=$descargo");
    $row = mysql_fetch_array($rs);
    $cuenta = $row[0];
    if ($cuenta >= 1) {
        echo '<center><img src="../images/ya_existe_descargo.jpg"></center>';
    }
}
?>
