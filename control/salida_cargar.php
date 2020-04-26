<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../select2/jquery.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
        if (isset($_POST["Descargo"])) {
            require_once('../conexion/conexion.php');
            $Descargo = $_POST["Descargo"];

            
            
            $rs = mysqli_query($cn, "SELECT descargo.Codigo, descargo.Fecha, descargo.Oficina
                    FROM descargo descargo where Codigo = '$Descargo'  ");
            

            if (mysqli_num_rows($rs) > 0) {
                $row = mysqli_fetch_array($rs);
                ?>
                <script type="text/javascript">
                    document.getElementById('Fecha').value = '<?php echo $row["Fecha"]; ?>';
                    document.getElementById('Oficina').value = '<?php echo $row["Oficina"]; ?>';
                </script>


                <?php
            }

            mysqli_close($cn);
        }
        ?>
    </body>
</html>
