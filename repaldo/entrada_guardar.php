
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        include('conexion/conexion.php');
        
        if (isset($_GET["id_articulo"])) {

            $id_art = $_GET['id_articulo'];
            $cantidad = $_GET['cantidad'];
            $precio = $_GET['precio'];
            $fecha = $_GET["fecha"];
            $orden = $_GET['orden_compra'];
            $agru = $_GET['id_agru'];
            $prov = $_GET['id_proveedor'];
            $factura = $_GET['txt_factura'];
            $uso = $_GET['uso'];

            //verificanco si ya existe una orden de compra con el numero ingresado
            $rs = mysql_query("SELECT *  FROM orden_compra o where orden_compra= $orden");
            $numFilas = mysql_num_rows($rs);
            //echo $numFilas;
             if ($numFilas == 0) {
              //insertando orden de compras
              $sql = "INSERT INTO orden_compra(orden_compra,Codigo,fecha,id_prov,id_agru,para_uso,id_estatus, id_usuario,NumBodega)
              VALUES($orden,'$orden','$fecha',$prov,$agru,'$uso',0,$_SESSION[id_usuario],1)";
              echo $sql . "<br />";
              mysql_query($sql);
              }


               //detalle de orden de compra
              $sql = "INSERT INTO kardex(id_art,orden_compra,descargo,para_uso,fecha,precio,cantidad,id_mov,total,id_agru,id_prov,id_dto,id_auto,numero_factura,existencia_actual)
              VALUES($id_art,$orden,0,'$uso','$fecha',$precio,$cantidad,1,$precio*$cantidad,$agru,$prov,0,0,'$factura',
              (select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 1)-
              (select ifnull(sum(cantidad),0) from kardex kar  where  kar.id_art = $id_art and kar.id_mov = 2)+ $cantidad)";
              echo $sql."<br />";
              mysql_query($sql); 
              
              header("Location: entrada_consultar.php?orden_compra=$orden"); 

        }         
        else if(isset($_GET['orden_compra']) && $_GET['orden_compra']>1)
        {
            $sql="update orden_compra SET id_estatus = 1 where orden_compra = ".$_GET['orden_compra'];
            mysql_query($sql);
            echo "<center><img src='images/guardar.png' border='0'></center>";
        }
        
        mysql_close();
        ?>
    </body>
</html>
