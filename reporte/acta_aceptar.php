<?php
$_GET["Id"] = '135-2019';
require_once('../conexion/conexion_uaci.php');
$stmt = sqlsrv_query($conn, "select * from acta where acta.id_acta = '" . $_GET["Id"] . "' ", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

function mes($mes) {
    $s_mes = "";
    if ($mes == 1) {
        $s_mes = "Enero";
    } else if ($mes == 2) {
        $s_mes = "Febrero";
    } else if ($mes == 3) {
        $s_mes = "Marzo";
    } else if ($mes == 4) {
        $s_mes = "Abril";
    } else if ($mes == 5) {
        $s_mes = "Mayo";
    } else if ($mes == 6) {
        $s_mes = "Junio";
    } else if ($mes == 7) {
        $s_mes = "Julio";
    } else if ($mes == 8) {
        $s_mes = "Agosto";
    } else if ($mes == 9) {
        $s_mes = "Septiembre";
    } else if ($mes == 10) {
        $s_mes = "Octubre";
    } else if ($mes == 11) {
        $s_mes = "Noviembre";
    } else if ($mes == 12) {
        $s_mes = "Diciembre";
    }
    return $s_mes;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            <!--
            .Estilo1 {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: bold;
                font-size: 20px;
            }
            .Estilo2 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 14px;
            }
            .Estilo3 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
            .Estilo4 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }
            -->
        </style>
    </head>
    <body>
        <?php
// put your code here
        ?>
        <table width="100%" border="1" cellspacing="0" align="center">
            <tr>
                <td width="10%" rowspan="2">
                    <div align="center"><img src="../img/logo2.png" width="131" height="88">			</div></td>
                <td width="72%"><div align="center" class="Estilo1">ACTA DE RECEPCIÓN DE BIENES</div></td>
                <td width="15%" rowspan="2">
                    <div align="center">
                        <p class="Estilo3">CODIGO:FIPL-28</p>
                        <p class="Estilo3"> REVISION: 1 </p>
                    </div></td>
            </tr>
            <tr>
                <td><div align="center" class="Estilo2">INSTITUTO SALVADOREÑO DE TRANSFORMACIÓN AGRARIA - ISTA</div></td>
            </tr>
            <tr>
                <td colspan="3">

                    <p class="Estilo3">&nbsp;</p>
                    <p class="Estilo3"><strong>No. DE ACTA: <?php echo $_GET["Id"]; ?>		    </strong></p>
                    <p class="Estilo3">En las instalaciones del Almacén de Bienes en Existencia del Instituto Salvadoreño
                        de Transformación Agraria-ISTA, ubicado en Calle y Colonia Las Mercedes, Km. 5 1/2 de la carretera
                        a Santa Tecla, Contiguo al Parque de Pelota, Municipio y Departamento de San Salvador,
                        a las <?php echo date_format($row['hora'], 'H:i') . ""; ?> horas del día 
                        <?php echo date_format($row['hora'], 'd') . ""; ?>, del mes de 
                        <?php echo mes(date_format($row['hora'], 'm') . ""); ?> del año 
                            <?php echo date_format($row['hora'], 'Y') . ""; ?>, se hace recepción de los 
                        bienes descritos a continuación:</p>


                    <table width="85%" border="1" cellspacing="0" align="center">
                        <tr>
                            <td width="17%" class="Estilo2"><div align="center"><strong>Cantidad</strong></div></td>
                            <td width="83%" class="Estilo2"><div align="center"><strong>Descripción</strong></div></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>






                    <p class="Estilo3">&nbsp;&nbsp;&nbsp;El/los cual/es fue/ron solicitados por: Gerencia De Operaciones, para ser utilizado en Ista, según factura No. 766, amparado por la Orden de Compra Nº 9898, Solicitud 2674, presente el/la señor/a NORBERTO SOLIS en representación de Multi-Inversiones La Cima, S.A. De C.V., y por parte del ISTA el/la señor/a ING. ALBERTO SERRANO, JEFE DE INFRAESTRUCTURA, como administrador de contrato y el/la señor/a Santos Antonio Herrera, ENCARGADO/A DE ALMACEN DE BIENES EN EXISTENCIA.</p>
                    <p class="Estilo3">Los bienes recibidos por el ISTA cumplen con las especificaciones y condiciones previamente definidas en la Orden de Compra antes descrita.</p>
                    <p class="Estilo3">Para lo cual firmamos y sellamos:</p>


                    <table width="95%" border="0" align="center">
                        <tr>
                            <td class="Estilo2"  height="50%"><strong>ENTREGA:</strong></td>
                            <td class="Estilo4">RECIBE:</td>
                        </tr>

                        <tr>
                            <td height="165" class="Estilo4"><div align="center">_______________________________________<br/>
                                    REPRESENTANTE DE LA EMPRESA <br/>&nbsp;
                                </div></td>
                            <td class="Estilo4"><div align="center">_______________________________________<br/>
                                    ENCARGADO/A DE ALMACÉN DE <br/> BIENES EN EXISTENCIA
                                </div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><div align="center" class="Estilo4">_______________________________________<br/>
                                    ADMINISTRADOR/A DE CONTRATO </div></td>
                        </tr>
                    </table>	        
                    <p class="Estilo3">&nbsp;</p></td>
            </tr>

        </table>
    </body>
</html>
<?php
sqlsrv_close();
?>