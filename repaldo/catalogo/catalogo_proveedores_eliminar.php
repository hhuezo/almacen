<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/principal.css" />
    </head>
    <body>
        <?php
        session_start();
        require_once('conexion/conexion.php');
//Eliminar
        if ($_SESSION['id_tipo'] == 1) {
            if (isset($_GET["id_proveedor"])) {
                $sql = "DELETE FROM proveedor WHERE id_prov = " . $_GET['id_proveedor'];
                mysql_query($sql);
                echo "<img src='images/eliminar.jpg' border='0'>";
            }
        } else {
            echo '<br>Error, no tiene permiso para borrar';
        }
        mysql_close();
        ?>
    </body>
</html>
