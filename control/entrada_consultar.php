<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/estilos.css" />
    </head>
    <body>
        <?php
        if (isset($_POST["Orden"])) {
            require_once('../conexion/conexion.php');
            $Orden = $_POST["Orden"];

            $rs = mysqli_query($cn, "SELECT kardex.Id,
                    articulo.Descripcion AS Articulo,
                    medida.Descripcion AS Medida,
                    kardex.Cantidad,
                    kardex.Precio,
                    kardex.Total,
                    kardex.Factura
             FROM kardex kardex 
                   INNER JOIN articulo articulo ON articulo.Id = kardex.Articulo
                  INNER JOIN medida medida ON medida.Id = articulo.Medida
                  INNER JOIN orden ON kardex.Orden = orden.Id
                    where orden.Codigo = '$Orden' and kardex.Movimiento = 1 order by  kardex.Id desc");

            if (mysqli_num_rows($rs) > 0) {
                ?>
                <br/>
                <table Width="90%" >
                    <tr class="row1" style="font-size: 14">
                        <td  align="center"><b>Factura</b></td>
                        <td  align="center"><b>Articulo</b></td>
                        <td  align="center"><b>Medida</b></td>
                        <td  align="center"><b>Cantidad</b></td>
                        <td  align="center"><b>Precio</b></td>
                        <td  align="center"><b>Total</b></td>                    
                    </tr>


                    <?php
                    $cont = 1;
                    $total = 0;
                    while ($row = mysqli_fetch_array($rs)) {
                        ?>
                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2' ?>"  style="font-size: 12">	
                            <td align="center"><?php echo $row["Factura"]; ?></td>
                            <td><?php echo $row["Articulo"]; ?></td>
                            <td align="center"><?php echo $row["Medida"]; ?></td>
                            <td align="center"><?php echo $row["Cantidad"]; ?></td>
                            <td align="right">$<?php echo $row["Precio"]; ?></td>
                            <td align="right">$<?php echo $row["Total"]; ?></td>
                        </tr>
                        <?php
                        $cont++;
                        $total += $row["Total"];
                        ;
                    }
                    ?>
                    <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2' ?>"  style="font-size: 12">	
                        <td colspan="5"  align="right">TOTAL</td>
                        <td  align="right">$<?php echo $total; ?></td>
                    </tr>
                    <?php
                }

                mysqli_close($cn);
            }
            ?>
    </body>
</html>
