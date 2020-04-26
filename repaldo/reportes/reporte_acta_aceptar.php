<?php
include('../conexion/conexion.php');
$rs = mysql_query("select Codigo,DATE_FORMAT(Fecha, '%d') as Dia,DATE_FORMAT(Fecha, '%m') as Mes,DATE_FORMAT(Fecha, '%Y') as Axo,"
        . "DATE_FORMAT(Fecha, '%H:%i') as Hora,Orden,Representante,Facturas,Administrador,Encargado from Acta where Codigo = '" . $_GET["Codigo"] . "'");
$row = mysql_fetch_array($rs);

function CalculoMes($Mes) {
    switch ($Mes) {
        case '01':
            $StringMes = 'Enero';
            break;
        case '02':
            $StringMes = 'Febrero';
            break;
        case '03':
            $StringMes = 'Marzo';
            break;
        case '04':
            $StringMes = 'Abril';
            break;
        case '05':
            $StringMes = 'Mayo';
            break;
        case '06':
            $StringMes = 'Junio';
            break;
        case '07':
            $StringMes = 'Julio';
            break;
        case '08':
            $StringMes = 'Agosto';
            break;
        case '09':
            $StringMes = 'Septiembre';
            break;
        case '10':
            $StringMes = 'Octubre';
            break;
        case '11':
            $StringMes = 'Noviembre';
            break;
        case '12':
            $StringMes = 'Diciembre';
            break;
    }

    return $StringMes;
}

$Mes = CalculoMes($row["Mes"]);


//conexion sql para sistema de taller
$conn = odbc_connect("odbcTaller", "Taller", "Ta11er")or die("error EN LA CONEXION");

