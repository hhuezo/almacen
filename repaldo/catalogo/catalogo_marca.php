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
         case 'btnSalir': document.catalogo_marca.action="../index.php"; break;
}
document.catalogo_marca.submit();
}

function LimpiarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_marca.elements.length;i++){
		if(document.forms.catalogo_marca.elements[i].type == "text"){
           document.forms.catalogo_marca.elements[i].value='';
        }
		if(document.forms.catalogo_marca.elements[i].type == "checkbox"){
           document.forms.catalogo_marca.elements[i].value=0;
        }
	}
}

function DeshabilitarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_marca.elements.length;i++){
		if(document.forms.catalogo_marca.elements[i].type != "button"){
           document.forms.catalogo_marca.elements[i].disabled=true;
        }
	}
}

function HabilitarTodo(){
	var i;
	for (i=0;i<document.forms.catalogo_marca.elements.length;i++){
		if(document.forms.catalogo_marca.elements[i].type != "button"){
           document.forms.catalogo_marca.elements[i].disabled=false;
        }
	}
}

function IniciarBotones(){
catalogo_marca.btnBuscar.disabled=false;
catalogo_marca.btnAgregar.disabled=false;
catalogo_marca.btnModificar.disabled=true;
catalogo_marca.btnEliminar.disabled=true;
catalogo_marca.btnGuardar.disabled=true;
catalogo_marca.btnCancelar.disabled=true;
catalogo_marca.btnSalir.disabled=false;
}

function IniciarBotonAgregar(){
catalogo_marca.btnBuscar.disabled=true;
catalogo_marca.btnAgregar.disabled=true;
catalogo_marca.btnModificar.disabled=true;
catalogo_marca.btnEliminar.disabled=true;
catalogo_marca.btnGuardar.disabled=false;
catalogo_marca.btnCancelar.disabled=false;
catalogo_marca.btnSalir.disabled=true;
}

function IniciarBotonModificar(){
catalogo_marca.btnBuscar.disabled=true;
catalogo_marca.btnAgregar.disabled=true;
catalogo_marca.btnModificar.disabled=true;
catalogo_marca.btnEliminar.disabled=true;
catalogo_marca.btnGuardar.disabled=false;
catalogo_marca.btnCancelar.disabled=false;
catalogo_marca.btnSalir.disabled=true;
}


function IniciarBotonBuscar(){
catalogo_marca.btnBuscar.disabled=false;
catalogo_marca.btnAgregar.disabled=true;
catalogo_marca.btnModificar.disabled=false;
catalogo_marca.btnEliminar.disabled=false;
catalogo_marca.btnGuardar.disabled=true;
catalogo_marca.btnCancelar.disabled=false;
catalogo_marca.btnSalir.disabled=false;
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
<h2>MANTENIMIENTO DE MARCAS</h2>

<br />
<form name="catalogo_marca" method="post">

<table>

<tr>
<td>
marca
</td>
<td>
<input type="hidden" name="id_marca" id="id_marca" size="5" />
<input type="text" name="txt_marca" id="txt_marca" size="50" 
 onBlur="this.value=this.value.toUpperCase();" />

    
<input type="button" onClick="TINY.box.show({iframe:'catalogo_marca_buscar.php' 
	,boxid:'frameless',width:625,height:450,fixed:false,maskid:'bluemask',maskopacity:40,closejs:function(){}});
	" name="btnBuscar" value="Buscar" title="Buscar marca" />    
    
</td>

</tr>

</table>



<table border="0">

  <tr>
    <td><input type="button" name="btnAgregar" value="Agregar"  size="10" onClick="HabilitarTodo(); IniciarBotonModificar(); LimpiarTodo(); catalogo_marca.txt_marca.focus(); modoop=1; document.getElementById('targetDiv').innerHTML=''"/></td>
    
    <td><input type="button" name="btnModificar" value="Modificar"   size="10" onClick="
	if (catalogo_marca.txt_marca.value=='' && catalogo_marca.txt_marca.value==''){
    	alert('Por favor, Buscar registro a Modificar')
        }
    else{
    	HabilitarTodo(); IniciarBotonModificar(); modoop=2
    }"/>
</td>

    <td><input type="button" name="btnEliminar" value="Eliminar"   size="10" onClick="
    if (catalogo_marca.id_marca.value!='') {
    if(confirm('Esta seguro que desea Eliminar este Registro?')) {sendQueryToDelete('catalogo_marca_eliminar.php?id_marca='+catalogo_marca.id_marca.value, 'targetDiv'); catalogo_marca.txt_marca.value='';}
    }
    else alert('Por favor, Buscar registro a Eliminar')"/>
</td>
  </tr>
  <tr>
    <td><input type="button" name="btnGuardar" value="Guardar"   size="10" onClick="
    if (modoop==1)
sendQueryToAdd('catalogo_marca_guardar.php?modoop=1&txt_marca='+catalogo_marca.txt_marca.value,
'targetDiv');
    if (modoop==2)
sendQueryToEdit('catalogo_marca_guardar.php?modoop=2&txt_marca='+catalogo_marca.txt_marca.value+
'&id_marca='+catalogo_marca.id_marca.value,
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

