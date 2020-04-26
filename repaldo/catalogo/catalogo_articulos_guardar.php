
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

        $nom_art = $_GET["txt_articulo"];
        $id_um = $_GET["id_unidad"];
        $id_cuenta = $_GET["id_cuenta"];
        $casilla = $_GET["casilla"];
        $cmb_estado = $_GET["cmb_estado"];
        $cmb_bodega = $_GET["cmb_bodega"];
        $txt_estante = $_GET["txt_estante"];

//Agregar
        if ($_GET["modoop"] == 1) {

            $sql = "INSERT INTO articulo(nom_art, id_um, id_cuenta, casilla, estado,estante,numero_bodega)
            VALUES('$nom_art', $id_um, $id_cuenta, '$casilla', '$cmb_estado','$txt_estante','$cmb_bodega')";

//echo $sql;

            mysql_query($sql);
            echo "<img src='images/agregar.jpg' border='0'>";            
        }


//Modificar
        if ($_GET["modoop"] == 2) {

            $sql = "UPDATE articulo
            set nom_art='$nom_art',
            id_um=$id_um,
            id_cuenta=$id_cuenta,
            estante='$txt_estante',
            casilla='$casilla', 
            estado='$cmb_estado',
            numero_bodega='$cmb_bodega',
			estante = '$txt_estante'
            WHERE id_art=" . $_GET["id_articulo"];
//echo $sql;

            mysql_query($sql);
            echo "<img src='images/modificar.jpg' border='0'>";
        }
        
        mysql_close();
        ?>
    </body>
</html>
