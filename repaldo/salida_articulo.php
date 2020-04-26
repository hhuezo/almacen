<?php
   session_start();
    include('conexion/conexion.php');

    if (!isset($_SESSION['username'])){
        header("Location: index.php");
       exit();
    } 
	
if (isset($_GET['descargo_editar'])) {
    $descargo_editar = $_GET['descargo_editar'];

    $rs = mysql_query("select fecha,dep.id_dto,dep.nom_dto from descargo d inner join departamento dep on dep.id_dto = d.id_dto where descargo = $descargo_editar");
    $row = mysql_fetch_array($rs);
    $fecha = $row[0];
    $id_departamento = $row[1];
    $nombre_departamento = $row[2];
} else {

    $rs = mysql_query("select max(descargo) as conteo from descargo  where id_estatus = 0 and id_usuario = " . $_SESSION['id_usuario']);
    $row = mysql_fetch_array($rs);
    if ($row[0] > 0) {
        $descargo = $row[0];
        $rs = mysql_query("select d.descargo,d.fecha,d.id_dto,dep.nom_dto from descargo d inner join departamento dep on dep.id_dto = d.id_dto where d.descargo = $descargo");
        //echo "select d.descargo,d.fecha,d.id_dto,dep.nom_dto from descargo d inner join departamento dep on dep.id_dto = d.id_dto where d.descargo = $descargo";
        $row = mysql_fetch_array($rs);
        $fecha = $row["fecha"];
        $descargo_editar = $row["descargo"];
        $id_departamento = $row["id_dto"];
        $nombre_departamento = $row["nom_dto"];
    } else {
        $fecha = "";
        $descargo_editar = "";
        $id_departamento = "";
        $nombre_departamento = "";
    }
}
mysql_close();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Almacen</title>
        <!--para ventana modal js-->
        <link rel="stylesheet" href="style_tinybox.css" />
        <script type="text/javascript" src="tinybox.js"></script>

        <!--FIN para ventana modal js-->
        <script type="text/javascript" src="Ajax/Ajax.js"></script>
        <link rel="stylesheet" href="css/style_form.css" type="text/css" />

        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
        <link rel="stylesheet" type="text/css" href="css/botones.css" />
        <script src="js/jquery-1.4.1.js" type="text/javascript"></script>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui.min.js" type="text/javascript"></script>

        <script language="javascript">
            function consultar() {
            //alert('consultar()');
            buscarAceptar('salida_articulo_consultar.php?descargo_editar=' + kardex.descargo.value, 'targetDiv');
            }
            function LimpiarTodo() {
            var i;
            for (i = 0; i < document.forms.kardex.elements.length; i++) {
            if (document.forms.kardex.elements[i].type == "text") {
            document.forms.kardex.elements[i].value = '';
            }
            if (document.forms.kardex.elements[i].type == "checkbox") {
            document.forms.kardex.elements[i].value = 0;
            }
            }
            }
            
          </script>





    </head>
<body onLoad="consultar();">
<!--<body>-->
        <section class="container">
                <div class="login" align="center">

                    <h1><?php include_once('titulo_sistema.html'); ?></h1>
                    <h2>SALIDA DE ARTICULOS</h2>


                    <form name="kardex" method="post">
                        <table height="217" align="center">
                            <tr><td>Descargo</td>
                                <td>
                                    &nbsp;<input type="number" name="descargo" id="descargo" style="width: 350px" value="<?php echo $descargo_editar; ?>">
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
                                </td>
                            </tr>

                            <tr>

                            </tr>
                            <tr>
                                <td>Fecha</td>		   
                                <td>&nbsp;<input type="date" name="fecha" id="fecha"  style="width: 350px" value='<?php echo $fecha; ?>'></td>
                                <td align='center'>
                                    <input type="button" name="btnguardar" value="Guardar" 
                                        accept=""onClick="  sendQueryToAdd('guardar_descargo.php?modoop=1&id_articulo=' + kardex.id_articulo.value, 'targetDiv'); LimpiarTodo(); kardex.descargo.value='';kardex.fecha.value='';">
                                </td>
                            </tr>
                            <tr>
                                <td>Departamento</td>
                                <td>
                                    <input type="hidden" name="id_departamento" id="id_departamento" value='<?php echo $id_departamento; ?>' size="5" />
                                    <input type="text" name="txt_departamento" id="txt_departamento" readonly value='<?php echo $nombre_departamento; ?>' style="width: 350px" onBlur="this.value = this.value.toUpperCase();" />
				</td>
                                 <td align="center">
                                       <a href="#" onClick="TINY.box.show({iframe: 'catalogo_departamentos_buscar.php', boxid: 'frameless', width: 625, height: 450, fixed: false, maskid: 'bluemask', maskopacity                                       : 40, closejs: function () {}})                                       " 
					class="enlacebotonimagen" name="btnBuscar"><img src="css/16-Search.ico"></a> 

                                </td>
                            </tr>
                            <tr>
                                <td colspan>Existencia</td>
                                <td><input type="text" name="txt_existencia" id="txt_existencia" style="width: 350px" readonly ></td>
                                <td></td>
                            </tr>
                            <tr>   
                                <td >Articulo</td>
                                <td> 
                                    <input type="hidden" name="id_articulo" id="id_articulo" size="50" readonly>
                                    <input type="text" name="txt_articulo" id="txt_articulo" style="width: 350px" readonly>
                                </td>
                                <td align='center'>
                                       <a href="#" onClick="TINY.box.show({iframe: 'articulo_activo_buscar.php', boxid: 'frameless', width: 750, height: 450, fixed: false, maskid: 'bluemask', maskopacity: 40, closejs: function () {}})" 
                                        class="enlacebotonimagen" name="btnBuscar">
                                       <img src="css/16-Search.ico"></a>
                                </td>	   
                            </tr>
                            <tr>
                                <td>Cantidad </td>
                                <td>&nbsp;<input type="number" name="cantidad" id="cantidad" style="width: 350px"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><center>
                                <input type="button" name="aceptarbtn" value="Aceptar" onClick="

                                       if (kardex.fecha.value == '') {
                                       alert('Por favor, no dejar la fecha en blanco')
                                               return false;
                                       } else if (kardex.txt_articulo.value == '') {
                                       alert('Por favor, no dejar el articulo en blanco')
                                               return false;
                                       } else if (kardex.cantidad.value == '') {
                                       alert('Por favor, no dejar la cantidad en blanco')
                                               return false;
                                       } else {
                                       sendQueryToAdd('salida_articulo_guardar.php?modoop=1&id_articulo=' + kardex.id_articulo.value + '&cantidad=' + kardex.cantidad.value + '&fecha=' + kardex.fecha.value + '&descargo=' + kardex.descargo.value + '&id_departamento=' + kardex.id_departamento.value + '&txt_existencia=' + kardex.txt_existencia.value + '&id_usuario=' + kardex.id_usuario.value, 'targetDiv');
                                       kardex.txt_existencia.value = '';
                                       kardex.txt_articulo.value = '';
                                       kardex.cantidad.value = '';
                                       sendQueryToSelect('salida_articulo_consultar.php?descargo_editar=' + kardex.descargo.value, 'targetDiv');
                                       }"  >                                
                                                     <a href="inicio.php">                                    
                                           <input type="button" name="btncancelar" value="Cancelar">
                                </a>

                            </center></td>
                            </tr>
                      </table>
                        <div id="targetDiv"></div>

                    </form>



                </div>

            </section>
        </body>
</html>
