<?php require_once('conectar/conectar.php'); 

$conn = odbc_connect( "odbcTaller", "taller", "Ta11er" )or die (odbc_errormsg());
?>
<html>
<head>

<!--para ventana modal js-->
<link rel="stylesheet" href="css/style_form.css" />
<link rel="stylesheet" type="text/css" href="css/botones.css" />



	
<script type="text/javascript" src="js/tinybox.js"></script>
<script type="text/javascript" src="Ajax/Ajax.js"></script>

<!--FIN para ventana modal js-->

	<!--Para que salgan los caracteres con tildes y también las letra ( ñ ) -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
	<script src="js/jquery-1.4.1.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/principal.css" />

	<!-- PARA MENU -------------------------------------------------------------------------
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" /> -->
	<title></title>
	
</head>



<script language="JavaScript">

function SolicitudSelect(Oid,Solicitud,Equipo,Placa,Vehiculo){
parent.document.getElementById('Oid').value=Oid;
parent.document.getElementById('Solicitud').value=Solicitud;
parent.document.getElementById('Equipo').value=Equipo;
parent.document.getElementById('Placa').value=Placa;
parent.document.getElementById('Vehiculo').value=Vehiculo;
parent.document.getElementById('targetDiv').innerHTML='';
parent.TINY.box.hide();

window.parent.DeshabilitarTodo();
//window.parent.IniciarBotonBuscar();

}

</script>



<section class="container_marco">
<div class="marco">
<h2>BUSQUEDA DE SOLICITUDES</h2>


<body onload="document.getElementById('txt_numeroSolicitud').focus()">

<center>


<form name="buscar_solicitud_aceptar" 
action="javascript:buscarAceptar('Ajax/buscar_solicitud_aceptar.php?txt_numeroSolicitud='+buscar_solicitud_aceptar.txt_numeroSolicitud.value,'targetDiv');">

<table>

<tr>
<td>
Numero Solicitud:
</td>
<td>
<input type="text" name="txt_numeroSolicitud" size="35" id="txt_numeroSolicitud" onKeypress="if (event.keyCode == 13)
    {buscar_solicitud_aceptar.btnAceptar.focus();}" />
</td>
</tr>

</table>

<input type="button" name="btnAceptar" value="Aceptar" 
onClick="javascript:buscarAceptar('Ajax/buscar_solicitud_aceptar.php?txt_numeroSolicitud='+buscar_solicitud_aceptar.txt_numeroSolicitud.value,'targetDiv');"
 />


</form>


<div id="targetDiv"></div>

</center>

</div>
</section>


</body>
</html>