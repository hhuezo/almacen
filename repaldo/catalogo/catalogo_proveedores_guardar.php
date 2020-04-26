<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/principal.css" />
    </head>
    <body>
        <?php
        require_once('conexion/conexion.php');
        session_start();


//Agregar
        if (isset($_GET["txt_proveedor"]) && $_GET["modoop"] == 1) {
            $sql = "INSERT INTO proveedor(nom_prov) VALUES ('" . $_GET["txt_proveedor"] . "')";
            mysql_query($sql);
            echo "<img src='images/agregar.jpg' border='0'>";

        }

//Modificar
        if (isset($_GET["txt_proveedor"]) && $_GET["modoop"] == 2 && isset($_GET["id_proveedor"])) {
            $sql = "UPDATE proveedor SET nom_prov='" . $_GET["txt_proveedor"] . "' WHERE id_prov = " . $_GET['id_proveedor'];

             mysql_query($sql);
            echo "<img src='images/modificar.jpg' border='0'>";
        }
        
        mysql_close();
        ?>
    </body>
</html>
