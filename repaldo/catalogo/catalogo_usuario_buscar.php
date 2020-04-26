<?php require_once('conectar/conectar.php'); ?>

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

function usuarioSelect(id_usuario, txt_usuario, txt_clave, id_rol,txt_rol){
parent.document.getElementById('id_usuario').value=id_usuario;
parent.document.getElementById('txt_usuario').value=txt_usuario;
parent.document.getElementById('txt_clave').value=txt_clave;
parent.document.getElementById('id_rol').value=id_rol;
parent.document.getElementById('txt_rol').value=txt_rol;
//parent.document.getElementById('targetDiv').innerHTML='';
parent.TINY.box.hide();
//window.parent.DeshabilitarTodo();
window.parent.IniciarBotonBuscar();

}

</script>

<section class="container_marco">
<div class="marco">

<body onload="document.getElementById('txt_nombre_usuario').focus()">
<center>

<h2>BUSQUEDA DE USUARIOS</h2>

<form name="catalogo_usuario_buscar" 
action="javascript:buscarAceptar('Ajax/catalogo_usuario_buscar_aceptar.php?txt_nombre_usuario='+catalogo_usuario_buscar.txt_nombre_usuario.value,'targetDiv');">

<table>

<tr>
<td>
Equipo:
</td>
<td>
<input type="text" id="txt_nombre_usuario" name="txt_nombre_usuario" size="35" onKeypress="if (event.keyCode == 13)
    {catalogo_usuario_buscar.btnAceptar.focus();}" />
</td>
</tr>

</table>

<input type="button" name="btnAceptar" value="Aceptar" 
onClick="javascript:buscarAceptar('Ajax/catalogo_usuario_buscar_aceptar.php?txt_nombre_usuario='+catalogo_usuario_buscar.txt_nombre_usuario.value,'targetDiv');"/>


</form>



<div id="targetDiv"></div>
</center>
</body>
</html>