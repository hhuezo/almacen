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
        if (isset($_GET["txt_departamento"]) && $_GET["modoop"] == 1) {
            $sql = "INSERT INTO departamento(nom_dto) VALUES ('" . $_GET["txt_departamento"] . "')";
            mysql_query($sql);
            echo "<img src='images/agregar.jpg' border='0'>";

        }

//Modificar
        if (isset($_GET["txt_departamento"]) && $_GET["modoop"] == 2 && isset($_GET["id_departamento"])) {
            $sql = "UPDATE departamento SET nom_dto='" . $_GET["txt_departamento"] . "' WHERE id_dto = " . $_GET['id_departamento'];
            mysql_query($sql);
            echo "<img src='images/modificar.jpg' border='0'>";
        }
        
        mysql_close();
        ?>
    </body>
</html>