$sql = "SELECT TOP 1 UnidadAdministrativa,LugarAUsarse,RazonSocial FROM View_ActaRecepcion where OrdenDeCompra = '" . $row["Orden"] . "'";
$rs_sql = odbc_exec($conn, $sql);
while ($e = odbc_fetch_object($rs_sql)) {
    $UnidadAdministrativa = odbc_result($rs_sql, "UnidadAdministrativa");
    $LugarAUsarse = odbc_result($rs_sql, "LugarAUsarse");
    $RazonSocial = odbc_result($rs_sql, "RazonSocial");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Documento sin t&iacute;tulo</title>
        <style type="text/css">
            <!--
            .Estilo1 {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: bold;
                font-size: 20px;
            }
            .Estilo2 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
            .Estilo3 {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: bold;
                font-size: 12px;
            }
            -->
        </style>
    </head>

    <body>
        <table width="95%" border="1" cellpadding="0" cellspacing="0" align="center">
            <tr>
              <td width="9%" rowspan="2"><div align="center"><img src="../img/logo2.png" width="150" height="75" /></div></td>
                <td colspan="2" align="center" class="Estilo1">ACTA DE RECEPCI&Oacute;N DE BIENES</td>
                <td width="12%" rowspan="2" class="Estilo2">
                    <div align="center">
                        <p>CODIGO: FIPL-28</p>
                        <p>REVISION: 1 </p>
                    </div>
              </td>
            </tr>
            <tr>
                <td colspan="2"><div align="center"><span class="Estilo2">INSTITUTO SALVADORE&Ntilde;O DE    TRANSFORMACI&Oacute;N AGRARIA &ndash; ISTA </span></div></td>
            </tr>
            <tr>

                <td colspan="4" class="Estilo2">
				<br/>
                    <center>
                        <p align="justify" style="width:95%"><strong>&nbsp;No. DE ACTA: <u><?php echo $_GET["Codigo"]; ?></u></strong></p>
                        <p align="justify" style="width:95%" class="Estilo2">En las instalaciones del  Almac&eacute;n de Bienes en Existencia del Instituto Salvadore&ntilde;o de 
                            Transformaci&oacute;n  Agraria-ISTA, ubicado en Calle y Colonia Las Mercedes, Km. 5 1/2 de la  carretera a Santa Tecla, Contiguo al Parque de Pelota, 
                            Municipio y Departamento  de San Salvador, a las <strong><u><?php echo $row["Hora"]; ?></u></strong> horas del d&iacute;a <strong><u><?php echo $row["Dia"]; ?></u></strong><u>,
                            </u> del  mes de <strong> <u><?php echo $Mes; ?></u></strong> del a&ntilde;o <strong><u><?php echo $row["Axo"]; ?></u></strong>, se hace recepci&oacute;n de los  bienes descritos a continuaci&oacute;n:</p>

                        <table width="70%" border="1" align="center" cellpadding="0" cellspacing="0">
                            <tr bgcolor="#CCCCCC">
                                <td width="15%" class="Estilo2"><div align="center"><strong>Cantidad</strong></div></td>
                                <td width="85%" class="Estilo2"><div align="center"><strong>Descipci&oacute;n</strong></div></td>
                            </tr>

                            <?php
                            $sql = "SELECT  Cantidad ,NombreProducto FROM View_ActaRecepcion where OrdenDeCompra = '" . $row["Orden"] . "'";
                            //echo $sql;
                            $rs_sql = odbc_exec($conn, $sql);

                            while (odbc_fetch_row($rs_sql)) {
                                //$UnidadAdministrativa = odbc_result($rs_sql, "UnidadAdministrativa");
                                ?>
                                <tr class="Estilo2">
                                    <td><div align="center"><?php echo number_format(odbc_result($rs_sql, "Cantidad"), 0, '.', ''); ?></div></td>
                                    <td>&nbsp;<?php echo odbc_result($rs_sql, "NombreProducto"); ?></td>
                                </tr>
                            
                                <?php
                            }
                            ?>

                        </table> 
                        <br/>
                        <p align="justify" style="width:95%" class="Estilo2">El/los cual/es fue/ron  solicitados por: <strong><u><?php echo $UnidadAdministrativa; ?></u> </strong>para ser utilizado en <strong>
                                <u><?php echo $LugarAUsarse; ?></u></strong>,  seg&uacute;n factura No. <strong><u><?php echo $row["Facturas"]; ?></u></strong>,  amparado por la Orden de Compra N&ordm; <strong><u><?php echo $row["Orden"]; ?></u>
                            </strong>,<strong> </strong>presente el/la se&ntilde;or/a <strong><u><?php echo $row["Representante"]; ?></u> </strong>en  representaci&oacute;n de <strong><u><?php echo $RazonSocial; ?></u></strong>,
                            <strong> </strong>y por parte  del ISTA el/la se&ntilde;or/a , <strong><u><?php echo $row["Administrador"]; ?>,</u></strong> JEFE DE INFRAESTRUCTURA Y MANTENIMIENTO como  administrador de contrato y el/la se&ntilde;or/a<strong> 
                                <u><?php echo $row["Encargado"]; ?></u></strong>, ENCARGADO/A DE ALMACEN DE BIENES EN  EXISTENCIA.</p>
                        <p align="justify" style="width:95%" class="Estilo2">Los bienes recibidos por el  ISTA cumplen con las especificaciones y condiciones previamente definidas en la  Orden de Compra antes descrita.</p>
                        <p align="justify" style="width:95%" class="Estilo2">Para lo cual firmamos y  sellamos:</p>
                        <p align="justify" class="Estilo2">&nbsp;</p>    
                        <table width="65%" border="0" align="center">
                            <tr>
                                <td width="46%"><span class="Estilo3">ENTREGA:</span></td>
                                <td width="4%">&nbsp;</td>
                                <td width="50%"><span class="Estilo3"><strong>RECIBE</strong>:</span></td>
                            </tr>
                            <tr>
                                <td valign="bottom"><div align="center"><strong>_________________________________<br />
                                            <span class="Estilo3">REPRESENTANTE DE LA EMPRESA<br>.</span></strong></div></td>
                                <td height="74" valign="bottom"></td>
                                <td valign="bottom"><div align="center"><strong > _________________________________<br />
                                             <span class="Estilo3">ENCARGADO/A DE ALMACEN <br>DE BIENES EN EXISTENCIA</span></strong></div></td>
                            </tr>
                            <tr>
                                <td height="89" colspan="3" valign="bottom"><p align="center" class="Estilo3"><strong>___________________________________</strong><br /><strong>ADMINISTRADOR/A DE    CONTRATO</strong></p></td>
                            </tr>
                        </table>
                    </center>
                </td>

            </tr>
        </table>
    </body>
</html>
