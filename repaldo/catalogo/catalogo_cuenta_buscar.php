
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

function cuentaSelect(id_cuenta,txt_codigo, txt_cuenta,txt_alias){
parent.document.getElementById('id_cuenta').value=id_cuenta;
parent.document.getElementById('txt_codigo').value=txt_codigo;
parent.document.getElementById('txt_cuenta').value=txt_cuenta;
parent.document.getElementById('txt_alias').value=txt_alias;
parent.document.getElementById('targetDiv').innerHTML='';
parent.TINY.box.hide();
window.parent.DeshabilitarTodo();
//window.parent.IniciarBotonBuscar();

}

</script>

<section class="container_marco">
<div class="marco">

<body>


<center>

<h2>BUSQUEDA DE CUENTAS</h2>

<form name="catalogo_cuenta_buscar" 
action="javascript:buscarAceptar('Ajax/catalogo_cuenta_buscar_aceptar.php?txt_nombre='+catalogo_cuenta_buscar.txt_nombre.value,'targetDiv');">

<table>

<tr>
<td>
Cuenta:
</td>
<td>
<input type="text" name="txt_nombre" size="35" onKeypress="if (event.keyCode == 13)
    {catalogo_cuenta_buscar.btnAceptar.focus();}" />
</td>
</tr>

</table>

<input type="button" name="btnAceptar" value="Aceptar" 
onClick="javascript:buscarAceptar('Ajax/catalogo_cuenta_buscar_aceptar.php?txt_nombre='+catalogo_cuenta_buscar.txt_nombre.value,'targetDiv');"/>


</form>



<div id="targetDiv"></div>
</center>
</body>

</div>
</section>

</html>