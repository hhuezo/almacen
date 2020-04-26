<?php
require_once('conexion/conexion_usuario.php');

$rol = $_SESSION['Rol'];

?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>inicio</title>
        <link rel="stylesheet" href="css/style_form.css" />
    </head>

    <section class="container">
        <div class="login">
            <h1>
                <?php include_once('titulo_sistema.html'); ?>
            </h1>

            <body>
                <center>
                    <?php
                    if ($rol == 1) {
                        include_once('menu_admin.html');
                    } else if ($rol == 2) {
                        include_once('menu_almacen.html');
                    } else if ($rol == 3) {
                        include_once('menu_taller.html');
                    } else if ($rol == 4) {
                        include_once('menu_conta.html');
                    } else if ($rol == 5) {
                        include_once('menu_consulta.html');
                    }
                    ?>
            </body>

        </div>
    </section>


</html>