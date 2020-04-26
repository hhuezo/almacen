<html>
<head>

  <!--para ventana modal js-->
	<link rel="stylesheet" href="style_tinybox.css" />
	<script type="text/javascript" src="tinybox.js"></script>
    
	<!--FIN para ventana modal js-->


<script type="text/javascript" src="Ajax/Ajax.js"></script>
<link rel="stylesheet" href="css/style_form.css" type="text/css" />
</head>

<script language="JavaScript">
//var modoop=0;


function change_option(parametro){
         switch(parametro){
         case 'btnSalir': document.catalogo_cuenta.action="../index.php"; break;
}
document.catalogo_cuenta.submit();
}

function LimpiarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_cuenta.elements.length;i++){
		if(document.forms.catalogo_cuenta.elements[i].type == "text"){
           document.forms.catalogo_cuenta.elements[i].value='';
        }
		if(document.forms.catalogo_cuenta.elements[i].type == "checkbox"){
           document.forms.catalogo_cuenta.elements[i].value=0;
        }
	}
}

function DeshabilitarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_cuenta.elements.length;i++){
		if(document.forms.catalogo_cuenta.elements[i].type != "button"){
           document.forms.catalogo_cuenta.elements[i].disabled=true;
        }
	}
}

function HabilitarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_cuenta.elements.length;i++){
		if(document.forms.catalogo_cuenta.elements[i].type != "button"){
           document.forms.catalogo_cuenta.elements[i].disabled=false;
        }
	}
}

function IniciarBotones(){
catalogo_cuenta.btnBuscar.disabled=false;
catalogo_cuenta.btnAgregar.disabled=false;
catalogo_cuenta.btnModificar.disabled=true;
catalogo_cuenta.btnEliminar.disabled=true;
catalogo_cuenta.btnGuardar.disabled=true;
catalogo_cuenta.btnCancelar.disabled=true;
catalogo_cuenta.btnSalir.disabled=false;
}

function IniciarBotonAgregar(){
catalogo_cuenta.btnBuscar.disabled=true;
catalogo_cuenta.btnAgregar.disabled=true;
catalogo_cuenta.btnModificar.disabled=true;
catalogo_cuenta.btnEliminar.disabled=true;
catalogo_cuenta.btnGuardar.disabled=false;
catalogo_cuenta.btnCancelar.disabled=false;
catalogo_cuenta.btnSalir.disabled=true;
}

function IniciarBotonModificar(){
catalogo_cuenta.btnBuscar.disabled=true;
catalogo_cuenta.btnAgregar.disabled=true;
catalogo_cuenta.btnModificar.disabled=true;
catalogo_cuenta.btnEliminar.disabled=true;
catalogo_cuenta.btnGuardar.disabled=false;
catalogo_cuenta.btnCancelar.disabled=false;
catalogo_cuenta.btnSalir.disabled=true;
}


function IniciarBotonBuscar(){
catalogo_cuenta.btnBuscar.disabled=false;
catalogo_cuenta.btnAgregar.disabled=true;
catalogo_cuenta.btnModificar.disabled=false;
catalogo_cuenta.btnEliminar.disabled=false;
catalogo_cuenta.btnGuardar.disabled=true;
catalogo_cuenta.btnCancelar.disabled=false;
catalogo_cuenta.btnSalir.disabled=false;
}



</script>

<section class="container">
<div class="login">

<h1>
<?php include_once('titulo_sistema.html');?>
</h1>

<body onLoad="DeshabilitarTodo(); 
IniciarBotones() ">

<center>
<h2>MANTENIMIENTO DE CUENTAS</h2>

<br />
<form name="catalogo_cuenta" method="post">

<table>
<tr>
	<td>
		Cuenta
	</td>
	<td>
		<input type="hidden" name="id_cuenta" id="id_cuenta" size="5" />
		<input type="text" name="txt_cuenta" id="txt_cuenta" size="50" 
		 onBlur="this.value=this.value.toUpperCase();" />
			
		<input type="button" onClick="TINY.box.show({iframe:'catalogo_cuenta_buscar.php' 
			,boxid:'frameless',width:625,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}});
			" name="btnBuscar" value="Buscar" title="Buscar cuenta" />
	</td>
</tr>
<tr>
	<td>
		Codigo
	</td>
	<td>
		<input type="text" name="txt_codigo" id="txt_codigo" size="50" onBlur="this.value=this.value.toUpperCase();" />
	</td>
</tr>
<tr>
	<td>
		Alias
	</td>
	<td>
		<input type="text" name="txt_alias" id="txt_alias" size="50" onBlur="this.value=this.value.toUpperCase();" />
	</td>
</tr>
</table>



<table border="0">

  <tr>
    <td><input type="button" name="btnAgregar" value="Agregar"  size="10" onClick="HabilitarTodo(); IniciarBotonModificar(); LimpiarTodo(); catalogo_cuenta.txt_cuenta.focus(); modoop=1; document.getElementById('targetDiv').innerHTML=''"/></td>
    
    <td><input type="button" name="btnModificar" value="Modificar"   size="10" onClick="
	if (catalogo_cuenta.txt_cuenta.value=='' && catalogo_cuenta.txt_cuenta.value==''){
    	alert('Por favor, Buscar registro a Modificar')
        }
    else{
    	HabilitarTodo(); IniciarBotonModificar(); modoop=2
    }"/>
</td>

    <td><input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
    if (catalogo_cuenta.id_cuenta.value!='') {
    if(confirm('Esta seguro que desea Eliminar este Registro?')) {sendQueryToDelete('catalogo_cuenta_eliminar.php?id_cuenta='+catalogo_cuenta.id_cuenta.value, 'targetDiv'); LimpiarTodo();}
    }
    else alert('Por favor, Buscar registro a Eliminar')"/>
</td>
  </tr>
  <tr>
    <td><input type="button" name="btnGuardar" value="Guardar"   size="10" onClick="
    if (modoop==1)
sendQueryToAdd('catalogo_cuenta_guardar.php?modoop=1&txt_cuenta='+catalogo_cuenta.txt_cuenta.value+'&txt_codigo='+catalogo_cuenta.txt_codigo.value+'&txt_alias='+catalogo_cuenta.txt_alias.value,
'targetDiv');
    if (modoop==2)
sendQueryToEdit('catalogo_cuenta_guardar.php?modoop=2&txt_cuenta='+catalogo_cuenta.txt_cuenta.value+'&txt_codigo='+catalogo_cuenta.txt_codigo.value+'&txt_alias='+catalogo_cuenta.txt_alias.value+
'&id_cuenta='+catalogo_cuenta.id_cuenta.value,
'targetDiv');
IniciarBotones();
"/>
	</td>
    <td><input type="button" name="btnCancelar" value="Cancelar"   size="10" onClick="DeshabilitarTodo(); IniciarBotones()"/></td>
    <td><input type="button" name="btnSalir" value="     Salir    "   size="10" onClick="change_option('btnSalir')"/></td>
  </tr>

</table>

<div id="targetDiv"></div>

</form>

</center>

</body>

</div>
</section>

</html>

