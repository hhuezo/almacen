<?php
require_once('../conexion/conexion_uaci.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_POST["Orden"])) {
            $stmt = sqlsrv_query($conn, "select acta.id_acta,acta.cargo,acta.fecha_acta,acta.fecha_ingreso,acta.hora,acta.recibe,acta.representante,acta.factura
                from compra inner join acta ON compra.id_acta = acta.id_acta where compra.correlativo = " . $_POST["Orden"] . " ", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));

            if (sqlsrv_num_rows($stmt) > 0) {
                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                ?>

                <script type="text/javascript">
                    document.getElementById('Representante').value = '<?php echo $row["representante"]; ?>';
                    document.getElementById('Recibe').value = '<?php echo $row["recibe"]; ?>';
                    document.getElementById('Cargo').value = '<?php echo $row["cargo"]; ?>';
                    document.getElementById('Factura').value = '<?php echo $row["factura"]; ?>';
                    document.getElementById('Acta').value = '<?php echo $row["id_acta"]; ?>';
                    document.getElementById('Fecha').value = '<?php echo date_format($row['fecha_acta'], 'Y-m-d').""; ?>';
                    document.getElementById('Hora').value = '<?php  echo date_format($row['hora'], 'H:i').""; ?>';
                    
                </script>

                <?php
                
            }
        }
        ?>
    </body>
</html>
<?php
sqlsrv_close();
?>