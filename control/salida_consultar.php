<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/estilos.css" />
    </head>
    <body>
        <?php
        if (isset($_POST["Descargo"])) {
            require_once('../conexion/conexion.php');
            $Descargo = $_POST["Descargo"];
            $Opcion = $_POST["Opcion"];

            $rs = mysqli_query($cn, "   SELECT kardex.Id,
                    orden.Codigo,
                    articulo.Descripcion as Articulo,
                    medida.Descripcion as Medida,
                    kardex.Cantidad,
                    kardex.Precio,
                    kardex.Total,
                    vehiculo.Equipo,
                    vehiculo.Placa
             FROM ((((kardex kardex         
                     INNER JOIN orden orden ON (orden.Id = kardex.Orden))
                    INNER JOIN articulo articulo   ON (articulo.Id = kardex.Articulo))
                   INNER JOIN medida medida ON (medida.Id = articulo.Medida))
                  INNER JOIN descargo descargo ON (descargo.Id = kardex.Descargo)
                     LEFT JOIN vehiculo vehiculo ON (kardex.Vehiculo = vehiculo.Id))    
                     where descargo.Codigo =  '$Descargo' order by kardex.Id desc ");

            if (mysqli_num_rows($rs) > 0) {
                $i = 1;
                $total = 0;
                while ($row = mysqli_fetch_array($rs)) {
                    $array_item[$i][1] = $row["Articulo"];
                    $array_item[$i][2] = $row["Equipo"];
                    $array_item[$i][3] = $row["Placa"];
                    $array_item[$i][4] = $row["Medida"];
                    $array_item[$i][5] = $row["Cantidad"];
                    $array_item[$i][6] = $row["Precio"];
                    $array_item[$i][7] = $row["Total"];

                    $total += $row["Total"];
                    $i++;
                }
                ?>
                <br/>
                <table Width="90%" >
                    <tr class="row1" style="font-size: 14">
                        <td  align="center"><b>&nbsp;No&nbsp;</b></td>
                        <td  align="center"><b>Articulo</b></td>
                        <?php
                        if ($Opcion == 1) {
                            echo '<td align = "center"><b>Equipo</b></td>
                            <td align = "center"><b>Placa</b></td>';

                            $col = 6;
                        } else {
                            $col = 4;
                        }
                        ?>
                        <td  align="center"><b>Medida</b></td>
                        <td  align="center"><b>Cantidad</b></td>
                        <td  align="center"><b>Precio</b></td>
                        <td  align="center"><b>Total</b></td>



                    </tr>


                    <?php
                    $cont = 1;

                    for($i =  count($array_item);$i>=1;$i--){
                       
                        ?>
                        <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2' ?>"  style="font-size: 12">	
                            <td align="center"><?php echo $i; ?></td>
                            <td><?php echo  $array_item[$i][1]; ?></td>
                            <?php
                            if ($Opcion == 1) {
                                echo '<td align = "center"><b>' .  $array_item[$i][2] . '</b></td>
                            <td align = "center"><b>' . $array_item[$i][3]. '</b></td>';
                            }
                            ?>
                            <td align="center"><?php echo $array_item[$i][4]; ?></td>
                            <td align="center"><?php echo $array_item[$i][5]; ?></td>
                            <td align="right">$<?php echo $array_item[$i][6]; ?></td>
                            <td align="right">$<?php echo number_format($array_item[$i][7], 2);  ?></td>
                        </tr>
                        <?php
                        $cont++;

                       
                    }
                    ?>
                    <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2' ?>"  style="font-size: 12">	
                        <td colspan="<?php echo $col + 1; ?>"  align="right">TOTAL&nbsp;&nbsp;</td>
                        <td  align="right">$<?php echo $total; ?></td>
                    </tr>




                    <?php
                }

                mysqli_close($cn);
            }
            ?>
    </body>
</html>
