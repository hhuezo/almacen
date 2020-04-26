<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/principal.css" />
    </head>
    <body>
    <center>

        <?php
        session_start();
        require_once('conexion/conexion.php');
//Eliminar
        if ($_SESSION['id_tipo'] == 1) {

            if (isset($_GET["id_articulo"])) {
                $sql = "DELETE FROM articulo WHERE id_art = " . $_GET['id_articulo'];
                mysql_query($sql);
                echo "<img src='images/eliminar.jpg' border='0'>";
            }
        } else {
            echo 'Error, no tiene permiso para borrar';
        }
       
        mysql_close();
         ?>
    </center>

</body>
</html>