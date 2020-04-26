<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        require_once('conexion/conexion.php');
//Eliminar
        if ($_SESSION['id_tipo'] == 1) {
            $sql = "DELETE FROM departamento WHERE id_dto = " . $_GET['id_departamento'];
            mysql_query($sql);
            echo "<img src='images/eliminar.jpg' border='0'>";
        }
        else {
            echo '<br>Error, no tiene permiso para borrar';
        }
       
        mysql_close();
        ?>
    </body>
</html>
