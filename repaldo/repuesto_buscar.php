
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

function articuloSelect(Articulo, Nombre,Existencia){
parent.document.getElementById('Articulo').value=Articulo;
parent.document.getElementById('Nombre').value=Nombre;
parent.document.getElementById('Existencia').value=Existencia;
parent.document.getElementById('targetDiv').innerHTML='';
parent.TINY.box.hide();
}

</script>
<section class="container_marco">
<div class="marco">

<h2>BUSQUEDA DE REPUESTOS</h2>

<body onload="document.getElementById('txt_nombre').focus()">

<center>

<form name="catalogo_articulos_buscar"  
action="javascript:buscarAceptar('Ajax/articulo_activo_buscar_aceptar.php?txt_nombre='+catalogo_articulos_buscar.txt_nombre.value,'targetDiv');">

<table>

<tr>
<td>
Articulo:
</td>
<td>
<input type="text" name="txt_nombre" id="txt_nombre" size="35" />
</td>
</tr>

</table>

<input type="button" name="btnAceptar" id="btnAceptar" value="Aceptar" 
onClick="javascript:buscarAceptar('Ajax/articulo_activo_buscar_aceptar.php?txt_nombre='+catalogo_articulos_buscar.txt_nombre.value,'targetDiv');"/>
</form>
<div id="targetDiv"></div>
</center>
</body>

</div>
</section>

</html>