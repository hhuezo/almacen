<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    </head>
    <body>
        <?php
        if (isset($_GET["txt_descargo"])) {
            require_once('../conexion/conexion.php');
            $rs = mysqli_query($cn, "select * from descargo where  descargo.Codigo =  " . $_GET['txt_descargo'] . "");


            if (mysqli_num_rows($rs) > 0) {
                ?>
                <table border='0' align='center' >
                    <tr class="row1" bgcolor=#e5eecc><td align="center"><b>DESCARGO</b></td>                     
                    </tr>

                    <?php
                    $cont = 1;
                    while ($row = mysqli_fetch_array($rs)) {
                        ?>
                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                            <td><a href="#" onClick="javascript:descargoSelect('<?php echo $row["Id"]; ?>', '<?php echo $row["Codigo"]; ?>');">
                                    <?php echo $row["Codigo"]; ?> 
                                </a></td>                           
                        </tr>

                        <?php
                        $cont++;
                    }
                }
            } else {
                echo "<center><img src='../images/error.jpg'></center>";
            }
            ?>
    </body>
</html>
