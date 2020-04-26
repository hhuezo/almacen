<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link href="../css/texto.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php
        require_once('../conexion/conexion.php');

        session_start();
        if (isset($_GET["txt_descargo"])) {
            $descargo = $_GET["txt_descargo"];
            if ($_SESSION['id_tipo'] == 2) {
                $rs = mysql_query("SELECT *, date_format(kardex.fecha, '%d/%m/%Y') as fecha_dmy FROM kardex 
		INNER JOIN articulo ON kardex.id_art = articulo.id_art
		LEFT JOIN departamento ON kardex.id_dto = departamento.id_dto 
		LEFT JOIN automovil ON automovil.id_auto = kardex.id_auto
		LEFT JOIN uni_med u on articulo.id_um = u.id_um
		inner join descargo des on kardex.descargo = des.descargo
		where NumBodega <>2  and kardex.descargo = $descargo order by id_kar");
            } else if ($_SESSION['id_tipo'] == 3) {
                $rs = mysql_query("SELECT *, date_format(des.fecha, '%d/%m/%Y') as fecha_dmy FROM kardex 
		INNER JOIN articulo ON kardex.id_art = articulo.id_art
		LEFT JOIN departamento ON kardex.id_dto = departamento.id_dto 
		LEFT JOIN automovil ON automovil.id_auto = kardex.id_auto
		LEFT JOIN uni_med u on articulo.id_um = u.id_um
		inner join descargo des on kardex.descargo = des.descargo
		where NumBodega =2  and kardex.descargo = " . $_GET['txt_descargo'] . " order by id_kar");
            } else {
                $rs = mysql_query("SELECT *, date_format(kardex.fecha, '%d/%m/%Y') as fecha_dmy FROM kardex 
		INNER JOIN articulo ON kardex.id_art = articulo.id_art
		LEFT JOIN departamento ON kardex.id_dto = departamento.id_dto 
		LEFT JOIN automovil ON automovil.id_auto = kardex.id_auto
		LEFT JOIN uni_med u on articulo.id_um = u.id_um
		where  descargo = " . $_GET['txt_descargo'] . " order by id_kar");
            }
            $numFilas = mysql_num_rows($rs);

            if ($numFilas > 0) {   
                $row = mysql_fetch_array($rs);
                ?>

                <form name="descargo" method="post" action="../editar_entrada_articulo.php">
                    <table width="650" border='2' align='center' >
                        <tr>
                            <td colspan="2" class="texto">DESCARGO: <?php echo $row["descargo"]; ?></td>
                            <td colspan="2"><center>
                            <span class="texto">FECHA: <br ><?php echo $row["fecha_dmy"]; ?>
                                </center></td>
                                <td colspan="3"><span class="texto"><center>PARA USO DE: </span><br> 
                                    <?php echo $row["nom_dto"]; ?>  <?php echo $row["equipo"]; ?> <span class="texto"></span><?php echo $row["placa"]; ?></td>
                                </tr>
                                <tr class="row1" bgcolor=#e5eecc>
                                    <td width="10%" align="center"><strong>CANTIDAD</strong></td>
                                    <td align="center"><strong>UNI.MED</strong></td>
                                    <td colspan="3" align="center"><strong>ARTICULO</strong></td>
                                    <td width="15%" align="center"><strong>PRECIO</strong></td>
                                    <td width="19%" align="center"><strong>TOTAL</strong></td>
                                </tr>
                                <?php
                                $cont = 1;
                                $total = 0;

                                do {
                                    ?>
                                    <tr class="<?php echo (($cont % 2) == 0) ? 'row1' : 'row2'; ?>">
                                        <td><?php $row["id_kar"]; ?><center>
                                        <?php echo number_format($row["cantidad"], 0); ?></center></td>
                                    <td class="texto2"><?php echo $row["nom_med"]; ?></td>
                                    <td colspan="3" class="texto2"><?php echo $row["nom_art"]; ?>&nbsp;<?php echo $row["equipo"]; ?>&nbsp;<?php echo $row["placa"]; ?></td>
                                    <td class="texto2" align='right'><?php echo number_format($row["precio"], 5); ?></td>
                                    <td class="texto2" align='right'>$	<?php echo number_format($row["total"], 5); ?></td>
                                    </tr>
                                    <?php
                                    $cont++;
                                    $total = $total + $row["total"];
                                } while ($row = mysql_fetch_array($rs));
                                ?>
                                <tr class='row1'>
                                    <td colspan='6' align="center"><strong>TOTAL</strong></td>
                                    <td class="texto2" align='right'>$	<?php echo number_format($total, 2); ?></td>
                                </tr>
                                </table>
                                <center>


                                    <?php
                                    $rs = mysql_query("select NumBodega,(select count(*) from kardex k where k.id_auto > 0 and descargo = " . $_GET['txt_descargo'] . ") as auto from descargo where descargo =" . $_GET['txt_descargo']);
                                    $row = mysql_fetch_array($rs);
                                    $NumBodega = $row['NumBodega'];
                                    $auto = $row['auto'];
                                    if ($_SESSION['id_tipo'] == 1 || $_SESSION['id_tipo'] == 2 || $_SESSION['id_tipo'] == 3) {
                                        if ($NumBodega == 1 && $auto == 0) {
                                            ?> 
                                            <center><a href="salida_articulo.php?descargo_editar=<?php echo $_GET["txt_descargo"]; ?>">Editar Descargo</a></center>
                                            <?php
                                        } else if (($NumBodega == 1 && $auto > 0) || $NumBodega == 2) {
                                            ?> 
                                            <center><a href="salida_repuesto.php?descargo_editar=<?php echo $_GET["txt_descargo"]; ?>">Editar Descargo</a></center>	
                                            <?php
                                        } else {
                                            echo "<center><img src='images/error.jpg'></center>";
                                        }
                                    }//cerrando if de existencia de datos
                                }
                            }//cerrando if del descargo
                            mysql_close();
                            ?>
                            </body>
                            </html>
