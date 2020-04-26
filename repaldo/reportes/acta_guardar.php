<?php
ob_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../js/jquery-1.4.1.js" type="text/javascript"></script>
    </head>
    <body>

        <?php
        if (isset($_GET['Id'])) {
            include('../conexion/conexion.php');
            $Id = $_GET['Id'];
            $Orden = $_GET['Orden'];
            $Acta = $_GET['Acta'];
            $Fecha = $_GET['Fecha'];
            $Representante = $_GET['Representante'];
            $Facturas = $_GET['Facturas'];
            $Administrador= $_GET['Administrador'];
            $Encargado = $_GET['Encargado'];
            $Cargo = $_GET['Cargo'];

            if ($Acta == '') {

                $rs = mysql_query("select Codigo from Acta where Orden = '$Orden'");
                $numFilas = mysql_num_rows($rs);
                
                if ($numFilas == 0) {
                    $Axo = date("Y");
                    $rs = mysql_query("select ifnull(max(Numero),0) +1 as Numero from Acta where Axo = $Axo");
                    $row = mysql_fetch_array($rs);
                    $Numero = $row["Numero"];
                    $Codigo = $Numero . '-' . $Axo;

                    $Hora = date("H:i",(strtotime ("-1 Hours")));

                    $sql = "insert into acta (Axo,Numero,Codigo,Fecha,Orden,Representante,Facturas,Administrador,Encargado,AdministradorCargo) values "
                            . "($Axo,$Numero,'$Codigo','$Fecha $Hora' ,'$Orden','$Representante','$Facturas','$Administrador','$Encargado','$Cargo')";
                   

                    $Acta = $Codigo;
                    mysql_query($sql);
                }
                else{
                     $row = mysql_fetch_array($rs);
                     $Acta = $row["Codigo"];
                }
            }
            mysql_close($cn);
            header("Location: reporte_acta_aceptar.php?Codigo=$Acta");
        }
        ?>
    </body>
</html>
<?php
ob_end_flush();
?>